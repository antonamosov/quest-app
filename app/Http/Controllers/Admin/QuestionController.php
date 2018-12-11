<?php

namespace App\Http\Controllers\Admin;

use App\Point;
use App\Question;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function getList(Question $question)
    {
        $questions = $question->ownQuestions();

        return view('admin.question.list')->withQuestions($questions);
    }

    public function edit(Question $question)
    {
        $user = Auth::user();

        $admins = $user->getAdmins();

        if ( ! $question->security() )
        {
            return redirect()->back()->withErr('Permission denied');
        }

        return view('admin.question.edit', ['question' => $question, 'admins' => $admins]);
    }

    public function update($questionID, Request $request)
    {
        $question = Question::find($questionID);

        $input = $request->all();

        //dd($input);

        if ( ! $question->security() )
        {
            return redirect()->back()->withErr('Permission denied');
        }

        if($validator = $this->validator($input))
        {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if(Auth::user()->hasRole('admin'))
        {
            $input['user_id'] = (int) $question->setAdmin($input);
        }

        //dd($input);

        $question->update($input);

        return redirect()->route('admin.question.list')->withMsg('Saved successful');
    }

    public function create()
    {
        $user = Auth::user();

        $admins = $user->getAdmins();

        return view('admin.question.create')->withAdmins($admins);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        if($validator = $this->validator($input))
        {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $question = new Question($input);

        $question->user_id = $question->setAdmin($input);

        $question->save();

        return redirect()->route('admin.question.list')->withMsg('Saved successful');
    }

    private function validator($input)
    {
        $validator = Validator::make($input, [
            'name' => 'required',
            'question'  => 'required'
        ]);

        if ( $validator->fails() )
        {
            return $validator;
        }

        return false;
    }

    public function destroy(Question $question)
    {
        if ( ! $question->security() )
        {
            return redirect()->back()->withErr('Permission denied');
        }

        $question->delete();

        return redirect()->route('admin.question.list')->withMsg('Deleted successful');
    }
}

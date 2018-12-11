<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use App\Point;
use App\Question;
use App\Route;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    public function getList(Answer $answer)
    {
        $answers = $answer->ownAnswers();

        return view('admin.answer.list')->withAnswers($answers);
    }

    public function getListInRoute(Point $point)
    {
        $answers = $point->Answers;

        return view('admin.answer.list', [
            'answers' => $answers,
            'routeID' => $point->Route->id
        ]);
    }

    public function edit(Answer $answer, Question $question)
    {
        $user = Auth::user();

        $admins = $user->getAdmins();

        $questions = $question->ownQuestions();

        if ( ! $answer->security() )
        {
            return redirect()->back()->withErr('Permission denied');
        }

        return view('admin.answer.edit', ['questions' => $questions, 'answer' => $answer, 'admins' => $admins]);
    }

    public function update($answerID, Request $request)
    {
        $answer = Answer::find($answerID);

        $input = $request->all();

        if ( ! $answer->security()  )
        {
            return redirect()->back()->withErr('Permission denied');
        }

        if($validator = $this->validator($input))
        {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if(Auth::user()->hasRole('global'))
        {
            $input['user_id'] = (int) $answer->setAdmin($input);
        }

        $answer->update($input);

        return redirect()->route('admin.answer.list')->withMsg('Saved successful');
    }

    public function create(Question $question)
    {
        $questions = $question->ownQuestions();

        $user = Auth::user();

        $admins = $user->getAdmins();

        return view('admin.answer.create', ['admins' => $admins, 'questions' => $questions]);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        if($validator = $this->validator($input))
        {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $answer = new Answer($input);

        $answer->user_id = (int) $answer->setAdmin($input);

        $answer->save();

        return redirect()->route('admin.answer.list')->withMsg('Saved successful');
    }

    public function destroy(Answer $answer)
    {
        if ( ! $answer->security()  )
        {
            return redirect()->back()->withErr('Permission denied');
        }

        $answer->delete();

        return redirect()->route('admin.answer.list')->withMsg('Deleted successful');
    }

    private function validator($input)
    {
        $validator = Validator::make($input, [
            'name' => 'required',
            'answer' => 'required'
        ]);

        if ( $validator->fails() )
        {
            return $validator;
        }

        return false;
    }
}

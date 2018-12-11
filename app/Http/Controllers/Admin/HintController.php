<?php

namespace App\Http\Controllers\Admin;

use App\Hint;
use App\Point;
use App\Question;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HintController extends Controller
{
    public function getList(Hint $hint)
    {
        $hints = $hint->ownHints();

        return view('admin.hint.list')->withHints($hints);
    }

    public function getListInRoute(Point $point)
    {
        $hints = $point->hints;

        return view('admin.hint.list', [
            'hints'   => $hints,
            'routeID' => $point->Route->id
        ]);
    }

    public function edit(Hint $hint, Question $question)
    {
        $user = Auth::user();

        $admins = $user->getAdmins();

        $questions = $question->ownQuestions();

        if ( ! $hint->security() )
        {
            return redirect()->back()->withErr('Permission denied');
        }

        return view('admin.hint.edit', ['questions' => $questions, 'hint' => $hint, 'admins' => $admins]);
    }

    public function update($hintID, Request $request)
    {
        $hint = Hint::find($hintID);

        $input = $request->all();

        if ( ! $hint->security()  )
        {
            return redirect()->back()->withErr('Permission denied');
        }

        if($validator = $this->validator($input))
        {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if(Auth::user()->hasRole('global'))
        {
            $input['user_id'] = (int) $hint->setAdmin($input);
        }

        $hint->update($input);

        return redirect()->route('admin.hint.list')->withMsg('Saved successful');
    }

    public function create(Question $question)
    {
        $questions = $question->ownQuestions();

        $user = Auth::user();

        $admins = $user->getAdmins();

        return view('admin.hint.create', ['admins' => $admins, 'questions' => $questions]);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        if($validator = $this->validator($input))
        {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $hint = new Hint($input);

        $hint->user_id = (int) $hint->setAdmin($input);

        $hint->save();

        return redirect()->route('admin.hint.list')->withMsg('Saved successful');
    }

    public function destroy(Hint $hint)
    {
        if ( ! $hint->security()  )
        {
            return redirect()->back()->withErr('Permission denied');
        }

        $hint->delete();

        return redirect()->route('admin.hint.list')->withMsg('Deleted successful');
    }

    private function validator($input)
    {
        $validator = Validator::make($input, [
            'name' => 'required',
            'hint' => 'required'
        ]);

        if ( $validator->fails() )
        {
            return $validator;
        }

        return false;
    }
}

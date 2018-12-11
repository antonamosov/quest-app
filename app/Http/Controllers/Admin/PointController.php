<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use App\Faq;
use App\Hint;
use App\Image;
use App\Point;
use App\Question;
use App\Route;
use App\StaticMap;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PointController extends Controller
{
    public function getList(Point $point)
    {
        $points = $point->ownPoints();

        return view('admin.point.list')->withPoints($points);
    }

    public function edit(Point $point, Route $route, Question $question)
    {
        if( ! $point->security())
        {
            return redirect()->back()->withErr('Permission denied');
        }

        $routes = $route->ownRoutes();

        //dd($routes);

        $questions = $question->ownQuestions();

        return view('admin.point.edit', ['point' => $point, 'routes' => $routes, 'questions' => $questions]);
    }

    public function update(Point $point, Request $request, Image $image)
    {
        if( ! $point->security())
        {
            return redirect()->back()->withErr('Permission denied');
        }

        $input = $request->all();

        //d($input);

        $input = $image->formAction($input);

        if($validator = $this->validator($input))
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        //dd($input);

        $point->name = $input['name'];

        $point->update($input);

        return redirect()->route('admin.point.list')->withMsg('Saved successful');
    }

    public function updateInRoute(Route $route, Point $point, Request $request, Image $image)
    {
        //dd($request->all());

        if ( ! $route->security())
        {
            return redirect()->back()->withErr('Permission denied.');
        }

        $input = $request->all();

        $input['route_id'] = $route->id;

        $input = $image->formActionPoint($input);

        if($validator = $this->validatorInRoute($input))
        {
            $request->session()->flash('modalErr', 'myModal_POI_edit_' . $point->id);

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $answerArr = $input['answer'];
        $hintArr = $input['hint'];

        //dd($input);

        // Save Question
        //
        $question = $point->Question;
        if($point->Question)
        {
            $question->update ( array_merge ( array_only(
                $input, [
                'paragraph',
                'question']), [

                'image_id' => $input['question_image_id'],
                'user_id'  => $route->user_id
            ]));
        }
        else
        {
            $question = new Question ( array_merge ( array_only(
                $input, [
                'paragraph',
                'question']), [

                'image_id' => $input['question_image_id'],
                'user_id'  => $route->user_id
            ]));

            $question->save();

            $point->question_id = $question->id;
        }



        // Save point
        //
        $point->image_id = $input['image_id'];
        $point->name = $input['name'];

        $point->map_image_id = $image->getMap($point->coordinates, $route->id, $point->id);

        $point->update ( array_merge (array_only(
            $input, [
            'name',
            'coordinates',
            'how_to_get',
            'btw',
            'image_id',
            'map_image_id'
        ]), [
            //'route_id'       => $route->id,
            //'number'         =>  $route->pointsOrder(),
            //'question_id'    => $question->id
        ]));


        // Delete Answers
        //
        $answers = $point->answers;

        foreach ($answers as $answer)
        {
            $answer->delete();
        }
        // Save Answers
        //
        for ($i = 1; $i <= count($answerArr); $i++)
        {
            if ($answerArr[$i])
            {
                $answer = new Answer([
                    'name'          => $answerArr[$i],
                    'question_id'   => $question->id,
                    'user_id'       => $route->user_id,
                    'point_id'      => $point->id
                ]);

                $answer->user_id = $route->user_id;
                $answer->save();
            }
        }

        // Delete Hints
        //
        $hints = $point->hints;

        foreach ($hints as $hint)
        {
            $hint->delete();
        }
        // Save Hints
        //
        for ($i = 1; $i <= count($hintArr); $i++)
        {
            if ($hintArr[$i])
            {
                $hint = new Hint([
                    'name'          => $hintArr[$i],
                    'question_id'   => $question->id,
                    'user_id'       => $route->user_id,
                    'point_id'      => $point->id
                ]);

                $hint->user_id = $route->user_id;
                $hint->save();
            }
        }


        return redirect()->back()->withMsg('POI was successfully added');
    }

    public function create(Route $route, Question $question)
    {
        $routes = $route->ownRoutes();
        $questions = $question->ownQuestions();

        return view('admin.point.create', ['routes' => $routes, 'questions' => $questions]);
    }

    public function store(Request $request, Image $image)
    {
        $input = $request->all();

        //dd($input);

        $input = $image->formAction($input);

        if($validator = $this->validator($input))
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $point = new Point($input);

        $point->name = $input['name'];

        /*$point->map_image_id =*/ $image->getMap($point->coordinates);

        $point->save();

        return redirect()->route('admin.point.list')->withMsg('Saved successful');
    }

    public function storeInRoute(Route $route, Request $request, Image $image)
    {
        //dd($request->all());

        if ( ! $route->security())
        {
            return redirect()->back()->withErr('Permission denied.');
        }

        $input = $request->all();

        $input['route_id'] = $route->id;

        $input = $image->formActionPoint($input);

        if($validator = $this->validatorInRoute($input))
        {
            $request->session()->flash('modalErr', 'myModal_POI_create');

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $answerArr = $input['answer'];
        $hintArr = $input['hint'];

        //dd($input);

        // Save Question
        //
        $question = new Question (array_merge ( array_only(
            $input, [
            'paragraph',
            'question']), [

            'image_id' => $input['question_image_id'],
            'user_id'  => $route->user_id
        ]));

        $question->save();


        // Save point
        //
        $point = new Point (array_merge (array_only(
            $input, [
            'name',
            'coordinates',
            'how_to_get',
            'btw',
            'image_id'
        ]), [
            'route_id'       => $route->id,
            'number'         =>  $route->pointsOrder(),
            'question_id'    => $question->id
        ]));

        $point->image_id = $input['image_id'];
        $point->name = $input['name'];

        $point->save();

        $point->map_image_id = $image->getMap($point->coordinates, $route->id, $point->id);

        $point->save();


        // Save Answers
        //
        for ($i = 0; $i < count($answerArr); $i++)
        {
            if ($answerArr[$i])
            {
                $answer = new Answer([
                    'name'          => $answerArr[$i],
                    'question_id'   => $question->id,
                    'user_id'       => $route->user_id,
                    'point_id'      => $point->id
                ]);

                $answer->user_id = $route->user_id;
                $answer->save();
            }
        }

        // Save Hints
        //
        for ($i = 0; $i < count($hintArr); $i++)
        {
            if ($hintArr[$i])
            {
                $hint = new Hint([
                    'name'          => $hintArr[$i],
                    'question_id'   => $question->id,
                    'user_id'       => $route->user_id,
                    'point_id'      => $point->id
                ]);

                $hint->user_id = $route->user_id;
                $hint->save();
            }
        }

        return redirect()->back()->withMsg('POI was successfully added');
    }

    private function validator($input)
    {
        $validator = Validator::make( $input, [
            'how_to_get'            => 'required',
            'route_id'              => 'required',
            'number'                => 'numeric|required',
            'image_id'              => 'required'
        ]);

        if($validator->fails())
        {
            return $validator;
        }
        else
        {
            return false;
        }
    }

    private function validatorInRoute($input)
    {
        $validator = Validator::make( $input, [
            'name'            => 'required',
            'question'        => 'required',
            'coordinates'     => 'regex:(^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$)'
        ]);

        if($validator->fails())
        {
            return $validator;
        }
        else
        {
            return false;
        }
    }

    public function destroy(Point $point)
    {
        if ( ! $point->security() )
        {
            return redirect()->back()->withErr('Permission denied');
        }

        $point->delete();

        return redirect()->route('admin.point.list')->withMsg('Deleted successful');
    }

    public function destroyInRoute(Route $route, Point $point)
    {
        if ( ! $point->security() || ! $route->security() )
        {
            return redirect()->back()->withErr('Permission denied.');
        }

        $point->delete();

        return redirect()->to('/admin/route/edit/' . $route->id)->withMsg('Deleted successful');
    }

    public function moveUp(Route $route, Point $point, Request $request)
    {
        $queryString = $request->getQueryString() ? '?' . $request->getQueryString() : '';
        $redirectLink = '/admin/route/edit/' . $route->id . $queryString;

        // Checks
        if ( ! $point->security() || ! $route->security() )
        {
            return redirect()->to($redirectLink)->withErr('Permission denied.');
        }

        if($error = $point->moveUp())
        {
            return redirect()->to($redirectLink)->withErr($error);
        }

        // Success
        return redirect()->to($redirectLink)->withMsg('Moved successful');
    }

    public function moveDown(Route $route, Point $point, Request $request)
    {
        $queryString = $request->getQueryString() ? '?' . $request->getQueryString() : '';
        $redirectLink = '/admin/route/edit/' . $route->id . $queryString;

        if ( ! $point->security() || ! $route->security() )
        {
            return redirect()->to($redirectLink)->withErr('Permission denied.');
        }


        if($error = $point->moveDown())
        {
            return redirect()->to($redirectLink)->withErr($error);
        }


        return redirect()->to($redirectLink)->withMsg('Moved successful');
    }
}

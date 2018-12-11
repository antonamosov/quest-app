<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function getList()
    {
        $categories = Category::notVirtual()->get();

        return view('admin.category.list')->withCategories($categories);
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', ['category' => $category]);
    }

    public function update($categoryID, Request $request)
    {
        $category = Category::find($categoryID);

        if( ! $category->security())
        {
            return redirect()->back()->withErr('You can not edit this category.');
        }

        $input = $request->all();

        if($validator = $this->validator($input))
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $input['description'] = trim($input['description']);

        $category->update($input);

        return redirect()->route('admin.category.list')->withMsg('Saved successful');
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        if($validator = $this->validator($input))
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category = new Category($input);

        $input['description'] = trim($input['description']);

        $category->user_id = 0;

        $category->image_id = 0;

        $category->save();

        return redirect()->route('admin.category.list')->withMsg('Saved successful');
    }

    public function destroy($categoryID)
    {
        $category = Category::find($categoryID);

        if( ! $category->security())
        {
            return redirect()->back()->withErr('You can not delete this category.');
        }

        if(count($category->routes))
        {
            return redirect()->back()->withErr('You can not delete category which have any tours');
        }

        $category->delete();

        return redirect()->route('admin.category.list')->withMsg('Deleted successful.');
    }

    private function validator($input)
    {
        $validator = Validator::make( $input, [
            'name'          => 'required',
            'description'   => 'required'
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
}

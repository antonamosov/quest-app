@extends('admin.layout')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <a href="/admin/category"><h2>Categories <small>List of Categories</small></h2></a>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>description</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($categories as $category)
                    <tr>
                        <th scope="row">{{ $category->id }}</th>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td><a href="/admin/category/edit/{{ $category->id }}"><button type="button" class="btn btn-primary btn-xs">Edit</button></a>
                            <a href="/admin/category/delete/{{ $category->id }}"><button type="button" class="btn btn-danger btn-xs">Delete</button></a>
                        </td>
                        <td>
                            <a href="/admin/category/{{ $category->id }}/route"><button type="button" class="btn btn-default btn-xs">Tours</button></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
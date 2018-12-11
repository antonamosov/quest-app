@extends('admin.layout')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <a href="/admin/question"><h2>Questions <small>List of Questions
                    </small></h2></a>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>

                <li><a class="close-link"><i class="fa fa-close"></i></a>
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
                    <th>Question</th>
                    <th>Point</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($questions as $question)
                    <tr>
                        <th scope="row">{{ $question->id }}</th>
                        <td>{{ $question->name }}</td>

                        <td>
                                {{ $question->question}}
                        </td>

                        <td>
                            @if($question->Point)
                                {{ $question->Point->name }}
                            @endif
                        </td>

                        <td>
                            <a href="/admin/question/edit/{{ $question->id }}"><button type="button" class="btn btn-primary btn-xs">Edit</button></a>
                            <a href="/admin/question/delete/{{ $question->id }}"><button type="button" class="btn btn-danger btn-xs">Delete</button></a>
                        </td>
                        <td>
                            @if($question->Point)
                                <a href="/admin/point/edit/{{ $question->Point->id }}"><button type="button" class="btn btn-default btn-xs">Point</button></a>
                            @endif
                            <a href="/admin/question/{{ $question->id }}/hint"><button type="button" class="btn btn-default btn-xs">Hints</button></a>
                            <a href="/admin/question/{{ $question->id }}/answer"><button type="button" class="btn btn-default btn-xs">Answers</button></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
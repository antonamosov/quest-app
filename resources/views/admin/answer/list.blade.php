@extends('admin.layout')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <a href="/admin/answer"><h2>Answers <small>List of Answers
                    </small></h2></a>

            <ul style="margin-left:20px;" class="nav navbar-left panel_toolbox">
                <a href="/admin/route/edit/{{ $routeID }}" class="btn btn-sm btn-primary">Back to tour</a>
            </ul>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?php $nn = 1; ?>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Question</th>
                </tr>
                </thead>
                <tbody>

                @foreach($answers as $answer)
                    <tr>
                        <th scope="row">{{ $nn++ }}</th>
                        <td>{{ $answer->name }}</td>

                        <td>
                            @if($answer->Question)
                                {{ $answer->Question->question }}
                            @endif
                        </td>


                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
@extends('admin.layout')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <a href="/admin/point"><h2>Points <small>List of Points
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
                    <th>Tour</th>
                    <th>Category</th>

                    @if($manager->Role->name === 'global')
                        <th>Partner</th>
                        <th>Sub Domain</th>
                    @endif

                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($points as $point)
                    <tr>
                        <th scope="row">{{ $point->id }}</th>
                        <td>{{ $point->name }}</td>
                        <td>
                            @if($point->getQuestion())
                                {{ $point->getQuestion()->question }}
                            @endif
                        </td>
                       <td>{{ $point->Route->name }}</td>
                         <td>
                            @if($point->Route)
                                @if($point->Route->Category)
                                    {{ $point->Route->Category->name }}
                                @endif
                            @endif
                        </td>

                        @if($manager->Role->name === 'global')
                            <td>
                                @if($point->Route)
                                    @if($point->Route->Partner)
                                        {{ $point->Route->Partner->name }}
                                    @endif
                                @endif
                            </td>
                           <td>
                               @if($point->Route)
                                    @if($point->Route->Partner)
                                        @if($point->Route->Partner->Domain)
                                            {{ $point->Route->Partner->Domain->slug }}
                                        @endif
                                    @endif
                               @endif
                                </td>
                            @endif


                        <td>
                            <a href="/admin/point/edit/{{ $point->id }}"><button type="button" class="btn btn-primary btn-xs">Edit</button></a>
                            <a href="/admin/point/delete/{{ $point->id }}"><button type="button" class="btn btn-danger btn-xs">Delete</button></a>
                        </td>
                        <td>
                            @if($point->Question)
                                <a href="/admin/question/edit/{{ $point->Question->id }}"><button type="button" class="btn btn-default btn-xs">Question</button></a>
                            @endif
                            <a href="/admin/point/{{ $point->id }}/answer"><button type="button" class="btn btn-default btn-xs">Answers</button></a>
                            <a href="/admin/point/{{ $point->id }}/hint"><button type="button" class="btn btn-default btn-xs">Hints</button></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
@extends('admin.layout')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <a href="/admin/partner"><h2>Partners <small>List of Partners</small></h2></a>
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
                    <th>Admin</th>
                    <th>Sub Domain</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($partners as $partner)
                    <tr>
                        <th scope="row">{{ $partner->id }}</th>
                        <td>{{ $partner->name }}</td>
                        <td>
                            @if($partner->User)
                                {{ $partner->User->name }}
                            @endif
                        </td>
                        <td>
                            @if($partner->Domain)
                                {{ $partner->Domain->slug }}
                            @endif
                        </td>
                        <td><a href="/admin/partner/edit/{{ $partner->id }}"><button type="button" class="btn btn-primary btn-xs">Edit</button></a>
                            <a href="/admin/partner/delete/{{ $partner->id }}"><button type="button" class="btn btn-danger btn-xs">Delete</button></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
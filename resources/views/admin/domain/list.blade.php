@extends('admin.layout')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <h2>Sub Domain <small>List of  Sub Domains</small></h2>
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
                    <th>Slug</th>
                    <th>Actions</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @foreach($domains as $domain)
                    <tr>
                        <th scope="row">{{ $domain->id }}</th>
                        <td>{{ $domain->slug }}</td>
                        <td><a href="/admin/domain/edit/{{ $domain->id }}"><button type="button" class="btn btn-primary btn-xs">Edit</button></a>
                            <a href="/admin/domain/delete/{{ $domain->id }}"><button type="button" class="btn btn-danger btn-xs">Delete</button></a>
                        </td>
                        <td>
                            @if($domain->slug === '.')
                                Main Domain
                            @endif
                        <td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
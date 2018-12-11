@extends('admin.layout')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <a href="/admin/point"><h2>Landings <small>List of Landings
                    </small></h2></a>
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
                    <th>Partner</th>
                    <th>Domain</th>
                    <th>Background</th>
                </tr>
                </thead>
                <tbody>

                @foreach($landings as $landing)
                    <tr>
                        <th scope="row">{{ $nn++ }}</th>
                        <td>
                            @if($landing->Partner)
                                {{ $landing->Partner->name }}</td>
                            @endif
                        <td>
                            {{ $landing->getDomainSlug() }}
                        </td>
                        <td>{{ $landing->background }}</td>

                        <td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
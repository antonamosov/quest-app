@extends('admin.layout')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <a href="/admin/route"><h2>Tours <small>List of Tours
                    <?php if(isset($category))
                            {
                                echo ' in <span style="color: red;">' . $category->name . '</span> Category';
                            } ?>
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

                    <th>Name</th>

                    @if($manager->hasRole('global') || $manager->hasRole('admin'))
                        <th>Price</th>
                    @endif

                    <th>Category</th>

                    @if( ($manager->Role->name === 'global') || $manager->Role->name === 'admin' )
                        <th>Contributor</th>
                    @endif

                    @if($manager->Role->name === 'global')
                        <th>Partner</th>
                        <th>Sub Domain</th>
                    @endif

                    @if( ! $manager->hasRole('global'))
                        <th>Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody>

                @foreach($routes as $route)
                    <tr>
                        <th scope="row">{{ $nn++ }}</th>
                        <td>{{ $route->name }}</td>

                        @if($manager->hasRole('global') || $manager->hasRole('admin'))
                            <td>{{ $route->price() }}</td>
                        @endif

                        <td>
                            @if($route->Category)
                                {{ $route->Category->name }}
                            @endif
                        </td>

                        @if( ($manager->Role->name === 'global') || $manager->Role->name === 'admin' )
                            <td>
                                @if($route->Contributor)
                                    {{ $route->Contributor->name }}
                                @endif
                            </td>
                        @endif

                        @if($manager->Role->name === 'global')
                            <td>
                                @if($route->Partner)
                                    {{ $route->Partner->name }}
                                @endif
                            </td>
                            <td>
                                @if($route->Partner)
                                    @if($route->Partner->Domain)
                                        {{ $route->Partner->Domain->slug }}
                                    @endif
                                @endif
                            </td>
                        @endif

                        @if( ! $manager->hasRole('global'))
                            <td>
                                <a href="/admin/route/edit/{{ $route->id }}"><button type="button" class="btn btn-primary btn-xs">Edit</button></a>
                                <a href="/admin/route/delete/{{ $route->id }}"><button type="button" class="btn btn-danger btn-xs">Delete</button></a>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
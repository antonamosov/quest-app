
    <div class="x_panel">
        <div class="x_title">
            @if( \Illuminate\Support\Facades\Request::get('sort') == 'asc' )
                <a href="/admin/route/edit/{{ $route->id }}"><h2>Points </h2></a>
            @else
                <a href="/admin/route/edit/{{ $route->id }}?sort=asc"><h2>Points </h2></a>
            @endif
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>

            @include('admin.route._modal_poi_create')

            <ul class="nav navbar-right">
                <li data-toggle="tooltip" data-placement="left" title="" data-original-title="Add point to Tour">
                    <button data-toggle="modal" data-target="#myModal_POI_create" class="btn btn-warning btn-xs">Add POI</button>
                </li>
            </ul>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Number</th>
                    <th>Order Up / Down</th>
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
                        <th scope="row">{{ $point->number }}</th>
                        <td>
                            <a href="/admin/route/{{ $route->id }}/point/move_up/{{ $point->id }}?{{ $currentQueryString }}"><button type="button" class="btn btn-dark btn-xs">
                                  <span class="docs-tooltip" data-original-title="Up">
                                    <span class="fa fa-arrow-up"></span>
                                  </span>
                            </button></a>

                            <a href="/admin/route/{{ $route->id }}/point/move_down/{{ $point->id }}?{{ $currentQueryString }}"><button type="button" class="btn btn-dark btn-xs">
                                  <span class="docs-tooltip" data-original-title="Down">
                                    <span class="fa fa-arrow-down"></span>
                                  </span>
                            </button></a>
                        </td>
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
                            <button   data-toggle="modal" data-target="#myModal_POI_edit_{{ $point->id }}" class="btn btn-primary btn-xs">Edit</button>
                            <a href="/admin/route/{{ $route->id }}/point/delete/{{ $point->id }}"><button type="button" class="btn btn-danger btn-xs">Delete</button></a>
                            @include('admin.route._modal_poi_edit')
                        </td>
                        <td>
                            <a href="/admin/point/{{ $point->id }}/answer"><button type="button" class="btn btn-default btn-xs">Answers</button></a>
                            <a href="/admin/point/{{ $point->id }}/hint"><button type="button" class="btn btn-default btn-xs">Hints</button></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
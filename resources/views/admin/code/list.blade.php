@extends('admin.layout')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <a href="/admin/code"><h2> Codes <small>List of Codes</small></h2></a>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>

            @if( ! $manager->hasRole('api') )

                @include('admin.code._generate_form')

            @endif

            <ul class="nav navbar-right">
                <li>
                    <button   data-toggle="modal" data-target="#myModal_code_generate" class="btn btn-warning btn-xs">Generate</button>
                </li>
            </ul>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <div class="row">

                <div class="col-md-2">
                 {{ $codes->appends($params->linkAppends)->links() }}
                </div>

                <form method="get" action="">

                    <div class="col-md-2 col-md-offset-7">
                        <label for="sort" style="float:right; margin-right: 10px;">Sort by:
                            <select onchange="sendForm(this.form)" name="sort" id="sort" class="form-control input-sm">
                                <option
                                        @if(\Illuminate\Support\Facades\Input::get('sort') === 'date')
                                        selected="selected"
                                        @endif
                                        value="date">Date
                                </option>
                                <option
                                        @if(\Illuminate\Support\Facades\Input::get('route') === 'tour')
                                        selected="selected"
                                        @endif
                                        value="route">Tour
                                </option>
                            </select>
                        </label>
                    </div>



                @if($manager->hasRole('global') or $manager->hasRole('admin'))
                    <div class="col-md-1">
                        <label for="sort" style="float:right; margin-right: 10px;"><span style="color:white;">generate:</span>
                        <a href="/admin/code/csv?{{ $params->query_string }}" class="btn btn-default buttons-csv buttons-html5 btn-sm" tabindex="0" aria-controls="datatable-buttons"><span>CSV</span></a>
                        </label>
                    </div>
                @endif

                </form>

                <script>
                    function sendForm(form)
                    {
                        form.submit();
                    }

                    $(document).ready(function(){

                        var query = window.location.search.substring(1);
                        var vars = query.split("&");
                        for (var i=0;i<vars.length;i++) {
                            var pair = vars[i].split("=");
                            if(pair[0] == 'sort'){
                                if( $('#sort [value="' + pair[1] + '"]').length ) {
                                    document.querySelector('#sort [value="' + pair[1] + '"]').selected = true;
                                }
                            }
                        }
                    });
                </script>

            </div>


            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Tour</th>
                    <th>Email or Phone</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                <?php $nn = 1; ?>



                @foreach($codes as $code)
                    <tr>
                        <th scope="row">{{ $nn++ }}</th>
                        <td>{{ $code->name }}</td>
                        <td>{{ $code->created_at->format('Y-m-d') }}</td>
                        <td>{{ $code->created_at->format('H:i') }}</td>
                        <td>
                            @if($code->hasRoute())
                                {{ $code->Route->name }}
                            @endif
                        </td>
                        <td>{{ $code->email_or_phone }}</td>
                        <td>
                            <input height="5px" type="checkbox" name="my-checkbox" code_id="{{ $code->id }}"
                                   active="
                                   @if($code->active())
                                           1
                                   @else
                                           0
                                   @endif
                                   "
                            @if($code->active())
                                checked
                            @endif
                            >
                        </td>
                        <td>
                            <a href="/admin/code/delete/{{ $code->id }}"><button type="button" class="btn btn-danger btn-xs">Delete</button></a>
                        </td>
                        @if( ! $manager->hasRole('global'))
                            <td>
                                @if($code->hasRoute())
                                    <a href="/admin/route/edit/{{ $code->Route->id }}"><button type="button" class="btn btn-default btn-xs">Tour</button></a>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="row">

                <div class="col-md-2">
                   {{ $codes->appends($params->linkAppends)->links() }}
                </div>

                @if($manager->hasRole('global') or $manager->hasRole('admin'))
                    <div class="col-md-1 col-md-offset-9">
                        <a href="/admin/code/csv?{{ $params->query_string }}" class="btn btn-default buttons-csv buttons-html5 btn-sm" tabindex="0" aria-controls="datatable-buttons"><span>CSV</span></a>
                    </div>
                @endif

            </div>

        </div>
    </div>

    @if( $manager->hasRole('global') )

        <div class="x_panel">
            <div class="x_title">
                <a href="/admin/code"><h2> Delete codes <small>Delete old codes (older, than 1 year)</small></h2></a>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>

                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <div class="row">

                    <div class="col-md-2">

                        <a href="/admin/code/delete-older-1-year" class="btn btn-danger">Delete codes older 1 year</a>

                    </div>

                </div>

        </div>

    @endif


@endsection
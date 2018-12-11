<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="myModal_code_generate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Generate Code</h4>
            </div>



            <div class="modal-body">

                @if(Session::get('err'))
                    <div class="row">
                        <div class="alert alert-danger" role="alert">
                            {{ trans(Session::get('err')) }}
                        </div>
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="row">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="post" action="/admin/code/generate" class="form-horizontal form-label-left">

                    <!-- Email -->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="route_id"> Tour <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="route_id" id="route_id" class="form-control">
                                @foreach($routes as $route)
                                    <option value="{{ $route->id }}">{{ $route->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button onclick="desc1()" type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
@extends('admin.layout')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <a href="/admin"><h3>Dashboard</h3><a>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    @if($manager->hasRole('global'))

                        <div class="x_title">
                            <h2>Profile <small></small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>
                            <form method="post" action="/admin/profile" class="form-horizontal form-label-left">


                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ \Illuminate\Support\Facades\Auth::user()->email }}" type="email" name="email" id="email" required="required" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">New password <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="" type="password" name="password" id="password" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirm_password">Confirm new password <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="" type="password" name="confirm_password" id="confirm_password" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                    </div>
                                </div>


                                <div class="ln_solid"></div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
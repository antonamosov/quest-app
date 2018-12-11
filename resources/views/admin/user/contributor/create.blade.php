@extends('admin.layout')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <a href="/admin/admin"><h3>Contributors</h3><a>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Create Contributors <small>Create contributors for admins</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br>
                        <form method="post" action="" class="form-horizontal form-label-left">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ old('name') }}" type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ old('email') }}" type="text" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                </div>
                            </div>

                            @if($manager->Role->name === 'global')
                                <div class="form-group">
                                    <label for="partner_id" class="control-label col-md-3 col-sm-3 col-xs-12"> Admin <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select id="partner_id" name="partner_id" class="form-control">
                                            @foreach($admins as $admin)
                                                <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="password" id="password" name="password" required="required" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password_confirm">Confirm Password <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="password" id="password_confirm" name="password_confirm" required="required" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
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
                </div>
            </div>
        </div>
    </div>
@endsection
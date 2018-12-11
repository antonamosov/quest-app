@extends('admin.layout')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <a href="/admin/partner"><h3>Partners</h3><a>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Create Partner <small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br>
                        <form method="post" action="" class="form-horizontal form-label-left">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input name="name" type="text" id="name" required="required" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_id" class="control-label col-md-3 col-sm-3 col-xs-12">Partner Admin</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="user_id" name="user_id" class="form-control">
                                        <option value="0">Not Selected</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="domain_id" class="control-label col-md-3 col-sm-3 col-xs-12">Partner Sub Domain</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="domain_id" name="domain_id" class="form-control">
                                        <option value="0">Not Selected</option>
                                        @foreach($domains as $domain)
                                            <option value="{{ $domain->id }}">{{ $domain->slug }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="max_free">Max Free Tours
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ old('max_free') }}" placeholder="0" type="text" id="max_free" name="max_free" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="max_free">Percentage of revenue payable to the partner
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ old('percent') }}" placeholder="0 - 100" type="text" id="percent" name="percent" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
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
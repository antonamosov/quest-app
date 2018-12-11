@extends('admin.layout')

@section('content')



    <div class="">

        <div class="page-title">
            <div class="title_left">
                <h3><span style="color: red;">{{ $route->name }}</span> Tour</h3>
            </div>
        </div>

        @include('admin.route.point_list')




            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Edit Tour <span style="color: red;"> {{ $route->name }}</span></h2>


                            <ul class="nav navbar-right panel_toolbox">
                                <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>





                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>
                            <form method="post" action="" class="form-horizontal form-label-left" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ $route->name }}" name="name" type="text" id="name" required="required" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Price <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ $route->price() }}" name="price" type="text" id="price" required="required" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea class="form-control" name="description" id="description">{{ $route->description }}</textarea>
                                    </div>
                                </div>




                                @if($manager->Role->name === 'admin' ||  $manager->Role->name === 'global')
                                    <div class="form-group">
                                        <label for="category_id" class="control-label col-md-3 col-sm-3 col-xs-12">Category <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select id="category_id" name="category_id" class="form-control">
                                                @foreach($categories as $category)
                                                    <option
                                                            @if( $category->id == $route->category_id )
                                                                selected="selected"
                                                            @endif
                                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="category_id" value="{{ $route->category_id }}">
                                @endif

                                @if($manager->Role->name === 'admin' ||  $manager->Role->name === 'global')
                                    <div class="form-group">
                                        <label for="contributor_id" class="control-label col-md-3 col-sm-3 col-xs-12">Contributor <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select id="contributor_id" name="contributor_id" class="form-control">
                                                @foreach($contributors as $contributor)
                                                    <option
                                                            @if( $contributor->id == $route->contributor_id )
                                                                selected="selected"
                                                            @endif
                                                            value="{{ $contributor->id }}">{{ $contributor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif


                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Image (Max file size: {{ \App\Image::file_upload_max_size() }}) <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="" name="image" type="file" id="image" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                    </div>
                                </div>

                                <!-- In edit blade -->
                                @if($route->Image)
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Current Image
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <a target="_blank" href="{{ getenv('PUBLIC') }}{{ $route->Image->path }}">{{ $route->Image->name() }}</a>
                                        </div>
                                    </div>
                                @endif

                                @if($route->Miniature)
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="miniature">Miniature
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <a target="_blank" href="{{ getenv('PUBLIC') }}{{ $route->Miniature->path }}">{{ $route->Miniature->name() }}</a>
                                        </div>
                                    </div>
                                @endif

                                <input type="hidden" name="uploaded_image_id" value="{{ $route->image_id }}">


                                <div class="ln_solid"></div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                                        <button onclick="desc()" type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

    </div>
@endsection
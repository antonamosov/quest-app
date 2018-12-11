@extends('admin.layout')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <a href="/admin/route"><h3>Tours</h3><a>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Create tour <small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br>
                        <form method="post" action="" class="form-horizontal form-label-left" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ old('name') }}" name="name" type="text" id="name" required="required" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Price <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ old('price') / 100 }}" name="price" type="text" id="price" required="required" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control" name="description" id="description"></textarea>
                                </div>
                            </div>

                            <script>
                                function desc() {
                                    var text = document.getElementById("editor");
                                    console.log(": " + text.innerHTML);
                                    document.getElementById('descr').value = text.innerHTML ;
                                }
                            </script>

                            @if($manager->Role->name === 'admin' ||  $manager->Role->name === 'global')
                                <div class="form-group">
                                    <label for="category_id" class="control-label col-md-3 col-sm-3 col-xs-12">Category <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select id="category_id" name="category_id" class="form-control">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif



                            @if($manager->Role->name === 'admin' ||  $manager->Role->name === 'global')
                                <div class="form-group">
                                    <label for="contributor_id" class="control-label col-md-3 col-sm-3 col-xs-12">Contributor <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select id="contributor_id" name="contributor_id" class="form-control">
                                            @foreach($contributors as $contributor)
                                                <option value="{{ $contributor->id }}">{{ $contributor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Image (Max file size: {{ \App\Image::file_upload_max_size() }}) <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ old('image') }}" name="image" type="file" id="image" required="required" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                </div>
                            </div>

                            <!-- In edit blade -->
                            <!--<div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <img id="uploaded_image_id" src="">
                                </div>
                            </div>-->


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
@extends('admin.layout')

@section('content')
    <div class="">
        <div class="page-title">

            <div class="title_left">
                <h3>Landing Page</h3>
            </div>


        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Edit Landing <small></small></h2>

                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>



                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <br>
                        <form id="preview_form" method="post" action="/admin/landing/edit/{{ $landing->id }}" class="form-horizontal form-label-left" enctype="multipart/form-data">

                            <script>
                                // Actions when save landing
                                function desc_landing() {
                                    var text3 = document.getElementById("editor2_1");
                                    document.getElementById('descr2_1').value = text3.innerHTML ;


                                }

                                // Actions when preview landing
                                    /*function preview()
                                    {
                                        var text2 = document.getElementById("editor2_1");
                                        document.getElementById('descr2_1').value = text2.innerHTML ;

                                        form=document.getElementById('preview_form');
                                        landingID = '<?php //echo $landing->id; ?>';
                                        form.action='/admin/landing/preview/'+landingID;
                                        form.submit();
                                    }*/

                            </script>

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <div class="col-md-offset-3 col-sm-offset-3 col-xs-offset-3 col-md-6 col-sm-6 col-xs-6">

                                    <button onclick="desc_landing()" type="submit" class="btn btn-success">Save Changes</button>
                                    <a  data-toggle="tooltip" data-placement="right" title="" data-original-title="Changes must be saved first to see them in Preview" target="_blank" class="btn btn-default" href="{{ $landing->landingUrl() }}">Preview</a>
                                    <!--<button onclick="preview()" type="submit" class="btn btn-default">Preview</button>-->
                                </div>
                            </div>

                            <div class="ln_solid"></div>


                            <!-- Header Styles -->
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="header">Header Font
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default <?php if($landing->header_font === 'arial') echo 'active'; elseif(!$landing->header_font) echo 'active'; ?>">
                                            <input <?php if($landing->header_font === 'arial') echo 'checked="checked"'; elseif(!$landing->header_font) echo 'checked="checked"'; ?> type="radio" name="header_font" value="arial" id="arial"> Arial
                                        </label>
                                        <label class="btn btn-default <?php if($landing->header_font === 'times') echo 'active'; ?>">
                                            <input <?php if($landing->header_font === 'times') echo 'checked="checked"'; ?> type="radio" name="header_font" value="times" id="times"> Times
                                        </label>
                                        <label class="btn btn-default <?php if($landing->header_font === 'courier') echo 'active'; ?>">
                                            <input <?php if($landing->header_font === 'courier') echo 'checked="checked"'; ?> type="radio" name="header_font" value="courier" id="courier"> Courier
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="header">Header Font Style
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default <?php if($landing->header_font_style === 'normal') echo 'active'; elseif(!$landing->header_font_style) echo 'active'; ?>">
                                            <input <?php if($landing->header_font_style === 'normal') echo 'checked="checked"'; elseif(!$landing->header_font_style) echo 'checked="checked"'; ?> type="radio" name="header_font_style" value="normal" id="normal"> Normal
                                        </label>
                                        <label class="btn btn-default <?php if($landing->header_font_style === 'italic') echo 'active'; ?>">
                                            <input <?php if($landing->header_font_style === 'italic') echo 'checked="checked"'; ?> type="radio" name="header_font_style" value="italic" id="italic"> Italic
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="header">Header Color
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default <?php if($landing->header_color === 'black') echo 'active'; elseif(!$landing->header_color) echo 'active'; ?>">
                                            <input <?php if($landing->header_font === 'black') echo 'checked="checked"'; elseif(!$landing->header_color) echo 'checked="checked"'; ?> type="radio" name="header_color" value="black" id="black"> Black
                                        </label>
                                        <label class="btn btn-default <?php if($landing->header_color === 'red') echo 'active'; ?>">
                                            <input <?php if($landing->header_color === 'red') echo 'checked="checked"'; ?> type="radio" name="header_color" value="red" id="red"> Red
                                        </label>
                                        <label class="btn btn-default <?php if($landing->header_color === 'blue') echo 'active'; ?>">
                                            <input <?php if($landing->header_color === 'blue') echo 'checked="checked"'; ?> type="radio" name="header_color" value="blue" id="blue"> Blue
                                        </label>
                                        <label class="btn btn-default <?php if($landing->header_color === 'orange') echo 'active'; ?>">
                                            <input <?php if($landing->header_color === 'orange') echo 'checked="checked"'; ?> type="radio" name="header_color" value="orange" id="orange"> Orange
                                        </label>
                                        <label class="btn btn-default <?php if($landing->header_color === 'green') echo 'active'; ?>">
                                            <input <?php if($landing->header_color === 'green') echo 'checked="checked"'; ?> type="radio" name="header_color" value="green" id="green"> Green
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <!-- Header -->
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="header">Header<span style="color:red;"> *</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <textarea class="form-control" name="header" id="header">{{ $landing->header }}</textarea>
                                </div>
                            </div>



                            <!-- Logo Image -->

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="logo_image">Logo (Max file size: {{ \App\Image::file_upload_max_size() }})
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input value="" name="logo_image" type="file" id="logo_image" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                </div>
                            </div>

                            @if($landing->LogoImage)
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="logo_image">Current Logo
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <a target="_blank" href="{{ $landing->LogoImagePath() }}">{{ $landing->LogoImageName() }}</a>
                                        <a data-toggle="tooltip" data-placement="right" title="" data-original-title="Delete image" href="/admin/landing/{{ $landing->id }}/delete/image/?image_type=logo"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                            @endif

                            <input type="hidden" name="uploaded_logo_image_id" value="{{ $landing->logo_image_id }}">


                            <!-- Image text -->

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="image_text">Image text
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <textarea class="form-control" maxlength="350" id="image_text" name="image_text">{{ $landing->image_text }}</textarea>
                                </div>
                            </div>


                            <!-- Main Image -->

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="main_image">Main Image (Max file size: {{ \App\Image::file_upload_max_size() }})
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input value="" name="main_image" type="file" id="main_image" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                </div>
                            </div>

                            @if($landing->MainImage)
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="">Current Main Image
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <a target="_blank" href="{{ $landing->MainImage->path }}">{{ $landing->MainImage->name() }}</a>
                                        <a data-toggle="tooltip" data-placement="right" title="" data-original-title="Delete image" href="/admin/landing/{{ $landing->id }}/delete/image/?image_type=main"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                            @endif

                            <input type="hidden" name="uploaded_main_image_id" value="{{ $landing->main_image_id }}">




                            <script>

                                $("#hsv_editor_header").ColorPickerSliders({
                                    color: "#000",
                                    flat: true,
                                    sliders: false,
                                    swatches: false,
                                    hsvpanel: true,
                                    onchange: function(container, color) {

                                        $('#header-color').attr('data-edit', 'foreColor ' + color.tiny.toHexString());
                                        $('#header-color').click();
                                    }
                                });


                            </script>

                            <!-- FAQ -->

                            <div id="add_faq">

                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="faq">FAQ
                                </label>
                                <?php $i = 0; ?>
                                    @foreach($faqs as $faq)

                                        <?php
                                    if($i == 0)
                                        $offset = '';
                                    else
                                        $offset = 'col-md-offset-3 col-sm-offset-3 col-xs-offset-3';
                                    ?>
                                        <div class="form-group">
                                            <div class="{{$offset  }} col-md-2 col-sm-2 col-xs-2">
                                                <input type="text" placeholder="How do?" class="form-control" name="faq_header[]" id="faq_header[]" value="{{ $faq->section_header  }}">
                                            </div>
                                            <div class=" col-md-4 col-sm-4 col-xs-4">
                                                <textarea placeholder="Do actions" class="form-control" name="faq_txt[]" id="faq_txt[]">{{ $faq->section_txt }}</textarea>
                                            </div>
                                        </div>
                                        <?php $i++; ?>
                                    @endforeach

                                @if($i < 3)
                                    @for(; $i < 3; $i++)

                                        <?php
                                        if($i == 0)
                                            $offset = '';
                                        else
                                            $offset = 'col-md-offset-3 col-sm-offset-3 col-xs-offset-3';
                                        ?>

                                        <div class="form-group {{ $i }}">
                                            <div class="{{$offset  }} col-md-2 col-sm-2 col-xs-2">
                                                <input type="text" placeholder="How do?" class="form-control" name="faq_header[]" id="faq_header[]" value="">
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <textarea placeholder="Do actions" class="form-control" name="faq_txt[]" id="faq_txt[]"></textarea>
                                            </div>
                                        </div>

                                    @endfor
                                @endif


                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-3 col-sm-offset-3 col-xs-offset-3">
                                    <button type="button" onclick="addFaq()" class="btn btn-success btn-sm">Add</button>
                                </div>
                            </div>



                            <script>

                                initialization_editor(1);
                                var s_txt2_new =  $('#descr2_1').val();
                                $('#descr2_1').empty();
                                $("#editor2_1").append(s_txt2_new);

                            </script>


                            <div class="ln_solid"></div>

                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-6 col-md-offset-3">

                                    <button onclick="desc_landing()" type="submit" class="btn btn-success">Save Changes</button>
                                    <button onclick="preview()" type="submit" class="btn btn-default">Preview</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- FAQ -->
            <script>
                var i = 0;
                function cancelFaq()
                {

                }

                function addFaq()
                {
                    if ( document.getElementById("add_faq").childElementCount > 8 )
                    {
                        return;
                    }

                    var fg = document.createElement('div');
                    var cm_header = document.createElement('div');
                    var cm_txt = document.createElement('div');
                    var input = document.createElement("INPUT");
                    var text = document.createElement("TEXTAREA");

                    fg.setAttribute('class', 'form-group');
                    cm_header.setAttribute('class', 'col-md-offset-3 col-sm-offset-3 col-xs-offset-3 col-md-2 col-sm-2 col-xs-2');
                    cm_txt.setAttribute('class', 'col-md-4 col-sm-4 col-xs-4');

                    input.setAttribute("type", "text");
                    input.setAttribute('class', 'form-control');
                    input.setAttribute("placeholder", "How do?");
                    input.setAttribute('name', 'faq_header[]');
                    input.setAttribute('id', 'faq_header[]');

                    text.setAttribute('class', 'form-control');
                    text.setAttribute("placeholder", "Do actions");
                    text.setAttribute('name', 'faq_txt[]');
                    text.setAttribute('id', 'faq_txt[]');

                    cm_header.appendChild(input);
                    cm_txt.appendChild(text);

                    fg.appendChild(cm_header);
                    fg.appendChild(cm_txt);

                    document.getElementById("add_faq").appendChild(fg);
                }

                function increment(){
                    i += 1; /* Function for automatic increment of field's "Name" attribute. */
                }
            </script>

           <!-- <div class="col-md-9 col-sm-9 col-xs-9">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Preview <small>Please press button for preview</small></h2>



                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>

                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a target="_blank" href="{{--{{ $landing->landingUrl() }}--}}">Go to landing</a>
                            </li>
                        </ul>



                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <br>

                       <iframe width="100%" height="5000px" seamless frameborder="0" src="/admin/landing/show/{{--{{ $landing->id }}--}}">

                       </iframe>


                    </div>
                </div>
            </div>-->

        </div>
    </div>
@endsection
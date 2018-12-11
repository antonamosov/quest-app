@extends('admin.layout')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <a href="/admin/answer"><h3>Answers</h3><a>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Edit answer <small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br>
                        <form method="post" action="" class="form-horizontal form-label-left" enctype="multipart/form-data">

                            <!-- Name -->
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ $answer->name }}" name="name" type="text" id="name" required="required" class="form-control col-md-7 col-xs-12" style="cursor: auto;">
                                </div>
                            </div>

                            <!-- Admin -->
                            @if($manager->hasRole('global'))
                                <div class="form-group">
                                    <label for="admin_id" class="control-label col-md-3 col-sm-3 col-xs-12"> Owner of the answer <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select id="admin_id" name="admin_id" class="form-control">
                                            @foreach($admins as $admin)
                                                <option
                                                        @if($admin->id == $answer->user_id)
                                                                selected="selected"
                                                        @endif
                                                        value="{{ $admin->id }}">{{ $admin->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif

                                        <!-- Answer -->
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="answer"> Answer <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="x_content">
                                            <div id="alerts"></div>
                                            <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
                                                <div class="btn-group">
                                                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-edit="fontName Serif" style="font-family:'Serif'">Serif</a></li><li><a data-edit="fontName Sans" style="font-family:'Sans'">Sans</a></li><li><a data-edit="fontName Arial" style="font-family:'Arial'">Arial</a></li><li><a data-edit="fontName Arial Black" style="font-family:'Arial Black'">Arial Black</a></li><li><a data-edit="fontName Courier" style="font-family:'Courier'">Courier</a></li><li><a data-edit="fontName Courier New" style="font-family:'Courier New'">Courier New</a></li><li><a data-edit="fontName Comic Sans MS" style="font-family:'Comic Sans MS'">Comic Sans MS</a></li><li><a data-edit="fontName Helvetica" style="font-family:'Helvetica'">Helvetica</a></li><li><a data-edit="fontName Impact" style="font-family:'Impact'">Impact</a></li><li><a data-edit="fontName Lucida Grande" style="font-family:'Lucida Grande'">Lucida Grande</a></li><li><a data-edit="fontName Lucida Sans" style="font-family:'Lucida Sans'">Lucida Sans</a></li><li><a data-edit="fontName Tahoma" style="font-family:'Tahoma'">Tahoma</a></li><li><a data-edit="fontName Times" style="font-family:'Times'">Times</a></li><li><a data-edit="fontName Times New Roman" style="font-family:'Times New Roman'">Times New Roman</a></li><li><a data-edit="fontName Verdana" style="font-family:'Verdana'">Verdana</a></li></ul>
                                                </div>

                                                <div class="btn-group">
                                                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a data-edit="fontSize 5">
                                                                <p style="font-size:17px">Huge</p>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a data-edit="fontSize 3">
                                                                <p style="font-size:14px">Normal</p>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a data-edit="fontSize 1">
                                                                <p style="font-size:11px">Small</p>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="btn-group">
                                                    <a class="btn" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                                    <a class="btn" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                                    <a class="btn" data-edit="strikethrough" title="" data-original-title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                                    <a class="btn" data-edit="underline" title="" data-original-title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                                                </div>

                                                <div class="btn-group">
                                                    <a class="btn" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                                    <a class="btn" data-edit="insertorderedlist" title="" data-original-title="Number list"><i class="fa fa-list-ol"></i></a>
                                                    <a class="btn" data-edit="outdent" title="" data-original-title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                                                    <a class="btn" data-edit="indent" title="" data-original-title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                                                </div>

                                                <div class="btn-group">
                                                    <a class="btn btn-info" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                                    <a class="btn" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                                    <a class="btn" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                                                    <a class="btn" data-edit="justifyfull" title="" data-original-title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                                                </div>

                                                <div class="btn-group">
                                                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Hyperlink"><i class="fa fa-link"></i></a>
                                                    <div class="dropdown-menu input-append">
                                                        <input class="span2" placeholder="URL" type="text" data-edit="createLink">
                                                        <button class="btn" type="button">Add</button>
                                                    </div>
                                                    <a class="btn" data-edit="unlink" title="" data-original-title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                                                </div>

                                                <div class="btn-group">
                                                    <a class="btn" title="" id="pictureBtn" data-original-title="Insert picture (or just drag &amp; drop)"><i class="fa fa-picture-o"></i></a>
                                                    <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" style="opacity: 0; position: absolute; top: 0px; left: 0px; width: 41px; height: 34px;">
                                                </div>

                                                <div class="btn-group">
                                                    <a class="btn" data-edit="undo" title="" data-original-title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                                                    <a class="btn" data-edit="redo" title="" data-original-title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                                                </div>
                                            </div>

                                            <div id="editor" class="editor-wrapper placeholderText" contenteditable="true">{{ $answer->answer }}</div>

                                            <textarea name="answer" id="descr" style="display:none;"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function desc() {
                                        var text = document.getElementById("editor");
                                        console.log(": " + text.innerHTML);
                                        document.getElementById('descr').value = text.innerHTML ;
                                    }
                                </script>

                                <!-- Question -->
                                <div class="form-group">
                                    <label for="question_id" class="control-label col-md-3 col-sm-3 col-xs-12"> Question, associated with this answer <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select id="question_id" name="question_id" class="form-control">
                                            @foreach($questions as $question)
                                                <option
                                                        @if($question->id == $answer->question_id)
                                                                selected="selected"
                                                        @endif
                                                        value="{{ $question->id }}">{{ $question->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Panel</title>

    <!-- Bootstrap -->
    <link href="/gentelella/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/gentelella/font-awesome.min.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/gentelella/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="/gentelella/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- jVectorMap -->
    <link href="/gentelella/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="/gentelella/custom.min.css" rel="stylesheet">
    <!-- Switch -->
    <link href="{{ getenv('PUBLIC') }}/css/switchery.min.css" rel="stylesheet">
    <link href="/css/bootstrap-switch.css" rel="stylesheet">

    <link href="{{ getenv('PUBLIC') }}/css/style.css" rel="stylesheet">

    <link href="{{ getenv('PUBLIC') }}/css/bootstrap.colorpickersliders.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="/js/jquery.min.js"></script>
    <!-- Switchery -->
    <script src="/js/switchery.min.js"></script>

    <!-- bootstrap-wysiwyg -->
    <script src="{{ getenv('PUBLIC') }}/js/bootstrap-wysiwyg.min.js"></script>
    <script src="{{ getenv('PUBLIC') }}/js/jquery.hotkeys.js"></script>
    <script src="{{ getenv('PUBLIC') }}/js/prettify.js"></script>


    <!-- bootstrap-wysiwyg -->
    <script>
        $(document).ready(function() {
            if($('#editor').length){

                function initToolbarBootstrapBindings() {
                    var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                                'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                                'Times New Roman', 'Verdana'
                            ],
                            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
                    $.each(fonts, function(idx, fontName) {
                        fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
                    });
                    $('a[title]').tooltip({
                        container: 'body'
                    });
                    $('.dropdown-menu input').click(function() {
                                return false;
                            })
                            .change(function() {
                                $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
                            })
                            .keydown('esc', function() {
                                this.value = '';
                                $(this).change();
                            });

                    $('[data-role=magic-overlay]').each(function() {
                        var overlay = $(this),
                                target = $(overlay.data('target'));
                        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
                    });

                    if ("onwebkitspeechchange" in document.createElement("input")) {
                        var editorOffset = $('#editor').offset();

                        $('.voiceBtn').css('position', 'absolute').offset({
                            top: editorOffset.top,
                            left: editorOffset.left + $('#editor').innerWidth() - 35
                        });
                    } else {
                        $('.voiceBtn').hide();
                    }
                }

                function showErrorAlert(reason, detail) {
                    var msg = '';
                    if (reason === 'unsupported-file-type') {
                        msg = "Unsupported format " + detail;
                    } else {
                        console.log("error uploading file", reason, detail);
                    }
                    $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
                            '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
                }

                initToolbarBootstrapBindings();

                $('#editor').wysiwyg({
                    fileUploadError: showErrorAlert
                });

                window.prettyPrint;
                prettyPrint();
            }
        });
    </script>

    <script>
        /*
         Functional for wysiwyg editor on the pages (save and view)
         */

        // Add to textareas (for save)

        var txt2 = [];
        var txt3 = [];
        var txt4 = [];
        var txt5 = [];
        var s_txt2 = [];
        var s_txt3 = [];
        var s_txt4 = [];
        var s_txt5 = [];
        var point = 0;
        function desc_edit(point) {
            txt2[point] = document.getElementById("editor2_" + point);
            txt3[point] = document.getElementById("editor3_" + point);
            txt4[point] = document.getElementById("editor4_" + point);
            txt5[point] = document.getElementById("editor5_" + point);
            //alert(txt2[point]);
            console.log(": " + txt2[point].innerHTML);
            console.log(": " + txt3[point].innerHTML);
            console.log(": " + txt4[point].innerHTML);
            console.log(": " + txt5[point].innerHTML);
            document.getElementById('descr2_' + point).value = txt2[point].innerHTML ;
            document.getElementById('descr3_' + point).value = txt3[point].innerHTML ;
            document.getElementById('descr4_' + point).value = txt4[point].innerHTML ;
            document.getElementById('descr5_' + point).value = txt5[point].innerHTML ;
        }


        function initialization_editor(point)
        {
            $("#editor2_" + point).wysiwyg({toolbarSelector: "#toolbar2_"+point});
            $("#editor3_" + point).wysiwyg({toolbarSelector: "#toolbar3_"+point});
            $("#editor4_" + point).wysiwyg({toolbarSelector: "#toolbar4_"+point});
            $("#editor5_" + point).wysiwyg({toolbarSelector: "#toolbar5_"+point});
        }

        // Add to editors (for view)
        function editor_view(point) {

            s_txt2[point] =  $('#descr2_' + point).val();
            $('#descr2_' + point).empty();
            $("#editor2_" + point).append(s_txt2[point]);

            s_txt3[point] =  $('#descr3_' + point).val();
            $('#descr3_' + point).empty();
            $("#editor3_" + point).append(s_txt3[point]);

            s_txt4[point] =  $('#descr4_' + point).val();
            $('#descr4_' + point).empty();
            $("#editor4_" + point).append(s_txt4[point]);

            s_txt5[point] =  $('#descr5_' + point).val();
            $('#descr5_' + point).empty();
            $("#editor5_" + point).append(s_txt5[point]);
        }

        // Add to editor (for view)

        $(document).ready(function() {
            var s_t = $("#descr").val();
            $("#descr").empty();
            $("#editor").append(s_t);
        });


        // Add to textarea (for save) (one element on the page)
        function desc() {
            var text = document.getElementById("editor");
            console.log(": " + text.innerHTML);
            document.getElementById('descr').value = text.innerHTML;
        }
    </script>




    <script type="text/javascript">

        $(function () {

            $('button.btn-danger').on("click", function (e) {

                if (!confirm("Confirm action")) {
                    e.preventDefault();
                } else {
                    //
                }

            });

            $('.rest_action').click(function (e) {

                e.preventDefault();

                var form = $('<form/>');

                $(form).attr('action', $(this).data('uri'));
                $(form).attr('method', 'post');

                var pseudoMethod = $('<input type="hidden" name="_method"/>');

                if ($(this).data('method') == "GET") {

                    var uri = $(this).data('uri');

                    var query = $(this).data('query');

                    if (query instanceof Object) {

                        var queryPart = [];

                        $.each(query, function (key, value) {

                            queryPart.push(key + '=' + value);

                        });

                        queryPart = queryPart.join('&');

                        uri = uri + '?' + queryPart;

                    }

                    //alert(1);

                    window.location.href = uri;

                    return true;
                }

                if ($(this).data('method').toLowerCase() == "delete") {
                    if (!confirm('Confirm action')) {
                        return false;
                    }
                }

                $(pseudoMethod).attr('value', $(this).data('method'));
                $(form).append(pseudoMethod);

                var query = $(this).data('query');

                if (query instanceof Object) {
                    $.each(query, function (key, value) {

                        $('<input type="hidden" name="' + key + '" value="' + value + '"/>').appendTo(form);

                    });
                }

                //alert($(form).attr('method'));

                $(form).submit();

            });

        });

    </script>
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        @include('admin.left_menu')
        @include('admin.nav_menu')
    </div>
    <div class="right_col" role="main" style="min-height: 1657px;">

        @if(Session::get('modalErr'))
            <?php $modalName = Session::get('modalErr'); ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#'+ '<?php echo $modalName; ?>').modal('show');
                });
            </script>
        @else
                @if(Session::get('err'))
                    <div class="row">
                        <div class="alert alert-danger" role="alert">
                            {{ trans(Session::get('err')) }}
                        </div>
                    </div>
                @endif
                @if(Session::get('msg'))
                    <div class="row">
                        <div class="alert alert-success" role="alert">
                            {{ trans(Session::get('msg')) }}
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
            @endif

        @yield('content')
    </div>
</div>

<!-- Bootstrap -->
<script src="/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/js/fastclick.js"></script>
<!-- Custom Theme Scripts -->
<script src="/js/custom.min.js"></script>
<script src="/js/bootstrap-switch.js"></script>


<!-- NProgress -->
<script src="/js/nprogress.js"></script>
<!-- iCheck -->
<script src="/js/icheck.min.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="/js/moment.min.js"></script>
<script src="/js/daterangepicker.js"></script>
<!-- jQuery Tags Input -->
<script src="/js/jquery.tagsinput.js"></script>
<!-- Select2 -->
<script src="/js/select2.full.min.js"></script>
<!-- Parsley -->
<script src="/js/parsley.min.js"></script>
<!-- Autosize -->
<script src="/js/autosize.min.js"></script>
<!-- starrr -->
<script src="/js/starrr.js"></script>



<script>
    $("[name='my-checkbox']").bootstrapSwitch();


</script>




</body>
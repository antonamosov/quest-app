@extends('showcase.layout')

@section('content')
    <section>


        <div id="quest_prime">

            <div id="quest_area">
                <div class="area">
                    <div class="zone-center">
                        <br><br>
                        <div class="quest_center">
                            <img src="/images/logo-01-1.png" alt="logo">
                            <br><br><br><br><br><br>
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
                            <br>

                            <h1>{{ $point->name }}</h1>

                            <h2>MAP</h2>
                            <img src="{{ $point->coordinates }}">

                            <h2>How to get</h2>
                            <p>{{ $point->how_to_get }}</p>

                            @if($point->question_image_path)
                            <h1>Question Image<h1>
                                <img src="{{ getenv('PUBLIC') }}{{ $point->question_image_path }}">
                            @endif

                            <h2>Question paragraph</h2>
                            <p>{{ $point->question_paragraph }}</p>

                            <h2>Question</h2>
                            <p>{{ $point->question_question }}</p>

                            <h2>BTW</h2>
                            <p>{{ $point->btw }}</p>

                            @if($point->btw_image_path)
                                   <h2>BTW Image<h1>
                                   <img src="{{ getenv('PUBLIC') }}{{ $point->btw_image_path }}">
                            @endif

                            <h2>Hints</h2>
                            @for($i = 1; $i <= $point->count_of_hints; $i++)
                                <a onclick="showHint({{ $i }})" id="hint{{ $i }}" hint="{{ $i  }}" point="{{ Session::get('current_point') }}" href="#">Show hint № {{ $i }}</a>

                                <br>
                            @endfor

                            <?php

                            $prepareUrl = 'http://api.' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN') . '/point/';

                            ?>

                            <script>
                                    function showHint(hintNumber) {
                                                    //alert('ok');
                                        var code = '<?php echo $code; ?>';
                                        var url = '<?php echo $prepareUrl; ?>' + $('#hint' + hintNumber).attr('point') + '/hint/' + hintNumber;// + '?' + 'code=' + code;
                                        var data = {code: code};

                                        jQuery.ajax({
                                            type: 'GET',
                                            url: url,
                                            data: data,
                                            dataType: 'json',
                                            error: function (xhr, status, error) {
                                                console.log("Error in jQuery.ajax while submitting a form:" + error);
                                            },
                                            success: function (data) {
                                                if (data.success) {
                                                    console.log("Ajax action success!");
                                                    //var hint = JSON.parse(data.response);
                                                    console.log(data.response.name);

                                                    if( ! $('#phint' + hintNumber).length )
                                                    {
                                                        var s = 'id="phint' + hintNumber + '"';
                                                        var el = '<p ' + s + '>' + data.response.name + '</p>';
                                                        $('#hint' + hintNumber).after(el);
                                                    }
                                                }
                                            }
                                        });
                                    }


                            </script>

                            <br>

                            <form method="post" action="">
                                <label for="name">Answer:</label>
                                <br>
                                <input name="answer" id="answer" value="{{ old('answer') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <br><br>
                                <button type="submit">Check answer</button>
                            </form>




                            <br><a href="/quest/logout">Exit</a>

                            <br><br><br><br><br><br>
                            <a href="/"><img class="img-link" src="/img/il/i-info-01.png" title="info" alt="info"></a>
                            <br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

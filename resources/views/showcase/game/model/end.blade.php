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

                            <h1>Game over</h1>

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

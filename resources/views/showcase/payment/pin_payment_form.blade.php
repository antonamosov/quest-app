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
                            <br>
                            <div class="quest_div_input">

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


                                <h2>Tour Name:</h2>
                                <p>{{ $route->name }}</p>

                                <h2>Count:</h2>
                                <p>1</p>


                                <h2>Price:</h2>
                                <p>{{ $route->price() }}</p>


                                    <script src="https://cdn.pin.net.au/pin.v2.js"></script>
                                    <a class="pin-payment-button" href="https://pay.pin.net.au/qkbo/test?amount={{ $route->price() }}&amount_editable=false&description={{ $route->name }}&success_url=http://play.{{ getenv('DOMAIN') }}.{{ getenv('MAIN_DOMAIN') }}/quest/pin_payment_action?code={{ $code->id }}&email={{ $email }}">
                                        <img src="https://pin.net.au/pay-button.png" alt="Pay Now" width="86" height="38">
                                    </a>
                            </div>

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

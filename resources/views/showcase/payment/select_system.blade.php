@extends('showcase.payment.layout')

@section('content')

<section>
    <div id="quest_payment">
                
<div id="payment_top" class="area">


<div class="zone-center">
    <br><br><h1><span class="s-circled">3</span>&nbsp;&nbsp;Payment</h1><br><br>
</div>

</div>

<div class="area">
    <br><br>

<div class="zone-center quest_center">
    <br><br>
    <h2>Quest "{{ $route->name }}"</h2>
    <br>
    <h3>Payment: $ {{ $route->price() }}</h3>
    <br><br><br>
    <p>Select your preferred payment method.</p>
    <br><br>
    <div class='color-paypal s-button_01'><a class="s-button type-i-1" href='/get_paypal'>&#xe902;</a></div>
    <script src="https://cdn.pin.net.au/pin.v2.js"></script>
    <div class='color-visa s-button_01'><a class="s-button type-i-1" href="https://pay.pin.net.au/qkbo/test?amount={{ $route->price() }}&amount_editable=false&description={{ $route->name }}&success_url=http://play.{{ getenv('DOMAIN') }}.{{ getenv('MAIN_DOMAIN') }}/quest/pin_payment_action?code={{ $code->name_crypt }}&email={{ $email }}">&#xe906;</a></div>
    <div class='color-mastercard s-button_01'><a class="s-button type-i-1" href="https://pay.pin.net.au/qkbo/test?amount={{ $route->price() }}&amount_editable=false&description={{ $route->name }}&success_url=http://play.{{ getenv('DOMAIN') }}.{{ getenv('MAIN_DOMAIN') }}/quest/pin_payment_action?code={{ $code->name_crypt }}&email={{ $email }}">&#xe901;</a></div>
    <br><br><br><br>
    <p><i class="type-i-3">&#xe98f;</i> Secure payment. We do not store your payment information.</p>
    <br><br><br><br>
    <form id="paypal" action="" method="post" style="display:none">
        <input type="hidden" name="view" value="listen" />
        <input type="hidden" name="tag[]" value="paypal" />
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>

    <form id="pin_payment" action="" method="post" style="display:none">
        <input type="hidden" name="view" value="listen" />
        <input type="hidden" name="tag[]" value="pin_payment" />
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
</div>

</div>


    </div>
</section>

@include('showcase.payment.footer')

@endsection
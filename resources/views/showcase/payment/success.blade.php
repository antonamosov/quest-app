@extends('showcase.payment.layout')

@section('content')

<section>
<div id="quest_payment">
                
<div id="payment_top" class="area">


<div class="zone-center">
    <br><br><h1><span class="s-circled">4</span>&nbsp;&nbsp;Welcome</h1><br><br>
</div>

</div>

<div class="area">
    <br><br>
    <div class="zone-center quest_center">
        <br><br>
        <h3  class="quest_name">You’ve purchased "{{ $route->name }}"</h3>
        <br>
    <p><span class="payment_accent">Soon you will receive a message from us that your code is activated,</span> check your email or phone. After receiving the message you are welcome to play. Press the button “Play The Game”.</p>
            <br><br><br>
            <div class="s-button_02 payment_accent_button"><a class="s-button" href='http://play.{{ getenv('DOMAIN') }}.{{ getenv('MAIN_DOMAIN') }}/'>Play The Game</a></div>
            <br>
            <form id="payment_ok" action="" method="post" style="display:none">
                <input type="hidden" name="view" value="listen" />
                <input type="hidden" name="tag[]" value="payment_ok" />
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
            <br>
            @include('showcase._server_messages')
    </div>
</div>

</div>
</section>

@include('showcase.payment.footer')

@endsection
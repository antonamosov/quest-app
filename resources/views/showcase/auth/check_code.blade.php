@extends('showcase.payment.layout')

@section('content')

<section>
<div id="quest_payment">

<div id="payment_top" class="area">
    <div class="zone-center">
        <br><br><h1><span class="s-circled">2</span>&nbsp;&nbsp;Check</h1><br><br>
    </div>
</div>

<div class="area">
    <br><br>
    <div class="zone-center quest_center">
        <br><br>
        <p>
            <span class="payment_accent">Soon you will receive the code,</span> check your email or phone. Enter the code you have received.
        </p>
        <br><br>
        <p>Enter the code</p>
        <br>
        <div id="verification_game_in">
        <form method="post">            
            <div class="el-div_input">
                <input id="code" name="code" type="text" size="6">
                <button type="submit"><span><i class="txtcolor-004 type-i-4">&#xe98d;</i></span></button>                
            </div>
            <br><p class="payment_accent">&nbsp;</p>
            @include('showcase._server_messages')            
            <br><br>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        </div>
        <p>
            If you had not received the code, probably you entered a wrong email or phone. <a class="payment_href" href="/register">Try again.</a>
            <br><br><br><br>
        </p>
    </div>

</div>

</div>
</section>

@include('showcase.payment.footer')

@endsection
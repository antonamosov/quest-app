@extends('showcase.payment.layout')

@section('content')

<section>
<div id="quest_payment">
                
<div id="payment_top" class="area">

<div class="zone-center">
    <br><br><h1><span class="s-circled">1</span>&nbsp;&nbsp;Registration</h1><br><br>
</div>

</div>

<div class="area">
    <br><br>
<div class="zone-center quest_center">
    <h3 class="quest_name">{{ $route->name }}</h3>
    <br><br>
     <p>To start the process you need to register and get the code. Please enter your email or phone number.</p>
    <br>
<div class="zone-center quest_center txtcolor-001">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
<br><br>
    <div id="verification_email" class="active_cl">
        <br>
        <i class="txtcolor-002 type-i-4">&#xe903;</i>
        <br>
        Get the code by email
        <br><br>
    </div>
    <div id="verification_email_block">
        <br>
        <h3>Get the code by email</h3>
        <p>Enter your email</p>
        <br>        
        <form method="post" novalidate="novalidate">
            <div class="el-div_input el-email_input">
                <input id="email" type="text" name="email" placeholder="mail@site.com" size="20">
                <button type="submit"><span><i class="txtcolor-004 type-i-4">&#xe903;</i></span></button>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
        <br class="email-error">
        </form>
    </div>

    <br><br>
    <div id="verification_sms" class="active_cl">
        <br>
        <i class="txtcolor-002 type-i-4">&#xe908;</i>
        <br>
        Get the code by sms 
        <br><br>
    </div>
    <div id="verification_sms_block">
        <br>
        <h3>Get the code by sms</h3>
        <p>Enter your phone</p>
        <br>
        <form method="post" novalidate="novalidate">
            <div class="el-phone_input">
                <input id="phone" type="text" name="phone" size="14">
                <br><br>
                <button class="s-button_02" type="submit">Send</button>
                <input type="hidden" name="phone_code" id="phone_code" value="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
        <br class="phone-error">
        </form>
        <br>
    </div>    
    <br><br>
    <div id="verification_game" class="active_cl">
        <br>
        <i class="txtcolor-002 type-i-4">&#xe98d;</i>
        <br>
        I’ve got the code to play 
        <br><br>
    </div>
    <div id="verification_game_block">
        <br>
        <h3>If you already have got the code to play</h3>
        <p>Enter the code</p>
        <br>
        <div id="verification_game_in">
        <form method="post">            
            <div class="el-div_input">
                <input id="code" name="code" type="text" size="6">
                <button type="submit"><span><i class="txtcolor-004 type-i-4">&#xe98d;</i></span></button>                
            </div>
            <br><p class="payment_accent">&nbsp;</p>            
            <br><br>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        </div>
        <br>
    </div>
                        
</div>

<div class="zone-center">
    <br><br><br><br>
</div>

</div>

</div>
</section>

@include('showcase.payment.footer')

@endsection

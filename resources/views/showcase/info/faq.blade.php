@extends('showcase.layout')

@section('meta_title')
    <title>{{ $title }}</title>
@endsection


@section('content')

<section>

<div id="middle_catalog">
<div class="area">

<div class="quest_faq zone-center">

<h1>FAQ</h1>

<h3 id="quest-get-key">How to get the code?</h3>
<p>When you choose the quest and press the button “Pay”, first you’ll be redirected to the page Registration. Enter your email or phone (as you prefer). You will get a code via return email or text message. Enter the code and you’ll be redirected to page Payment. After payment your code will be activated and you can play. If it’s a free quest, you can play as soon as you enter the code you’ve received.</p>

<h3>How to play?</h3>
<p>See the <a href="/info/demo/#quest_about_top">demo</a> how to play.</p>

<h3>What to do if the battery is flat in the middle of the quest?</h3>
<p>You can enter the code again on the other phone or tablet. The quest will resume from the point where your battery has become flat. Alternatively it is possible to resume the quest once you have charged your device</p>
<br>
<p>
	Any problems? <a data-uk-modal="{target:'#s-modal'}"href="#">Support</a>
</p>
		
</div>
<div class="zone-col quest_indent-01"></div>
</div>
</div>

</section>

@endsection
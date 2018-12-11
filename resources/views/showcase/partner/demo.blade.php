@extends('showcase.partner.layout')

@include('showcase.partner.header_in')

@section('content')

<section>
<div id="middle_catalog">
<div id="quest_about_top" class="area">

<div class="zone-center quest-center">
	<h1>How to play</h1>
</div>

<div class="zone-col quest_indent-02"></div>

<!-- demo-1 -->

<div class="zone-col2">
	<img src="/landing/img/sl-02-1.jpg" alt="demo">
</div>

<div class="zone-col2">
	<p class="quest-p-02">
		For playing you need a smartphone or a tablet with internet connection. 
		<br>
		1. To play the game you need to get the code. Click or tap "Play" on this page. 
		<br>
		2. You are in the game. Enter the code.
	</p>
</div>

<div class="zone-col quest_indent-01"></div>

<!-- demo-2 -->

<div class="zone-col2">
	<img src="/landing/img/sl-03-1.jpg" alt="demo">
</div>

<div class="zone-col2">
	<p class="quest-p-02">
		The game tour begins! You need to reach the particular place. 
		<br>
		1. Here is the point of destination. Following the instructions reach the point (in some quests this screen may be not presented).
		<br>
		2. Got to the point? Look around and tap “Read the question”.
	</p>
</div>

<div class="zone-col quest_indent-01"></div>

<!-- demo-3 -->

<div class="zone-col2">
	<img src="/landing/img/sl-04-1.jpg" alt="demo">
</div>
	
<div class="zone-col2">
	<p class="quest-p-02">
		You need to answer the question. The question is about the place, where you’ve got to. 
		<br>
		1. Read the question and try to answer.
		<br>
		2. If not sure, see the hints (some quests may be without hints).
	</p>
</div>
	
<div class="zone-col quest_indent-01"></div>

<!-- demo-4 -->

<div class="zone-col2">
	<img src="/landing/img/sl-05-1.jpg" alt="demo">
</div>

<div class="zone-col2">
	<p class="quest-p-02">
		Each screen has gear sign in the bottom. When tap the gear, you see service screen. 
		<br>
		You can always return to the screen where you left off and continue the game, as each your step is memorized.
	</p>
</div>

<div class="zone-col quest_indent-03"></div>

</div>
</div>
</section>

@include('showcase.partner.footer')


@endsection
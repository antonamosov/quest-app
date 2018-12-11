@extends('showcase.partner.layout')

@section('content')

@include('showcase.partner.header')

@include('showcase.partner.offer')

<section>
<div id="middle_catalog">
<div id="quest_about_top" class="area">

<div class="zone-col">
    <div id="offer">
        <div>
            <p class="s-offer-phone">QuestAbout is an alternative to a routine excursion when you have to passively follow your guide and listen. We invite you to a nice independent walking tour! Feel youself an explorer, seeking to reach the goal and find the answer on the spot.
                
        </div>
    </div>
</div>

@if(count($categories) >1)
<div class="zone-col quest-center">    
    @foreach($categories as $category)
    <div id="{{ $category->id }}" class="sorting el-button-01 s-button_01"><a href="#">&nbsp;{{ $category->name }}</a></div>
    @endforeach
    <div style="opacity: 0.3" id="all" class="sorting el-button-01 s-button_01"><a href="#">&nbsp;All</a></div>
</div>
@endif
<div id="thumbnails_top" class="zone-col quest_indent-01"></div>

<div class="zone-col quest_thumbnails">
    @if($categories)
        @foreach($categories as $category)
            @foreach($category->routes as $route)
                @if($route->inDomain($domain))
            <div class="zone-col3 {{ $category->id }}">
                <figure class="uk-overlay uk-overlay-hover">                    
                    @if ($route->miniaturePath())
                        <img src="{{ $route->miniaturePath() }}" width="100%" height="auto">                              
                    @else
                        <img src="landing/img/photo.jpg" width="100%" height="auto">
                    @endif
                    <figcaption class="uk-overlay-panel uk-overlay-background uk-overlay-scale uk-flex uk-flex-center uk-flex-middle quest-center">
                        <div>
                            <p>{{ $category->name }}
                                <br><br>
                                @if (getenv('USE_DOMAIN'))
                                    <img src="landing/img/zoom-01.png" width="40px" height="auto">                              
                                @else
                                    <img src="img/zoom-01.png" width="40px" height="auto">
                                @endif
                            </p>
                            @if (getenv('USE_DOMAIN'))
                                <a class="uk-position-cover" href="/route/{{ $route->id }}#quest_about_top">                              
                            @else
                                <a class="uk-position-cover" href="/landing/petersburg/route/{{ $route->id }}#quest_about_top">
                            @endif
                                </a>
                        </div>
                    </figcaption>
                </figure>
                <p class="quest-center quest-p-01" data-path-page="/route/{{ $route->id }}#quest_about_top">{{ $route->shortName() }}<br>
            (
            @if ($route->price() === 0)
              free
            @else
              {{ $route->price() }} $
            @endif
            )
            </p>
            </div>            
                @endif
            @endforeach
        @endforeach
    @endif
</div>

<div class="zone-col quest_indent-01"></div>

<div class="quest_faq zone-center">
    <h1>FAQ</h1>
    <br>
    <h3 id="quest-get-key">How to get the code?</h3>
    <p>When you choose the quest and press the button “Pay”, first you’ll be redirected to the page Registration. Enter your email or phone (as you prefer). You will get a code via return email or text message. Enter the code and you’ll be redirected to page Payment. After payment your code will be activated and you can play. If it’s a free quest, you can play as soon as you enter the code you’ve received.</p>

    <h3>How to play?</h3>
    <p>See the <a href="/demo/#quest_about_top">demo</a> how to play.</p>

    <h3>What to do if the battery is flat in the middle of the quest?</h3>
    <p>You can enter the code again on the other phone or tablet. The quest will resume from the point where your battery has become flat. Alternatively it is possible to resume the quest once you have charged your device</p>
    <br>
    <p>
        Any problems? <a data-uk-modal="{target:'#s-modal'}"href="#">Support</a>
    </p>

    <br>
    <hr>
    <br>

    @foreach($landing->faqs as $faq)
    <h3>{{$faq->section_header }}</h3>
    <p>{{$faq->section_txt }}</p>
    @endforeach        
</div>

<div class="zone-col quest_indent-01"></div>

</div>
</div>
</section>

@include('showcase.partner.footer')

@endsection
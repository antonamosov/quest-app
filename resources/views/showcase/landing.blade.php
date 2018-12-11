@extends('showcase.layout')

@section('content')

<section>
<div id="middle_catalog">

<div id="offer_load" style="opacity:0.1">
<div class="top-replace">   

<div id="quest_about_top">

<div class="area">
<div class="zone-col">
    
<div id="offer-slide">
    <h1>Fascinating Quests</h1>
    <div class="zone-col quest_indent-01"></div>

    <div id="offer-slide-01">
    <div class="zone-center">
        <a href="/info/about-quest/#discover-something"><div class="of-i-01">
                <img src="/main/img/of-i-01.png">
                <br>Discover something new
            </div></a>
        <a href="/info/about-quest/#have-fun"><div class="of-i-02">
                <img src="/main/img/of-i-02.png">
                <br>Have fun and communicate
            </div></a>
        <a href="/info/about-quest/#play-your"><div class="of-i-03">
                <img src="/main/img/of-i-03.png">
                 <br>Play your game
            </div></a>
    </div>
    </div>

    <div class="zone-col quest_indent-01"></div>
    <div class="zone-col quest-more-button">
        <div class="el-button-03 s-button_02">
            <a href="/info/about-quest/#learn-more">
                Learn more</a>
        </div>
    </div>
</div>


</div><!-- class="zone-col" -->
</div><!-- class="area" -->

</div><!-- id="quest_about_top" -->

</div><!-- class="top-replace" -->
</div><!-- id="offer_load" -->


<div class="quest-lane-01">
<div class="area">
<div class="zone-col">
    <img src="/main/img/il-01.png">
    <h2>When Was Last Time You Experienced an Adventure?<br>
    Discover Something New, Right Now</h2>
</div>    
</div><!-- class="area" -->
</div><!-- class="quest-lane-01" -->

<div id="all-walks" class="area">
<div class="zone-col quest_indent-01"></div>

@if(count($categories) >1)
<div class="zone-col quest-center">    
    @foreach($categories as $category)
    <div @if ($category->id == 1) id="popular" @else id="{{ $category->id }}" @endif class="sorting el-button-01 s-button_01"><a href="#">&nbsp;{{$category->name}}</a></div>
    @endforeach
    <div style="opacity: 0.3" id="all" class="sorting el-button-01 s-button_01"><a href="#">&nbsp;All</a></div>
</div>
@endif
<div id="thumbnails_top" class="zone-col quest_indent-01"></div>

<div class="zone-col quest_thumbnails">
    @if($categories)
        @foreach($categories as $category)
            <?php
            if($category->id == 1)
                $routes = $category->popularRoutes;
            else
                $routes = $category->routes;
            ?>
            @foreach($routes as $route)
                <?php
                if($category->id == 1)
                    $categoryCssClass = $route->Category->id . ' popular';
                else
                    $categoryCssClass = $category->id;

                ?>
            @endforeach


            @foreach($routes as $route)
                @if(!$route->duplicateWithPopular() or $category->id == 1)
                    <?php
                    if($category->id == 1)
                        $categoryCssClass = $route->Category->id . ' popular';
                    else
                        $categoryCssClass = $category->id;
                    ?>
                    <div class="zone-col3 {{ $categoryCssClass }}">
                    <figure class="uk-overlay uk-overlay-hover">
                        @if ($route->miniaturePath())
                            <img src="{{ $route->miniaturePath() }}" width="100%" height="auto">
                        @else
                            <img src="/main/img/photo.jpg" width="100%" height="auto">
                        @endif
                        <figcaption class="uk-overlay-panel uk-overlay-background uk-overlay-scale uk-flex uk-flex-center uk-flex-middle quest-center">
                            <div>
                                <p>@if($category->id != 1){{ $category->name }}@else{{ $route->Category->name }}@endif
                                    <br><br>
                                    <img src="/main/img/zoom-01.png" width="40px" height="auto">
                                </p>
                                <a class="uk-position-cover" href="{{ $route->url() }}/route/{{ $route->id }}#quest_about_top"></a>
                            </div>
                        </figcaption>
                    </figure>
                    <p class="quest-center quest-p-01" data-path-page="{{ $route->url() }}/route/{{ $route->id }}#quest_about_top">{{ $route->shortName() }}<br>
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

</div><!-- id="all-walks" class="area"> -->
</div><!-- id="middle_catalog" -->

</section>

@endsection
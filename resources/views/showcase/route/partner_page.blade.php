@extends('showcase.partner.layout')

@include('showcase.partner.header_in')

@section('content')

<section>
<div id="middle_catalog">
    <div id="quest_about_top" class="area">
    <div class="quest_description zone-center">            
            <br>
            <h1>{{ $route->name }}</h1>
            <br>
            <div class="el-button-02 s-button_02">                
                @if ($route->price() === 0)
                  <a href=" http://play.{{ getenv('DOMAIN') }}.{{ getenv('MAIN_DOMAIN') }}/quest/redirect?route_id={{ $route->id }}"><span>☺</span>&nbsp;play free
                @else
                  <a href=" http://play.{{ getenv('DOMAIN') }}.{{ getenv('MAIN_DOMAIN') }}/quest/redirect?route_id={{ $route->id }}"><span>{{ $route->price() }}$</span>&nbsp;buy
                @endif
                 </a>
            </div>
            <p>
                <br>
                @if ($route->price() !== 0)
                  Price: {{ $route->price() }} $
                  <br>
                @endif

                Category: {{ $route->Category->name }}
                <br>
                {!! $route->description !!}
                <br><br>
                <img src="{{ $route->Image->path }}" alt="" width="100%" height="auto">
            </p>
            <br>
            <br>
            <div class="el-button-02 s-button_02">                
                @if ($route->price() === 0)
                  <a href=" http://play.{{ getenv('DOMAIN') }}.{{ getenv('MAIN_DOMAIN') }}/quest/redirect?route_id={{ $route->id }}"><span>☺</span>&nbsp;play free
                @else
                  <a href=" http://play.{{ getenv('DOMAIN') }}.{{ getenv('MAIN_DOMAIN') }}/quest/redirect?route_id={{ $route->id }}"><span>{{ $route->price() }}$</span>&nbsp;buy
                @endif
                 </a>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
    </div>
    </div>
</div>
</section>

@include('showcase.partner.footer')


@endsection
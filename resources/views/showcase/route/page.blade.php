@extends('showcase.layout')

@include('showcase.header')

@section('content')

        <!-- section -->
<section>

    <!-- middle -->
    <div id="middle_catalog">
        <div id="quest_about_top" class="area">

            <div class="zone-center">
                <br>
                <br>
                <h1>{{ $route->name }}</h1>
                <p>
                    <br>
                    Price: {{ $route->price() }} $
                    <br>
                    Category: {{ $route->Category->name }}
                    <br>
                    {!! $route->description !!}
                    <br><br>
                    <img src="{{ $route->imagePath() }}" width="100%" height="auto">
                    <br><br>
                    To get the code send the email to <a data-uk-modal="{target:'#s-modal'}" href="#">support</a>
                    <br><br>
                </p>
            </div>
        </div><!-- class="area" -->
    </div><!-- id="middle_catalog" -->
</section>




@include('showcase.footer')


@endsection


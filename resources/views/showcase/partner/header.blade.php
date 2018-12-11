<div id="header_1">
<div  class="area top-menu">
            <div class="zone-col3 quest-call">
            <div  data-uk-modal="{target:'#s-modal'}">
                <img src="/landing/img/i-call-02.png" alt="call"><br>
                Support
            </div>
        </div>
        <div class="zone-col3 quest-logo">
            <img src="/landing/img/logo-01-2.png" alt="logo">   
        </div>
        <div class="zone-col3 quest-go">
            <a href="http://play.{{ getenv('DOMAIN') }}.{{ getenv('MAIN_DOMAIN') }}/"><img src="/landing/img/i-go-02.png" alt="game"><br>
                Play The Game
            </a>    
        </div>  
</div>
<div  class="area">
        <div class="zone-col quest-offer" style="font-family: {{ $landing->header_font }}; font-style: {{ $landing->header_font_style }}; color: {{ $landing->header_color }}">
            @if($landing->checkFields())
                {!! $landing->header !!}
            @else
                {!! $domain->Partner->name !!}
            @endif
        </div>  
</div>
</div>
<header>
<div id="header_1">
    <div  class="area top-menu">
        <div class="zone-left-10">
    <div id="top-logo">
        <a href="/"><img src="/main/img/logo-01-2.png" alt="logo"></a>
    </div>  
</div><div class="zone-left-20">
    <ul id="top-menu">
        <li><a @if($currentSlag == '/') class="s-menu-active" @endif href='/'>Home</a></li>
        <li><a href='http://{{ getenv('DOMAIN') }}.{{ getenv('MAIN_DOMAIN') }}/info/main/#all-walks'>All walks</a></li>
        @foreach($menuList as $menuName => $menu)
            @if(!isset($menu['off']))
                <li><a @if($menu['slag'] == $currentSlag) class="s-menu-active" @endif href='{{ $currentUrl }}/info/{{ $menu['slag'] }}'>{{ $menuName }}</a></li>
            @endif
         @endforeach  
    </ul>
    <div class="button-phone-menu" data-uk-offcanvas="{target:'#offcanvas-1'}" style="display:none">    
        <b>&equiv;</b><span>&nbsp;MENU</span>
    </div>
</div>  </div>
</div>
</header>


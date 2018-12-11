<footer>
<div id="footer_1">
    <div  class="area">

<div class="zone-center">
    <div id="bottom-logo">
        <a href="/"><img src="/main/img/logo-01-2.png" alt="logo"></a>
    </div>  
</div><div class="zone-col2">   
    <div class="botton-links">
        <a data-uk-modal="{target:'#s-modal-contact'}" href="#">Contact information</a>
        <a data-uk-modal="{target:'#s-modal-information'}" href="#">Official information</a>
        <a data-uk-modal="{target:'#s-modal-policy'}" href="#">Privacy policy</a>
    </div>
</div><div class="zone-col2">   
    <ul class="social-network">
        <li><a href="https://facebook.com" class="s_facebook" title="Facebook"><span><img src="/main/img/sprite-i01.png"></span></a></li>
        <li><a href="https://twitter.com" class="s_twitter" title="Twitter"><span><img src="/main/img/sprite-i01.png"></span></a></li>
        <li><a href="https://plus.google.com" class="s_google" title="Google Plus"><span><img src="/main/img/sprite-i01.png"></span></a></li>
        <li><a href="https://instagram.com" class="s_instagram" title="Instagram"><span><img src="/main/img/sprite-i01.png"></span></a></li>
    </ul>
</div>
<div class="zone-col">
    <div class="s-no-js_0">
        <p>
            <br>
            <span>The site was opened in the mini version,</span>
            <span class="s-no-js-span1">to complete the work site enable JavaScript in your browser.</span>
            <span class="s-no-js-span2">you may have an outdated browser or a slow Internet connection.</span>
            <br>  
        </p>
        <ul>
            <li><a @if($currentSlag == '/') style="color:#95c5ee" @endif href='/'>Home</a></li>
            <li><a href='http://{{ getenv('DOMAIN') }}.{{ getenv('MAIN_DOMAIN') }}/info/main/#all-walks'>All walks</a></li>
            @foreach($menuList as $menuName => $menu)
            @if(!isset($menu['off']))         <li><a @if($menu['slag'] == $currentSlag) style="color:#95c5ee" @endif href='{{ $currentUrl }}/info/{{ $menu['slag'] }}'>{{ $menuName }}</a></li>             @endif
             @endforeach        
        </ul>
        <br>
        <br>
            <span>Support: info@questabout.com.au</span>
        <br>
    </div>
</div><!-- class="zone-col" -->
        <div class="zone-col">
            <div class="button-phone-menu-botton" data-uk-offcanvas="{target:'#offcanvas-1'}" style="display:none">
                <b title="Menu">≡</b>
            </div>
            <div id="s-modal" class="uk-modal">
                <div class="uk-modal-dialog">
                    <p class="s-modal-close">
                        <a class="uk-modal-close"><span>&times;&nbsp;</span></a>
                    </p>
                    <p class="s-modal-offer">
                        <br>
                            Support:<br><br>
                            <a class="s-info" href="mailto:info@questabout.com.au">info@questabout.com.au</a><br><br><br>
                            <img src="/main/img/logo-01-1.png" alt="logo"><br>
                    </p>
                </div>
            </div>
            <div id="s-modal-contact" class="uk-modal">
                <div class="uk-modal-dialog">
                    <p class="s-modal-close">
                        <a class="uk-modal-close"><span>&times;&nbsp;</span></a>
                    </p>
                    <p class="s-modal-offer">
                        <br>
                            Contact information:<br><br>
                            <a class="s-info" href="mailto:info@questabout.com.au">info@questabout.com.au</a><br><br><br>
                            <img src="/main/img/logo-01-1.png" alt="logo"><br>
                    </p>
                </div>
            </div>
            <div id="s-modal-information" class="uk-modal">
                <div class="uk-modal-dialog">
                    <p class="s-modal-close">
                        <a class="uk-modal-close"><span>&times;&nbsp;</span></a>
                    </p>
                    <p class="s-modal-offer">
                        <br>
                            Official information:<br><br>
                            <span>Sydney Australia is one of the world’s most loved cities and it has a lively and vibrant buzz that makes it the ultimate destination throughout the year. There are always plenty of things to do in Sydney whether it's summer, winter, autumn or spring – from world-class dining, shows and entertainment, to sightseeing and great walks or fun in the sand at one of Sydney's idyllic beaches.</span><br><br><br>
                            <img src="/main/img/logo-01-1.png" alt="logo"><br>
                    </p>
                </div>
            </div>
            <div id="s-modal-policy" class="uk-modal">
                <div class="uk-modal-dialog">
                    <p class="s-modal-close">
                        <a class="uk-modal-close"><span>&times;&nbsp;</span></a>
                    </p>
                    <p class="s-modal-offer">
                        <br>
                            Privacy policy:<br><br>
                            <span>By using Google services, you trust us with your personal data. To find out what information we collect and how we use it, please read our privacy policy. And on the My Account page you will find all the necessary settings and tools to protect data and privacy.</span><br><br><br>
                            <img src="/main/img/logo-01-1.png" alt="logo"><br>
                    </p>
                </div>
            </div>
            <div id="offcanvas-1" class="uk-offcanvas">
                <div class="uk-offcanvas-bar">
                    <ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon" data-uk-nav>
                        <li><a @if($currentSlag == '/') style="color:#95c5ee" @endif href='/'>Home</a></li>
                        <li><a href='http://{{ getenv('DOMAIN') }}.{{ getenv('MAIN_DOMAIN') }}/info/main/#all-walks'>All walks</a></li>
                        @foreach($menuList as $menuName => $menu)
                        @if(!isset($menu['off']))         <li><a @if($menu['slag'] == $currentSlag) style="color:#95c5ee" @endif href='{{ $currentUrl }}/info/{{ $menu['slag'] }}'>{{ $menuName }}</a></li>             @endif
                         @endforeach                  
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</footer>
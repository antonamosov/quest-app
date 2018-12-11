<!DOCTYPE html>
<html id="run" class="landscape"  data-path-site="main" data-path-page="landing">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="format-detection" content="telephone=no">
<!-- Favicon -->
<link href="/main/img/favicon.ico" rel="shortcut icon">
<!-- Meta Tags -->
@yield('meta_title')
<meta name="description" content="Take part in a quest game - see the sights, guess riddles and learn many interesting things.">
<meta name="keywords" content="questabout, quest, game, game tours, walking tours">
<!-- Link -->
<link rel='stylesheet' type='text/css' href='/main/load/in.css'>
</head><body id="main"
class="bit">
<script>
    if (window.getComputedStyle) {
        document.body.style.opacity="1";
        if (getComputedStyle(document.body)) {
            document.body.style.opacity="0";setTimeout(function(){document.body.style.opacity="1"},300);    
        };
    };
</script>
@include('showcase.header')
@yield('content')
@include('showcase.footer')
<script type='text/javascript' src='/main/load/in.js'></script>
</body></html>
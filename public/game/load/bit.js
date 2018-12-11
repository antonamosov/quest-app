siteDataSet.a_test&&a_test_data.push("01-el-pl-current/00_make.js"),function(e){}(jQuery),siteDataSet.a_test&&a_test_data.push("01-el-pl-current/00_plug.js"),function(e){function s(){localStorage.removeItem("quest_code"),localStorage.removeItem("quest_point"),w=1,f=void 0,g()}function t(){return siteDataSet.test_localstorage?(localStorage.setItem("quest_code",k),localStorage.setItem("quest_point",w)):d(),!1}function i(){siteDataSet.test_localstorage?localStorage.getItem("quest_code")&&localStorage.getItem("quest_point")?(k=localStorage.getItem("quest_code"),w=localStorage.getItem("quest_point"),r("route",w)):g():d()}function n(s,t){if(e(s).blur(),e(s).val()){var i=e(s).val();e(s).val(""),i=i.slice(0,t),value_str_input=i.replace(/\s/g,""),0===value_str_input.length&&(i=!1)}else i=!1;return i}function a(s,t){e("body").fadeTo(300,.33),setTimeout(function(){e(s).replaceWith(t),window.scrollTo(0,0),e("body").fadeTo(300,1)},500)}function r(s,t){var i="full-route",n={code:k,point:w};"answer"===s&&(i="point/"+w+"/answer",n={code:k,answer:t}),"reset"===s&&(i="reset",n={code:k});e.ajax({url:i,type:"get",dataType:"json",cache:!1,data:n}).done(function(e){"route"===s&&o(e),"answer"===s&&c(e,t),"reset"===s&&u(e)}).fail(function(){f=!1,d()}).always(function(){})}function o(e){f=e,void 0!==f&&(f.success===!0?(w=f.response.current_point,t(),1==w?_():0==w?q():m()):g())}function c(e,s){e.success===!0?(w<f.response.count_of_points?w++:w=0,t(),b()):y===!1?(f=!1,d()):l(s)}function u(e){e.success===!0?r("route",!1):d()}function l(s){var t=e("#quest_item_answer").text(),i=e("#quest_number_answer").text();if(e("#quest_status_answer").text(" wrong. You have attempts: "),i-=1,i>0){y=!0,t=t+" "+s+" — ",e("#quest_item_answer").text(t),e("#quest_number_answer").text(i);var n=e("#offset_indent-01").offset().top;e("html,body").animate({scrollTop:n},"fast")}else y=!1,r("answer",f.response.correct_answer)}function p(s){e(s).css("opacity","0.3"),setTimeout(function(){e(s).css("opacity","1")},300)}function d(){var e="The problem with the browser",s="Required technologies are not supported with Safari and some other browsers in private mode, try the game in the standard mode. If that doesn’t work, try the game in another browser. Remember, some browsers, such as Opera&nbsp;Mini, Internet&nbsp;Explorer&nbsp;8, don’t support required technologies.";f===!1&&(e="Sorry, the problem with data",s="We try to fix the problem as soon as possible.");var t='<div id="quest_area"><div class="area"><div class="zone-center"><div><br><br><p  id="quest_data" data-see-storage="0" style="color:#ABABAB"><br><br>QuestAbout<br><br></p><h1 style="color:#ABABAB">'+e+'</h1><p style="color:#ABABAB"><br><br>'+s+'<br><br>Support: info@questabout.com.au Find more information about the game: <a style="color:#ABABAB; text-decoration: underline;" href="http://questabout.com.au">questabout.com.au</a></p></div></div></div></div>';a("#quest_area",t)}function g(){var e="<br><br><br>";void 0!==f&&(e='<div id="quest_error_code"><br>'+f.error.message+"<br><br><span>"+f.error.code+"</span></div>");var s='<div id="quest_area"><div class="area quest-background-01"><div class="zone-center"><br><br><div class="quest_center"><img src="/game/img/logo-01-1.png" alt="logo"><br><br><br><br><br><br><div class="quest_div_txt">Enter the code</div><br><div class="quest_div_input"><input id="quest_input_key" type="text" size="6"><span id="quest_key"><img class="img-link" src="/game/img/i-key-01.png" title="send" alt="send"></span></div>'+e+'<br><br><br><br><a class="s-info" href="mailto:info@questabout.com.au">info@questabout.com.au</a><br><br></div></div></div></div>';a("#quest_area",s)}function _(){var e='<div id="quest_area"><div class="area quest-background-01"><div class="zone-center quest_center"><br><br><br><img class="koala" src="/game/img/koala-01.png" alt="koala"><br><br><br><div class="quest_div_txt">You are in<br><span class="quest_span_title">'+f.response.route_name+'</span><br><br><br><br><br>Ready for a fascinating walk?<br></div><span id="quest_welcome"><img class="img-link" src="/game/img/i-go-01.png" title="go" alt="go"></span><br><br><br><br><img class="logo-opacity" src="/game/img/logo-01-1.png" alt="logo"><br><br><br><br><span class="quest_button_title">Exit</span><br><span id="quest_exit"><img class="img-link" src="/game/img/i-exit-01.png" title="exit" alt="exit"></span></div><div class="zone quest_indent-01"></div></div></div>';a("#quest_area",e)}function m(){if(f.response.coordinates===!1&&f.response.how_to_get===!1)v();else{var e='<div class="zone-center">',s='<div class="zone-center">';f.response.coordinates&&f.response.how_to_get&&(e='<div class="zone-left-10">',s='<div class="zone-right-20">'),f.response.coordinates&&!f.response.how_to_get&&(e='<div class="zone-left-10">',s='<div class="zone-right-20">');var t="";f.response.coordinates&&(t=e+'<img class="route_map" src="'+f.response.coordinates+'"></div>');var i="";f.response.how_to_get&&(i="<p>"+f.response.how_to_get+"</p>");var n="Let's start ";w>1&&(n="Go ahead ");var r='<div id="quest_area"><div class="area quest-background-02"><div class="zone quest_indent-01"></div>'+t+s+"<h1><span>"+n+w+"/"+f.response.count_of_points+"</span><br>"+f.response.question_name+"</h1>"+i+'</div><div class="zone quest_indent-01"></div></div><div class="area  quest-footer-01"><div class="zone quest_indent-02"></div><div class="zone-center quest-footer-01"><p>Read the question<span id="quest_of_route"><br><br><img class="img-link" src="/game/img/i-go-01.png" title="go" alt="go"></span><br><br><br><img class="logo-opacity" src="/game/img/logo-01-1.png" alt="logo"><br><br><br><span id="guest_in_service"><img class="img-link" src="/game/img/i-service-01.png" title="service" alt="service"></span></p></div><div class="zone quest_indent-03"></div></div></div>';a("#quest_area",r)}}function v(){y=!0;var e='<div class="zone-center">',s='<div class="zone-left-10"><div id="question_toggle">',t='<span id="question_toggle_button">',i="</span>",n='</div></div><div class="zone-right-20">',r='<span id="quest_status_answer"> You have attempts: </span>',o="5",c='<img class="question_img" src="'+f.response.question_image_path+'">',u='<img class="question_map" style="display:none" src="'+f.response.coordinates+'">',l='<img class="img-link" style="display:none" src="/game/img/i-img-01.png">',p='<img class="img-link" src="/game/img/i-map-01.png">';f.response.question_image_path&&f.response.coordinates&&(e=s+c+u+t+l+p+i+n),f.response.question_image_path&&!f.response.coordinates&&(e=s+c+n),!f.response.question_image_path&&f.response.coordinates&&(p='<img class="img-link" src="/game/img/i-map-01.png"><img class="img-link" style="display:none" src="/game/img/i-map-02.png" alt="map">',e=s+u+t+p+i+n);var d="";f.response.question_paragraph&&(d=f.response.question_paragraph+"<br><br>");var g="",_="",m="",v='</span><br><br><span id="hint_txt"></span>';f.response.hints_01&&(g='<div class="zone-center quest_center quest_hint_div">Hints<br><br><img class="koala" src="/game/img/koala-01.png" alt="koala"><br><br><div id="quest_hint_item">',_="</div></div>",m='<span id="hint_01_active"><img class="img-link" src="/game/img/i-hint-01-1.png"></span>');var b="";f.response.hints_02&&(b='<span id="hint_02_closed"><img src="/game/img/i-hint-02-2.png"></span>');var q="";f.response.hints_03&&(q='<span id="hint_03_closed"><img src="/game/img/i-hint-03-2.png"></span>',v='<br><br><span id="hint_txt">The third hint is the answer.</span>');var h='<div id="quest_area"><div class="area quest-background-06"><div class="zone quest_indent-01"></div>'+e+"<h1><span>Question "+w+"/"+f.response.count_of_points+"</span><br>"+f.response.question_name+"</h1><p>"+d+"<strong>"+f.response.question_question+'</strong></p></div><div class="zone quest_indent-01"></div></div><div id="offset_indent-01" class="area quest-background-03"><div class="zone quest_indent-01"></div><div id="quest_answer_zone" class="zone-center">Type your answer<br><br><div class="quest_div_answer"><div><input id="quest_input_answer" type="text"><span id="quest_answer"><img class="img-link" src="/game/img/i-send-01.png" title="send" alt="send"></span></div></div><img id="quest_use_answer" class="img-use" src="/game/img/i-use-01.png" title="send" alt="send"><div id="quest_block_answer"><span id="quest_item_answer"></span>'+r+'<span id="quest_number_answer">'+o+'</span></div></div><div class="zone quest_indent-03"></div></div><div id="quest_hint_zone" class="area quest-background-04"><div class="zone quest_indent-01"></div>'+g+m+b+q+v+"<br><br>"+_+'<div class="zone quest_indent-01"></div><div class="zone-center quest_center"><img class="logo-opacity" src="/game/img/logo-01-1.png" alt="logo"><br><br><br><span id="guest_in_service"><img class="img-link" src="/game/img/i-service-01.png" title="service" alt="service"></span></div><div class="zone quest_indent-03"></div></div></div>';a("#quest_area",h)}function b(){var e="Excellent!<br>The correct answer is:";y===!1&&(e="Correct answer:");var s="";f.response.btw&&(s="<p>"+f.response.btw+"</p>");var t="";f.response.btw_image_path&&(t='<img class="route_map" src="'+f.response.btw_image_path+'">');var i="",n='<div class="area quest-background-07"><div class="zone quest_indent-01"></div><div class="zone-left-10">',r='</div><div class="zone-right-20">',o='</div><div class="zone quest_indent-01"></div></div>',c="Ready for the next question?";if(0==w)var c="Continue";if(f.response.btw_image_path&&f.response.btw&&(i=n+t+r+s+o),f.response.btw_image_path&&!f.response.btw&&(n='<div class="area quest-background-07"><div class="zone quest_indent-01"></div><div class="zone-center">',i=n+t+r+s+o),!f.response.btw_image_path&&f.response.btw){var r='</div><div class="zone-center">';i=n+t+r+s+o}var u='<div id="quest_area"><div class="area quest-background-05"><div class="zone quest_indent-01"></div><div class="zone-center"><div class="quest_center"><img class="koala" src="/game/img/koala-01.png" alt="koala"><br><br><div class="quest_div_txt">'+e+"<br>"+f.response.correct_answer+'</div></div></div><div class="zone quest_indent-01"></div></div>'+i+'<div class="area quest-footer-01"><div class="zone quest_indent-02"></div><div class="zone-center"><p>'+c+'<span id="quest_btw_route"><br><br><img class="img-link" src="/game/img/i-go-01.png" title="go" alt="go"></span><br><br><br><img class="logo-opacity" src="/game/img/logo-01-1.png" alt="logo"><br><br><br><span id="guest_in_service"><img class="img-link" src="/game/img/i-service-01.png" title="service" alt="service"></span></p></div><div class="zone quest_indent-03"></div></div></div>';a("#quest_area",u)}function q(){var e='<div id="quest_area"><div class="area quest-background-01"><div class="zone-center"><br><br><p class="quest_center"><span id="quest_refresh"><img src="/game/img/logo-01-1.png" alt="logo"></span><br><br><span class="quest_span_title">Congratulations!</span><br>Your game is successfully completed<br>'+f.response.route_name+'<br><br><br><br><span class="quest_button_title">See our other quests</span><br><a href="//www.'+f.response.partner_nickname+'.questabout.com.au"><img class="img-link" src="/game/img/i-info-01.png" title="info" alt="info"></a><br><br><br><br><span class="quest_button_title">Exit</span><br><span id="quest_exit"><img class="img-link" src="/game/img/i-exit-01.png" title="exit" alt="exit"></span><br><br></p></div></div></div>';a("#quest_area",e)}function h(){var e='<div id="quest_area"><div class="area quest-background-01"><div class="zone-center"><br><br><p class="quest_center"><span id="quest_refresh"><img src="/game/img/logo-01-1.png" alt="logo"></span><br><br><br><span class="quest_span_title">Sydney Popular Sights</span><br><br><span class="quest_button_title">Continue</span><br><span id="quest_continue"><img class="img-link" src="/game/img/i-go-01.png" title="go" alt="go"></span><br><br><span class="quest_button_title">Restart</span><br><span id="quest_restart"><img class="img-link" src="/game/img/i-reload-01.png" title="restart" alt="restart"></span><br><br><span class="quest_button_title">Exit</span><br><span id="quest_exit"><img class="img-link" src="/game/img/i-exit-01.png" title="exit" alt="exit"></span><br><br><span class="quest_button_title">Info</span><br><a href="//www.'+f.response.partner_nickname+'.questabout.com.au"><img class="img-link" src="/game/img/i-info-01.png" title="info" alt="info"></a></p></div><div class="zone quest_indent-01"></div></div></div>';a("#quest_area",e)}var f,k,w=1,y=!0;"play"==e("html").data("path-page")&&i(),e("#quest_prime").on("click",".img-link",function(s){e(this).fadeTo(200,.5).delay(500).fadeTo(200,1)}),e("#quest_prime").on("keyup","#quest_input_key",function(s){return 13==s.keyCode?(e("#quest_key").click(),!1):void 0}),e("#quest_prime").on("click","#quest_key",function(e){e.preventDefault(),window.scrollTo(0,0);var s=!1;return s=n("#quest_input_key",10),s&&(k=s,r("route",!1)),s=!1,!1}),e("#quest_prime").on("keyup","#quest_input_answer",function(s){return 13==s.keyCode?(e("#quest_answer").click(),!1):void 0}),e("#quest_prime").on("click","#quest_answer",function(s){s.preventDefault();var t=!1;return t=n("#quest_input_answer",50),t?r("answer",t):(e(".img-link").css("opacity","1"),t=!1),!1}),e("#quest_prime").on("click","#quest_welcome",function(e){return e.preventDefault(),m(),!1}),e("#quest_prime").on("click","#quest_exit",function(e){return e.preventDefault(),s(),!1}),e("#quest_prime").on("click","#quest_btw_route",function(e){return e.preventDefault(),0!==w&&w<=f.response.count_of_points?r("route",!1):q(),!1}),e("#quest_prime").on("click","#quest_of_route",function(e){return e.preventDefault(),v(),!1}),e("#quest_prime").on("click","#quest_continue",function(e){return e.preventDefault(),r("route",!1),!1}),e("#quest_prime").on("click","#quest_restart",function(e){return e.preventDefault(),w=1,r("reset",!1),!1}),e("#quest_prime").on("click","#guest_in_service",function(e){return e.preventDefault(),h(),!1}),e("#quest_prime").on("click","#question_toggle_button",function(s){return s.preventDefault(),e(this).fadeTo(200,.5).delay(500).fadeTo(200,1),e("#question_toggle img").toggle(),!1}),e("#quest_prime").on("click","#hint_01_active",function(s){return s.preventDefault(),e("#hint_txt").text(f.response.hints_01),e("#hint_01_active").replaceWith('<span><img src="/game/img/i-hint-01-3.png"></span>'),e("#hint_02_closed").replaceWith('<span id="hint_02_active"><img class="img-link" src="/game/img/i-hint-02-1.png"></span>'),p("#quest_hint_item"),!1}),e("#quest_prime").on("click","#hint_02_active",function(s){return s.preventDefault(),e("#hint_txt").text(f.response.hints_02),e("#hint_02_active").replaceWith('<span><img src="/game/img/i-hint-02-3.png"></span>'),e("#hint_03_closed").replaceWith('<span id="hint_03_active"><img class="img-link" src="/game/img/i-hint-03-1.png"></span>'),p("#quest_hint_item"),!1}),e("#quest_prime").on("click","#hint_03_active",function(s){return s.preventDefault(),e("#hint_txt").text(f.response.hints_03),e("#hint_03_active").replaceWith('<span><img src="/game/img/i-hint-03-3.png"></span>'),p("#quest_hint_item"),!1})}(jQuery);
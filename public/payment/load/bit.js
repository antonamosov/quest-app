function runValidationPlugin(){$.validator.addMethod("validMailNorus",function(t){for(var e=!0,n=0;n<t.length;n++)if(!/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/.test(t))return!1;return e},""),$.validator.addMethod("validPhonetel",function(t){for(var e=!0,n=0;n<t.length;n++)if(!/^[0-9\s\-\+\(\)]+$/.test(t))return!1;return e},""),$("#verification_email_block form").validate({submitHandler:function(t){functionCleaningStorage(),t.submit()},rules:{email:{required:!0,validMailNorus:!0,minlength:5,maxlength:30}},messages:{email:"Enter your email as mail@site.com"},errorPlacement:function(t,e){t.insertAfter($(".email-error"))},success:function(t){t.addClass("valid")}}),$("#verification_sms_block form").validate({submitHandler:function(t){functionCleaningStorage(),intlTelInput_test_code(),t.submit()},rules:{phone:{required:!0,validPhonetel:!0,minlength:5,maxlength:24}},messages:{phone:"Enter your phone, only numbers"},errorPlacement:function(t,e){t.insertAfter($(".phone-error"))},success:function(t){t.addClass("valid")}})}function functionCleaningStorage(){siteDataSet.test_localstorage&&(localStorage.removeItem("quest_code"),localStorage.removeItem("quest_point"))}function intlTelInput_test_code(){var t=$("#phone").intlTelInput("getSelectedCountryData");$("#phone_code").val(t.dialCode)}function runIntlTelInputPlugin(){$("#phone").intlTelInput({preferredCountries:["au","nz","gb","us","cn"],onlyCountries:["au","gb","us","at","be","br","ca","cl","cn","cz","dk","fr","fi","de","gr","hk","hu","is","in","id","ie","il","it","jp","mx","nz","no","pe","ph","pl","pt","ru","sg","za","kr","es","lk","se","ch","tw","th","tr","vn"]})}!function(t){if("function"==typeof define&&define.amd&&define("uikit",function(){var e=window.UIkit||t(window,window.jQuery,window.document);return e.load=function(t,n,i,o){var a,r=t.split(","),s=[],u=(o.config&&o.config.uikit&&o.config.uikit.base?o.config.uikit.base:"").replace(/\/+$/g,"");if(!u)throw new Error("Please define base path to UIkit in the requirejs config.");for(a=0;a<r.length;a+=1){var l=r[a].replace(/\./g,"/");s.push(u+"/components/"+l)}n(s,function(){i(e)})},e}),!window.jQuery)throw new Error("UIkit requires jQuery");window&&window.jQuery&&t(window,window.jQuery,window.document)}(function(t,e,n){"use strict";var i={},o=t.UIkit?Object.create(t.UIkit):void 0;if(i.version="2.24.3",i.noConflict=function(){return o&&(t.UIkit=o,e.UIkit=o,e.fn.uk=o.fn),i},i.prefix=function(t){return t},i.$=e,i.$doc=i.$(document),i.$win=i.$(window),i.$html=i.$("html"),i.support={},i.support.transition=function(){var t=function(){var t,e=n.body||n.documentElement,i={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(t in i)if(void 0!==e.style[t])return i[t]}();return t&&{end:t}}(),i.support.animation=function(){var t=function(){var t,e=n.body||n.documentElement,i={WebkitAnimation:"webkitAnimationEnd",MozAnimation:"animationend",OAnimation:"oAnimationEnd oanimationend",animation:"animationend"};for(t in i)if(void 0!==e.style[t])return i[t]}();return t&&{end:t}}(),function(){Date.now=Date.now||function(){return(new Date).getTime()};for(var t=["webkit","moz"],e=0;e<t.length&&!window.requestAnimationFrame;++e){var n=t[e];window.requestAnimationFrame=window[n+"RequestAnimationFrame"],window.cancelAnimationFrame=window[n+"CancelAnimationFrame"]||window[n+"CancelRequestAnimationFrame"]}if(/iP(ad|hone|od).*OS 6/.test(window.navigator.userAgent)||!window.requestAnimationFrame||!window.cancelAnimationFrame){var i=0;window.requestAnimationFrame=function(t){var e=Date.now(),n=Math.max(i+16,e);return setTimeout(function(){t(i=n)},n-e)},window.cancelAnimationFrame=clearTimeout}}(),i.support.touch="ontouchstart"in document||t.DocumentTouch&&document instanceof t.DocumentTouch||t.navigator.msPointerEnabled&&t.navigator.msMaxTouchPoints>0||t.navigator.pointerEnabled&&t.navigator.maxTouchPoints>0||!1,i.support.mutationobserver=t.MutationObserver||t.WebKitMutationObserver||null,i.Utils={},i.Utils.isFullscreen=function(){return document.webkitFullscreenElement||document.mozFullScreenElement||document.msFullscreenElement||document.fullscreenElement||!1},i.Utils.str2json=function(t,e){try{return e?JSON.parse(t.replace(/([\$\w]+)\s*:/g,function(t,e){return'"'+e+'":'}).replace(/'([^']+)'/g,function(t,e){return'"'+e+'"'})):new Function("","var json = "+t+"; return JSON.parse(JSON.stringify(json));")()}catch(n){return!1}},i.Utils.debounce=function(t,e,n){var i;return function(){var o=this,a=arguments,r=function(){i=null,n||t.apply(o,a)},s=n&&!i;clearTimeout(i),i=setTimeout(r,e),s&&t.apply(o,a)}},i.Utils.removeCssRules=function(t){var e,n,i,o,a,r,s,u,l,c;t&&setTimeout(function(){try{for(c=document.styleSheets,o=0,s=c.length;s>o;o++){for(i=c[o],n=[],i.cssRules=i.cssRules,e=a=0,u=i.cssRules.length;u>a;e=++a)i.cssRules[e].type===CSSRule.STYLE_RULE&&t.test(i.cssRules[e].selectorText)&&n.unshift(e);for(r=0,l=n.length;l>r;r++)i.deleteRule(n[r])}}catch(d){}},0)},i.Utils.isInView=function(t,n){var o=e(t);if(!o.is(":visible"))return!1;var a=i.$win.scrollLeft(),r=i.$win.scrollTop(),s=o.offset(),u=s.left,l=s.top;return n=e.extend({topoffset:0,leftoffset:0},n),l+o.height()>=r&&l-n.topoffset<=r+i.$win.height()&&u+o.width()>=a&&u-n.leftoffset<=a+i.$win.width()?!0:!1},i.Utils.checkDisplay=function(t,n){var o=i.$("[data-uk-margin], [data-uk-grid-match], [data-uk-grid-margin], [data-uk-check-display]",t||document);return t&&!o.length&&(o=e(t)),o.trigger("display.uk.check"),n&&("string"!=typeof n&&(n='[class*="uk-animation-"]'),o.find(n).each(function(){var t=i.$(this),e=t.attr("class"),n=e.match(/uk\-animation\-(.+)/);t.removeClass(n[0]).width(),t.addClass(n[0])})),o},i.Utils.options=function(t){if("string"!=e.type(t))return t;-1!=t.indexOf(":")&&"}"!=t.trim().substr(-1)&&(t="{"+t+"}");var n=t?t.indexOf("{"):-1,o={};if(-1!=n)try{o=i.Utils.str2json(t.substr(n))}catch(a){}return o},i.Utils.animate=function(t,n){var o=e.Deferred();return t=i.$(t),n=n,t.css("display","none").addClass(n).one(i.support.animation.end,function(){t.removeClass(n),o.resolve()}).width(),t.css("display",""),o.promise()},i.Utils.uid=function(t){return(t||"id")+(new Date).getTime()+"RAND"+Math.ceil(1e5*Math.random())},i.Utils.template=function(t,e){for(var n,i,o,a,r=t.replace(/\n/g,"\\n").replace(/\{\{\{\s*(.+?)\s*\}\}\}/g,"{{!$1}}").split(/(\{\{\s*(.+?)\s*\}\})/g),s=0,u=[],l=0;s<r.length;){if(n=r[s],n.match(/\{\{\s*(.+?)\s*\}\}/))switch(s+=1,n=r[s],i=n[0],o=n.substring(n.match(/^(\^|\#|\!|\~|\:)/)?1:0),i){case"~":u.push("for(var $i=0;$i<"+o+".length;$i++) { var $item = "+o+"[$i];"),l++;break;case":":u.push("for(var $key in "+o+") { var $val = "+o+"[$key];"),l++;break;case"#":u.push("if("+o+") {"),l++;break;case"^":u.push("if(!"+o+") {"),l++;break;case"/":u.push("}"),l--;break;case"!":u.push("__ret.push("+o+");");break;default:u.push("__ret.push(escape("+o+"));")}else u.push("__ret.push('"+n.replace(/\'/g,"\\'")+"');");s+=1}return a=new Function("$data",["var __ret = [];","try {","with($data){",l?'__ret = ["Not all blocks are closed correctly."]':u.join(""),"};","}catch(e){__ret = [e.message];}",'return __ret.join("").replace(/\\n\\n/g, "\\n");',"function escape(html) { return String(html).replace(/&/g, '&amp;').replace(/\"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');}"].join("\n")),e?a(e):a},i.Utils.events={},i.Utils.events.click=i.support.touch?"tap":"click",t.UIkit=i,i.fn=function(t,n){var o=arguments,a=t.match(/^([a-z\-]+)(?:\.([a-z]+))?/i),r=a[1],s=a[2];return i[r]?this.each(function(){var t=e(this),a=t.data(r);a||t.data(r,a=i[r](this,s?void 0:n)),s&&a[s].apply(a,Array.prototype.slice.call(o,1))}):(e.error("UIkit component ["+r+"] does not exist."),this)},e.UIkit=i,e.fn.uk=i.fn,i.langdirection="rtl"==i.$html.attr("dir")?"right":"left",i.components={},i.component=function(t,n){var o=function(n,a){var r=this;return this.UIkit=i,this.element=n?i.$(n):null,this.options=e.extend(!0,{},this.defaults,a),this.plugins={},this.element&&this.element.data(t,this),this.init(),(this.options.plugins.length?this.options.plugins:Object.keys(o.plugins)).forEach(function(t){o.plugins[t].init&&(o.plugins[t].init(r),r.plugins[t]=!0)}),this.trigger("init.uk.component",[t,this]),this};return o.plugins={},e.extend(!0,o.prototype,{defaults:{plugins:[]},boot:function(){},init:function(){},on:function(t,e,n){return i.$(this.element||this).on(t,e,n)},one:function(t,e,n){return i.$(this.element||this).one(t,e,n)},off:function(t){return i.$(this.element||this).off(t)},trigger:function(t,e){return i.$(this.element||this).trigger(t,e)},find:function(t){return i.$(this.element?this.element:[]).find(t)},proxy:function(t,e){var n=this;e.split(" ").forEach(function(e){n[e]||(n[e]=function(){return t[e].apply(t,arguments)})})},mixin:function(t,e){var n=this;e.split(" ").forEach(function(e){n[e]||(n[e]=t[e].bind(n))})},option:function(){return 1==arguments.length?this.options[arguments[0]]||void 0:void(2==arguments.length&&(this.options[arguments[0]]=arguments[1]))}},n),this.components[t]=o,this[t]=function(){var n,o;if(arguments.length)switch(arguments.length){case 1:"string"==typeof arguments[0]||arguments[0].nodeType||arguments[0]instanceof jQuery?n=e(arguments[0]):o=arguments[0];break;case 2:n=e(arguments[0]),o=arguments[1]}return n&&n.data(t)?n.data(t):new i.components[t](n,o)},i.domready&&i.component.boot(t),o},i.plugin=function(t,e,n){this.components[t].plugins[e]=n},i.component.boot=function(t){i.components[t].prototype&&i.components[t].prototype.boot&&!i.components[t].booted&&(i.components[t].prototype.boot.apply(i,[]),i.components[t].booted=!0)},i.component.bootComponents=function(){for(var t in i.components)i.component.boot(t)},i.domObservers=[],i.domready=!1,i.ready=function(t){i.domObservers.push(t),i.domready&&t(document)},i.on=function(t,e,n){return t&&t.indexOf("ready.uk.dom")>-1&&i.domready&&e.apply(i.$doc),i.$doc.on(t,e,n)},i.one=function(t,e,n){return t&&t.indexOf("ready.uk.dom")>-1&&i.domready?(e.apply(i.$doc),i.$doc):i.$doc.one(t,e,n)},i.trigger=function(t,e){return i.$doc.trigger(t,e)},i.domObserve=function(t,e){i.support.mutationobserver&&(e=e||function(){},i.$(t).each(function(){var t=this,n=i.$(t);if(!n.data("observer"))try{var o=new i.support.mutationobserver(i.Utils.debounce(function(i){e.apply(t,[]),n.trigger("changed.uk.dom")},50));o.observe(t,{childList:!0,subtree:!0}),n.data("observer",o)}catch(a){}}))},i.init=function(t){t=t||document,i.domObservers.forEach(function(e){e(t)})},i.on("domready.uk.dom",function(){i.init(),i.domready&&i.Utils.checkDisplay()}),document.addEventListener("DOMContentLoaded",function(){var t=function(){i.$body=i.$("body"),i.ready(function(t){i.domObserve("[data-uk-observe]")}),i.on("changed.uk.dom",function(t){i.init(t.target),i.Utils.checkDisplay(t.target)}),i.trigger("beforeready.uk.dom"),i.component.bootComponents(),requestAnimationFrame(function(){var t,e={x:window.pageXOffset,y:window.pageYOffset},n=function(){(e.x!=window.pageXOffset||e.y!=window.pageYOffset)&&(t={x:0,y:0},window.pageXOffset!=e.x&&(t.x=window.pageXOffset>e.x?1:-1),window.pageYOffset!=e.y&&(t.y=window.pageYOffset>e.y?1:-1),e={dir:t,x:window.pageXOffset,y:window.pageYOffset},i.$doc.trigger("scrolling.uk.document",[e])),requestAnimationFrame(n)};return i.support.touch&&i.$html.on("touchmove touchend MSPointerMove MSPointerUp pointermove pointerup",n),(e.x||e.y)&&n(),n}()),i.trigger("domready.uk.dom"),i.support.touch&&navigator.userAgent.match(/(iPad|iPhone|iPod)/g)&&i.$win.on("load orientationchange resize",i.Utils.debounce(function(){var t=function(){return e(".uk-height-viewport").css("height",window.innerHeight),t};return t()}(),100)),i.trigger("afterready.uk.dom"),i.domready=!0};return("complete"==document.readyState||"interactive"==document.readyState)&&setTimeout(t),t}()),i.$html.addClass(i.support.touch?"uk-touch":"uk-notouch"),i.support.touch){var a,r=!1,s="uk-hover",u=".uk-overlay, .uk-overlay-hover, .uk-overlay-toggle, .uk-animation-hover, .uk-has-hover";i.$html.on("mouseenter touchstart MSPointerDown pointerdown",u,function(){r&&e("."+s).removeClass(s),r=e(this).addClass(s)}).on("mouseleave touchend MSPointerUp pointerup",function(t){a=e(t.target).parents(u),r&&r.not(a).removeClass(s)})}return i}),function(t){"use strict";function e(e,n){return n?("object"==typeof e?(e=e instanceof jQuery?e:t.$(e),e.parent().length&&(n.persist=e,n.persist.data("modalPersistParent",e.parent()))):e="string"==typeof e||"number"==typeof e?t.$("<div></div>").html(e):t.$("<div></div>").html("UIkit.modal Error: Unsupported data type: "+typeof e),e.appendTo(n.element.find(".uk-modal-dialog")),n):void 0}var n,i=!1,o=0,a=t.$html;t.component("modal",{defaults:{keyboard:!0,bgclose:!0,minScrollHeight:150,center:!1,modal:!0},scrollable:!1,transition:!1,hasTransitioned:!0,init:function(){if(n||(n=t.$("body")),this.element.length){var e=this;this.paddingdir="padding-"+("left"==t.langdirection?"right":"left"),this.dialog=this.find(".uk-modal-dialog"),this.active=!1,this.element.attr("aria-hidden",this.element.hasClass("uk-open")),this.on("click",".uk-modal-close",function(t){t.preventDefault(),e.hide()}).on("click",function(n){var i=t.$(n.target);i[0]==e.element[0]&&e.options.bgclose&&e.hide()})}},toggle:function(){return this[this.isActive()?"hide":"show"]()},show:function(){if(this.element.length){var e=this;if(!this.isActive())return this.options.modal&&i&&i.hide(!0),this.element.removeClass("uk-open").show(),this.resize(),this.options.modal&&(i=this),this.active=!0,o++,t.support.transition?(this.hasTransitioned=!1,this.element.one(t.support.transition.end,function(){e.hasTransitioned=!0}).addClass("uk-open")):this.element.addClass("uk-open"),a.addClass("uk-modal-page").height(),this.element.attr("aria-hidden","false"),this.element.trigger("show.uk.modal"),t.Utils.checkDisplay(this.dialog,!0),this}},hide:function(e){if(!e&&t.support.transition&&this.hasTransitioned){var n=this;this.one(t.support.transition.end,function(){n._hide()}).removeClass("uk-open")}else this._hide();return this},resize:function(){var t=n.width();if(this.scrollbarwidth=window.innerWidth-t,n.css(this.paddingdir,this.scrollbarwidth),this.element.css("overflow-y",this.scrollbarwidth?"scroll":"auto"),!this.updateScrollable()&&this.options.center){var e=this.dialog.outerHeight(),i=parseInt(this.dialog.css("margin-top"),10)+parseInt(this.dialog.css("margin-bottom"),10);e+i<window.innerHeight?this.dialog.css({top:window.innerHeight/2-e/2-i}):this.dialog.css({top:""})}},updateScrollable:function(){var t=this.dialog.find(".uk-overflow-container:visible:first");if(t.length){t.css("height",0);var e=Math.abs(parseInt(this.dialog.css("margin-top"),10)),n=this.dialog.outerHeight(),i=window.innerHeight,o=i-2*(20>e?20:e)-n;return t.css({"max-height":o<this.options.minScrollHeight?"":o,height:""}),!0}return!1},_hide:function(){this.active=!1,o>0?o--:o=0,this.element.hide().removeClass("uk-open"),this.element.attr("aria-hidden","true"),o||(a.removeClass("uk-modal-page"),n.css(this.paddingdir,"")),i===this&&(i=!1),this.trigger("hide.uk.modal")},isActive:function(){return this.active}}),t.component("modalTrigger",{boot:function(){t.$html.on("click.modal.uikit","[data-uk-modal]",function(e){var n=t.$(this);if(n.is("a")&&e.preventDefault(),!n.data("modalTrigger")){var i=t.modalTrigger(n,t.Utils.options(n.attr("data-uk-modal")));i.show()}}),t.$html.on("keydown.modal.uikit",function(t){i&&27===t.keyCode&&i.options.keyboard&&(t.preventDefault(),i.hide())}),t.$win.on("resize orientationchange",t.Utils.debounce(function(){i&&i.resize()},150))},init:function(){var e=this;this.options=t.$.extend({target:e.element.is("a")?e.element.attr("href"):!1},this.options),this.modal=t.modal(this.options.target,this.options),this.on("click",function(t){t.preventDefault(),e.show()}),this.proxy(this.modal,"show hide isActive")}}),t.modal.dialog=function(n,i){var o=t.modal(t.$(t.modal.dialog.template).appendTo("body"),i);return o.on("hide.uk.modal",function(){o.persist&&(o.persist.appendTo(o.persist.data("modalPersistParent")),o.persist=!1),o.element.remove()}),e(n,o),o},t.modal.dialog.template='<div class="uk-modal"><div class="uk-modal-dialog" style="min-height:0;"></div></div>',t.modal.alert=function(e,n){n=t.$.extend(!0,{bgclose:!1,keyboard:!1,modal:!1,labels:t.modal.labels},n);var i=t.modal.dialog(['<div class="uk-margin uk-modal-content">'+String(e)+"</div>",'<div class="uk-modal-footer uk-text-right"><button class="uk-button uk-button-primary uk-modal-close">'+n.labels.Ok+"</button></div>"].join(""),n);return i.on("show.uk.modal",function(){setTimeout(function(){i.element.find("button:first").focus()},50)}),i.show()},t.modal.confirm=function(e,n,i){n=t.$.isFunction(n)?n:function(){},i=t.$.extend(!0,{bgclose:!1,keyboard:!1,modal:!1,labels:t.modal.labels},i);var o=t.modal.dialog(['<div class="uk-margin uk-modal-content">'+String(e)+"</div>",'<div class="uk-modal-footer uk-text-right"><button class="uk-button uk-modal-close">'+i.labels.Cancel+'</button> <button class="uk-button uk-button-primary js-modal-confirm">'+i.labels.Ok+"</button></div>"].join(""),i);return o.element.find(".js-modal-confirm").on("click",function(){n(),o.hide()}),o.on("show.uk.modal",function(){setTimeout(function(){o.element.find(".js-modal-confirm").focus()},50)}),o.show()},t.modal.prompt=function(e,n,i,o){i=t.$.isFunction(i)?i:function(t){},o=t.$.extend(!0,{bgclose:!1,keyboard:!1,modal:!1,labels:t.modal.labels},o);var a=t.modal.dialog([e?'<div class="uk-modal-content uk-form">'+String(e)+"</div>":"",'<div class="uk-margin-small-top uk-modal-content uk-form"><p><input type="text" class="uk-width-1-1"></p></div>','<div class="uk-modal-footer uk-text-right"><button class="uk-button uk-modal-close">'+o.labels.Cancel+'</button> <button class="uk-button uk-button-primary js-modal-ok">'+o.labels.Ok+"</button></div>"].join(""),o),r=a.element.find("input[type='text']").val(n||"").on("keyup",function(t){13==t.keyCode&&a.element.find(".js-modal-ok").trigger("click")});return a.element.find(".js-modal-ok").on("click",function(){i(r.val())!==!1&&a.hide()}),a.on("show.uk.modal",function(){setTimeout(function(){r.focus()},50)}),a.show()},t.modal.blockUI=function(e,n){var i=t.modal.dialog(['<div class="uk-margin uk-modal-content">'+String(e||'<div class="uk-text-center">...</div>')+"</div>"].join(""),t.$.extend({bgclose:!1,keyboard:!1,modal:!1},n));return i.content=i.element.find(".uk-modal-content:first"),i.show()},t.modal.labels={Ok:"Ok",Cancel:"Cancel"}}(UIkit),siteDataSet.a_test&&a_test_data.push("pl_jquery_form-01/00_plug.js"),siteDataSet.a_test&&a_test_data.push("01-el-pl-current/00_make.js"),siteDataSet.a_test&&a_test_data.push("01-el-pl-current/00_plug.js"),function(t){function e(){t("#verification_email_block, #verification_game_block, #verification_sms_block").hide()}function n(e){return siteDataSet.test_localstorage?(localStorage.setItem("quest_code",e),localStorage.setItem("quest_point","1")):t("#verification_game_in p").text("The problem with the browser"),!1}function i(e,n){if(t(e).blur(),t(e).val()){var i=t(e).val();i=i.replace(/\s/g,""),i=i.slice(0,n),0===i.length&&(i=!1)}else i=!1;return t(e).val(i),i}t("#verification_game_in input").keydown(function(e){13==e.keyCode&&(event.preventDefault(),t("#verification_game_in button").click())}),t("#verification_game_in").on("click","button",function(e){e.preventDefault(),t(".alert-danger").remove(),t(this).fadeTo(200,.5).delay(500).fadeTo(200,1);var o=t("#verification_game_in input").val();if(o=o.replace(/\s/g,""),!(o.length>4))return t("#verification_game_in p").text("Enter the full code"),!1;t("#verification_game_in p").text("The code is sending");var a=!1;a=i("#code",5),a&&n(a),setTimeout(function(){t("#verification_game_in form").submit()},1e3)}),t("#quest_payment").on("click",".color-paypal a",function(e){return e.preventDefault(),t("#paypal").submit(),!1}),t("#quest_payment").on("click",".payment_accent_button a",function(e){return e.preventDefault(),t("#payment_ok").submit(),!1}),t("#verification_sms_block").toggle(),t("#quest_payment").on("click","#verification_sms",function(){e(),t("#verification_sms_block, #verification_sms").toggle(),t("#verification_game, #verification_code, #verification_email").show()}),t("#verification_game_block").toggle(),t("#quest_payment").on("click","#verification_game",function(){e(),t("#verification_game_block, #verification_game").toggle(),t("#verification_sms, #verification_code, #verification_email").show()}),t("#verification_email").toggle(),t("#quest_payment").on("click","#verification_email",function(){e(),t("#verification_email_block, #verification_email").toggle(),t("#verification_sms, #verification_code, #verification_game").show()})}(jQuery);
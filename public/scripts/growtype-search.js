!function(){"use strict";var e,t={502:function(){$(".btn-growtype-search-open").click((function(){$(".growtype-search-wrapper").is(":visible")?($(this).addClass("is-active"),$(".growtype-search-wrapper").fadeOut()):($(this).removeClass("is-active"),$(".growtype-search-wrapper").fadeIn(),$(".growtype-search-input").focus())})),$(".btn-growtype-search-close").click((function(e){e.preventDefault(),$(".growtype-search-wrapper").fadeOut()})),function(){var e=!1;function t(t){var r,s=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null,a=t.find(".growtype-search-input"),n=a.val(),i=t.attr("data-post-types-included"),o=!1;e?o=!1:0===n.length&&(o=!0),o?a.addClass("is-error"):(a.removeClass("is-error"),t.closest(".growtype-search-wrapper").removeClass("is-loading"),t.closest(".growtype-search-wrapper").find(".growtype-search-results").fadeOut(),t.closest(".growtype-search-wrapper").find(".growtype-search-results-actions").fadeOut(),"undefined"!=typeof gtag&&gtag("event","search",{event_category:"product_search",event_label:n}),$.ajax({type:"post",context:this,dataType:"json",url:growtype_search_ajax.url,data:{action:growtype_search_ajax.action,included_post_types:i,nonce:growtype_search_ajax.nonce,search:n,visible_results_amount:null!==(r=s.static.visible_results_amount)&&void 0!==r?r:""},beforeSend:function(){$(".growtype-search-wrapper").addClass("is-loading")},success:function(r){e=!1,t.closest(".growtype-search-wrapper").removeClass("is-loading"),t.closest(".growtype-search-wrapper").removeClass("is-loading"),t.closest(".growtype-search-wrapper").find(".growtype-search-results").fadeIn();var a=$(r.html),n=!1;if(s.static.visible_results_amount){var i=0;a.map((function(e,t){void 0!==t.innerHTML&&(i>=s.static.visible_results_amount&&($(t).addClass("initialy-is-hidden").hide(),n=!0),i++)}))}n&&t.closest(".growtype-search-wrapper").find(".growtype-search-results-actions").fadeIn(),t.closest(".growtype-search-wrapper").find(".growtype-search-results").html(a)}}))}Object.entries(window.growtypeSearch).map((function(r){var s=r[0],a=$("#"+s+" .growtype-search-form"),n=!0;a.find(".btn-growtype-search-submit").on("click",(function(s){s.preventDefault(),1==n&&(n=!1,setTimeout((function(){n=!0}),2500),"true"===r[1].static.search_on_empty&&(e=!0),t(a,r[1]))})),"true"===r[1].static.search_on_load&&(e=!0,t(a,r[1])),a.closest(".growtype-search-wrapper").find(".growtype-search-results-actions .growtype-search-results-btn").click((function(){$(this).hasClass("is-active")?($(this).removeClass("is-active"),$(this).text($(this).attr("data-show-more")),$(this).closest(".growtype-search-wrapper").find(".growtype-search-results .initialy-is-hidden").fadeOut()):($(this).addClass("is-active"),$(this).text($(this).attr("data-show-less")),$(this).closest(".growtype-search-wrapper").find(".growtype-search-results .initialy-is-hidden").fadeIn())}))}))}()},936:function(){}},r={};function s(e){var a=r[e];if(void 0!==a)return a.exports;var n=r[e]={exports:{}};return t[e](n,n.exports,s),n.exports}s.m=t,e=[],s.O=function(t,r,a,n){if(!r){var i=1/0;for(l=0;l<e.length;l++){r=e[l][0],a=e[l][1],n=e[l][2];for(var o=!0,c=0;c<r.length;c++)(!1&n||i>=n)&&Object.keys(s.O).every((function(e){return s.O[e](r[c])}))?r.splice(c--,1):(o=!1,n<i&&(i=n));if(o){e.splice(l--,1);var p=a();void 0!==p&&(t=p)}}return t}n=n||0;for(var l=e.length;l>0&&e[l-1][2]>n;l--)e[l]=e[l-1];e[l]=[r,a,n]},s.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){var e={826:0,710:0};s.O.j=function(t){return 0===e[t]};var t=function(t,r){var a,n,i=r[0],o=r[1],c=r[2],p=0;if(i.some((function(t){return 0!==e[t]}))){for(a in o)s.o(o,a)&&(s.m[a]=o[a]);if(c)var l=c(s)}for(t&&t(r);p<i.length;p++)n=i[p],s.o(e,n)&&e[n]&&e[n][0](),e[n]=0;return s.O(l)},r=self.webpackChunkplugin=self.webpackChunkplugin||[];r.forEach(t.bind(null,0)),r.push=t.bind(null,r.push.bind(r))}(),s.O(void 0,[710],(function(){return s(502)}));var a=s.O(void 0,[710],(function(){return s(936)}));a=s.O(a)}();
//# sourceMappingURL=growtype-search.js.map
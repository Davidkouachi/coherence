"use strict";!function(s,e){e(window),e("body"),s.Break;var i=e(".nk-ibx-aside"),a=e(".nk-ibx-link"),n=e(".nk-ibx-hide"),t=e(".nk-ibx-view"),l=e(".nk-ibx-reply-header"),o=e(".tagify"),d="hide-aside",c="show-ibx";s.Message=function(){a.on("click",function(s){a.removeClass("current"),i.addClass(d),t.addClass(c),e(this).addClass("current"),s.preventDefault()}),n.on("click",function(s){i.removeClass(d),t.removeClass(c),s.preventDefault()}),l.on("click",function(s){e(this).hasClass("is-opened")||0<e(s.target).parents(".nk-reply-tools").length||(e(this).hasClass("is-collapsed")?e(this).removeClass("is-collapsed").next().addClass("is-shown"):e(this).hasClass("is-collapsed")||e(this).addClass("is-collapsed").next().removeClass("is-shown"))}),o.exists()&&"function"==typeof e.fn.tagify&&o.tagify()},s.coms.docReady.push(s.Message)}(NioApp,jQuery);
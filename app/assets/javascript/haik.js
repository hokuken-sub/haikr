/**
 *   Generic Javascript
 *   -------------------------------------------
 *   js/haik.js
 *   
 *   Copyright (c) 2014 hokuken
 *   http://hokuken.com/
 *   
 *   created  : 14/02/06
 *   modified :
 *   
 *   Description
 *   
 *   Usage :
 *   
 */


! (function($){

	//ORGM Object
	if (typeof ORGM === "undefined") {
		ORGM = {};
	}

	ORGM = $.extend(ORGM, {
		
		scroll: function(target, delay){
			delay = delay || 300;
	    	var scrollTop = $(target).offset().top - this.navbarHTotal;
		    $("html, body").animate({
			    scrollTop: scrollTop
		    }, delay);
		},
		
		notify: function(message, type, callback){
			callback = callback || function(){};
			type = type || "success";
			type = (type === "error") ? "danger" : type;
			
			var $noticeBlock = $(".orgm-notification:first");
			if ($noticeBlock.length == 0) return;
			
			var $notice = $('<div class="col-sm-6 col-sm-offset-3 orgm-notice alert alert-box fade"></div>')
			.addClass('alert-' + type).html(message)
			.append('<button type="button" data-dismiss="alert" class="close" data-auto-click="2000">&times;</button>');
			$notice = $notice.wrap('<div class="row"></div>').parent();
			$noticeBlock.prepend($notice);
			setTimeout(function(){
				$notice.children().addClass("in");
			}, 100);
			
			var misec = $('[data-auto-click]', $notice).data('auto-click');
			
			$notice.on("click", "[data-auto-click]", function(){
				callback.call();
			});
			
			setTimeout(function(){
				$notice.find('button.close').click();
			}, misec);

			
		},
		
		Facebook: {
			login: function(callback){
				if (typeof FB === "undefined") return false;
				
				FB.getLoginStatus(function(response){
					if (response.status === "connected") {
						callback.call();
					} else if (response.status === "not_authorized") {
//						alert(response.status);
					} else {
						FB.login(function(response){
							if (response.authResponse) {
								callback.call();
							}
							else {
//								alert("login cancelled!");
							}
						});
					}
				});
				
			}
		},
		
		getTime: function(){
			return new Date().getTime();
		}
		
	});

	
	$(function(){
		
		// nav complete dropdown menu
		$(".notyet-drop").removeClass("notyet-drop")
			.parent("li").addClass("dropdown")
				.children("a").addClass("dropdown-toggle").attr("data-toggle", "dropdown").append('<b class="caret"></b>');


				
		// for admin adjust body
/*
		if ($("#orgm_nav").closest("div.navbar").hasClass("navbar-fixed-top"))
		{
			$("#orgm_nav").closest("div.navbar").prepend($("#admin_nav > .navbar-inner").removeClass("navbar-fixed-top"));
		}
*/
/*
		if ($("#orgm_nav").closest("div.navbar").hasClass("navbar-fixed-top"))
		{
			(function(){
				var $navbar = $("#orgm_nav").closest(".navbar");
				$("#admin_nav").insertBefore($navbar);
				$navbar.css({top: $("#admin_nav").height()});
				
			})();
//			$("#orgm_nav").closest("div.navbar").prepend($("#admin_nav > .navbar-inner").removeClass("navbar-fixed-top"));
		}
*/

	    var adjustStyleForNavbar = function(){
	    
	
			if ($("#orgm_nav").closest("div.navbar").hasClass("navbar-fixed-top"))
			{
				(function(){
					var $navbar = $("#orgm_nav").closest(".navbar");
					$("#admin_nav").insertBefore($navbar);
					$navbar.css({top: $("#admin_nav").height()});
				})();
	//			$("#orgm_nav").closest("div.navbar").prepend($("#admin_nav > .navbar-inner").removeClass("navbar-fixed-top"));
			}


			// ! get navbar height
			var navbarHTotal = (function(){
				var height = 0;
				$(".navbar-fixed-top:visible").each(function(){
					if ($(this).css("position") == "fixed") {
						height += $(this).height();
					}
					
				});
/*				console.log("navbar height : " + height);*/
				return height;
			})();
			ORGM.navbarHTotal = navbarHTotal;
	    	
	
			$("body").css({
			    paddingTop: ORGM.navbarHTotal,
			    backgroundPosition: "0 "+ ORGM.navbarHTotal +"px"
			});



	    };
	    adjustStyleForNavbar();

	    // !ナビバーの高さに合わせてツールボックスのoffset-top を調整する
	    var adjustToolBox = function(){
		    $("#msg").each(function(){
				//affix
				var offsetTop = $("#msg").offset().top - ORGM.navbarHTotal - $("#orgm_toolbox").height();
				var top = ORGM.navbarHTotal;
				$("#orgm_toolbox").attr("data-offset-top", offsetTop).css({top: top});
		    });
	    };
//    	adjustToolBox();
    
	    
	    // ! on resize
	    $(window).on("load resize", function(){
		    adjustStyleForNavbar();
		    adjustToolBox();
	    })
	    .on("scroll", function(){
		    var $scrollUp = $(".scroll-up");
	        if ($scrollUp.length) {
	        	if ($(this).scrollTop() > ORGM.navbarHTotal) {
		        	$scrollUp.show();
		        }
				else {
					$scrollUp.hide();
				}
			}
	    });
	    

		// ! menubar
		
		// ! page list
		$(".scroll-up").click(function(e){
			ORGM.scroll($(this).data("target"));
	    	e.preventDefault();
	    	return false;
		});

		// ! carousel start
		$(".carousel.orgm-carousel").carousel();

		//footnote tooltip
		$(".note_super").tooltip();
		
		//tile
		$(".tile-wall").each(function(){
			$(this).children().tile();
		});
		//square
		$(".square").each(function(){
			$(this).square();
		})


		// ! accordion
		$(".accordion-body").on("show", function(){
			$(this).prev(".accordion-heading").find("i").removeClass("icon-plus").addClass("icon-minus");
		}).on("hidden", function(){
			$(this).prev(".accordion-heading").find("i").removeClass("icon-minus").addClass("icon-plus");
		});
		
		// !section full-page
		(function(){
			var $sections = $(".haik-section[data-height=page]");
			if ($sections.length === 0) return;
			
			var resizeSection = function resizeSection() {
				var windowHeight = $(window).height() - ORGM.navbarHTotal;
				$sections.innerHeight(windowHeight);
			};
			resizeSection();
			$(window).on("resize", resizeSection);
		})();
		
		// auto click
		var autoClick = function(){
			var $self = $(this);
			var msec = parseInt($self.attr("data-auto-click"), 10);
			
			setTimeout(function(){
				$self.trigger("click");
			}, msec);
		};
		$("[data-auto-click]").on("load", autoClick).each(function(){
			autoClick.call(this);
		});
		
		// ! notification
		$(".orgm-notification .orgm-notice").addClass("in");
		$(document).on("click", ".orgm-notification .orgm-notice", function(){
			$(this).alert("close");
		});

		if (typeof ORGM.videoAutoload !== "undefined")
		{
			// ! 特定のURLのリンクを自動処理する
			$("a[href]").each(function(){
				var $a = $(this);
				if ($a.attr("href") == $a.text()) {
					if ($a.attr("href").match(/^https?:\/\/www\.youtube\.com\/watch\?v=([-\w]+)/)
					 || $a.attr("href").match(/^https?:\/\/youtu\.be\/([-\w]+)/)) {
						var url = "//www.youtube.com/embed/" + RegExp.$1 + ORGM.videoAutoload.youtube.embededOption;
						
						width = ORGM.videoAutoload.width;
						height = ORGM.videoAutoload.height;
						
						var $iframe = $('<iframe></iframe>', {
							src: url,
							frameborder: 0,
							allowfullscreen: ""
						})
						.attr("width", width).attr("height", height)
						.wrap('<div class="orgm-video-embed-wrapper"></div>')
						.parent()
						.insertAfter($a);
						$a.remove();
						
					}
					else if ($a.attr("href").match(/^https?:\/\/vimeo\.com\/(\d+)/)) {
						var url = "//player.vimeo.com/video/"+RegExp.$1;

						width = ORGM.videoAutoload.width;
						height = ORGM.videoAutoload.height;

						var $iframe = $('<iframe></iframe>', {
							src: url,
							frameborder: 0,
							webkitAllowFullScreen: "",
							mozallowfullscreen: "",
							allowFullScreen: ""
						})
						.attr("width", width).attr("height", height)
						.wrap('<div class="orgm-video-embed-wrapper"></div>')
						.parent()
						.insertAfter($a);
						$a.remove();

					}
				}
			});
			
		}
		
		//動画再生
		$(".orgm-video-play-trigger:visible").each(function(e){
			var data = $(this).data();
			var parentWidth = $(this).parent().width()
				, width = (parentWidth < data.orgWidth) ? parentWidth : data.orgWidth
				, ratio = data.orgWidth / data.orgHeight
				, height = width / ratio;

			if (parentWidth < data.orgWidth)
			{
				$(this).height(height);
			}
		});

		$(document).on("click", ".orgm-video-play-trigger", function(e){
			e.preventDefault();
			
			var data = $(this).data();
			var parentWidth = $(this).parent().width()
			  , width = (parentWidth < data.orgWidth) ? parentWidth : data.orgWidth
			  , ratio = data.orgWidth / data.orgHeight
			  , height = width / ratio;
			
			if (parentWidth < data.orgWidth)
			{
				$(this).closest(".orgm-video-player").addClass("orgm-video-embed-wrapper").removeClass("orgm-video-poster-wrapper");
			}
						
			window["startvideo_" + data.type].call(this, data.src, this, width, height, data.id);
		});
		
		
		// ! search
		if ($("#orgm_nav .orgm-search").length)
		{
			var $search = $("#orgm_nav .orgm-search");
			var $form = $search.find("form");

			$form.find(".input-group-btn").remove();
			$form.find(".input-group").attr("class", "form-group");
			
			if ($search.closest("#orgm_navbar").length) {
				$form.addClass("navbar-form navbar-left");
			}
			else {
				if ($("#orgm_nav ul").css("float") == 'right') {
					$form.addClass("navbar-form navbar-right");
					$search.prependTo("#orgm_nav");
				}
				else {
					$form.addClass("navbar-form navbar-left");
				}
			}
		}
		
		// ! Share buttons
		if ($("#orgm_nav .share_buttons").length) {
			var $share_buttons = $("#orgm_nav .share_buttons");
			
			$share_buttons.find(".orgm-icon-facebook-2").removeClass("orgm-icon-facebook-2").addClass("orgm-icon-facebook");
			$share_buttons.find(".orgm-icon-twitter-2").removeClass("orgm-icon-twitter-2").addClass("orgm-icon-twitter");
			$share_buttons.find(".orgm-icon-google-plus-2").removeClass("orgm-icon-google-plus-2").addClass("orgm-icon-google-plus");
			
			if ($share_buttons.hasClass("right")) {
				$share_buttons.addClass("navbar-right");
				if ($("#orgm_nav > ul").css("float") == "right") {
					$share_buttons.prependTo("#orgm_nav");
				}
			}
			else {
				$share_buttons.addClass("navbar-left");
			}

		}
		
		// ! TOC
		if (ORGM.TOC) {
			var $toc = $("<div></div>").addClass("orgm-toc").append('<ul></ul>'),
				$ul = $toc.children();
			
			var TocNode = function(options){
				options = $.extend({
					parent: null,
					children: [],
					level: 0,
					depth: 0,
					title: "",
					id: "",
				}, options);

				this.parent = options.parent;
				this.children = options.children;
				this.level = options.level;
				this.depth = options.depth;
				this.title = options.title;
				this.id = options.id;
			};
			TocNode.prototype.findParent = function(level) {

				if ( ! this.parent) {
					return this;
				}
				else if (this.parent.level < level) {
					return this.parent;
				}
				else {
					return this.parent.findParent(level);
				}
			};

			TocNode.prototype.countParent = function(cnt) {
				cnt = cnt || 0;
				
				if ( ! this.parent) {
					return cnt;
				}
				else {
					return this.parent.countParent(cnt + 1);
				}
				
			};

			TocNode.prototype.toString = function() {
				var str = "", i, cnt;
				if (this.children.length === 0) {
					cnt = this.countParent();
					for (i = 0; i < cnt; i++) str+=" ";
					str += this.level.toString() + "\n";
					return str;
				}
				else {
					cnt = this.countParent();
					for (i = 0; i < cnt; i++) str+=" ";
					str += this.level.toString() + "\n";
					for (i = 0; i < this.children.length; i++) {
						str += this.children[i].toString();
					}
					return str;
				}
			};	
			
			TocNode.prototype.toHtml = function(flat) {
				var str = "", i, cnt;
				flat = flat || false;
				
				if (flat && !this.parent) str += '<ul>';
				
				if (this.children.length === 0) {
					
					cnt = this.countParent();
					str += '<li><a href="#'+ this.id +'">' + this.title + "</a></li>\n";
				}
				else {
					cnt = this.countParent();
					
					if ( ! flat) str += '<ul>';
					for (i = 0; i < this.children.length; i++) {
						str += this.children[i].toHtml(flat);
					}
					if ( ! flat) str += '</ul>\n';
					
					if (this.parent) {
						str = '<li><a href="#'+ this.id +'">' + this.title + '</a>' + str + '</li>\n';
					}
				}

				if (flat && !this.parent) {
					str += '</ul>';
				}
				
				return str;
			};
			
			$(".orgm-toc").each(function(i){
				var options = $(this).data();
				
				options.level = parseInt(options.level, 10) || 2;
				
				var currentLevel = 0;
				var root = new TocNode(), currentNode = root, parent;
				
				$(options.target).find(options.selector).not(".no-toc").each(function(i){
					var level = parseInt(this.tagName.substr(1), 10);
					var id = $(this).attr("id") || "orgm_h_" + i,
						title = $(this).text(),node;
	
					if (level < options.level) return;
					
					if (currentLevel < level) {
						currentLevel = level;
						node = new TocNode({parent: currentNode, level: level, title: title, id: id});
						currentNode.children.push(node);
						currentNode = node;
					} else if (currentLevel === level) {
						// 上のノードと比較して、同じノードの位置に突っ込む
						currentLevel = level;
						node = new TocNode({parent: currentNode.parent, level: level, title: title, id: id});
						currentNode.parent.children.push(node);
						currentNode = node;
					}
					else {
						currentLevel = level;
						parent = currentNode.findParent(level);
						node = new TocNode({parent: parent, level: level, title: title, id: id});
						parent.children.push(node);
						currentNode = node;
					}
	
				
				});
				
				$(root.toHtml(options.flat)).appendTo(this);
				
				if (options.flat) {
					$(this).addClass("orgm-toc-flat");
				}
				
				if (options.title.length > 0) {
					$('<h2></h2>', {
						class: "no-toc"
					}).text(options.title)
					.prependTo(this);
				}
				
				
			});

		
		}
		
		// error input
		$("input[data-error], textarea[data-error], select[data-error]").each(function(){
			var $input = $(this);
			
			if ($input.attr("data-error").length === 0) return;

			$input
				.closest('.control-group').addClass('error')
				.each(function(){
					
					var $span = $(this).find('.help-block');
					if ($span.length > 0)
						$span.html($input.attr('data-error'));
					else
						$input.after('<span class="help-block"></span>')
							.next().html($input.attr('data-error'));
					
				});
		});
		
		// !MailChimp Form
		$(".orgm-mc-form form").on("submit", function(e){
			
			e.preventDefault();
			
			var $form = $(this);
			var url = $form.attr("action"),
				data = $form.serialize();
			
			var $div = $(this).closest(".orgm-mc-form");
			
			$.ajax({
				url: url,
				type: "post",
				data: data,
				dataType: "json",
				success: function(res){
					
					//TODO: 成功したら出す。メッセージもJSONで受け取る
					$form.find("input, select, textarea").prop("disabled", true);
					$form.find("input:submit").before('<div class="alert alert-success">登録しました！</div>');
					
					if (res.success)
					{
						
						ORGM.notify("成功", "success");
					}
				},
				error: function(res){
				}
			});

		});


		// demo form
		$("form.form-demo").each(function(){
			$(this).off("submit");
		}).on("submit", function(e){
			e.preventDefault();
		});


	    // !ページ内リンクをハック
	    $(document)
	    .on("click", "a[href^='#']:not([href='#']):not([data-orgm-noscroll]):not(.carousel-control):not([data-toggle])", function(e){
	    	e.preventDefault();
	    	ORGM.scroll($(this).attr("href"));
	    	if (history) {
		    	history.replaceState(document.title, '', location.origin + location.pathname + location.search + $(this).attr("href"));
	    	}
	    });
		
		
	});

})(window.jQuery);

/**
 * Flatten height same as the highest element for each row.
 *
 * Copyright (c) 2011 Hayato Takenaka
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 * @author: Hayato Takenaka (http://urin.take-uma.net)
 * @version: 0.0.2
**/
;(function($) {
	$.fn.tile = function(columns) {
		var tiles, max, c, h, last = this.length - 1, s;
		if(!columns) columns = this.length;
		this.each(function() {
			s = this.style;
			if(s.removeProperty) s.removeProperty("height");
			if(s.removeAttribute) s.removeAttribute("height");
		});
		return this.each(function(i) {
			c = i % columns;
			if(c == 0) tiles = [];
			tiles[c] = $(this);
			h = tiles[c].height();
			if(c == 0 || h > max) max = h;
			if(i == last || c == columns - 1)
				$.each(tiles, function() { this.height(max); });
		});
	};
})(jQuery);

;(function($) {
	$.fn.square = function(width) {
		return this.each(function(){
			var $$ = $(this);
			var the_length = width || $$.width();
			
			if (this.style.height) {
				the_length = parseInt(this.style.height.replace("px", ""), 10);
				this.style.height = "";
			}
			
			the_length -= 20;
			
			var classname = $$.wrap('<div><div></div></div>').attr("class");
			$$.parent().parent().attr("class", classname).height(the_length).addClass("orgm-square");
			$$.parent().addClass("orgm-square-wrapper");
			var lineHeight = the_length / 3;
			$$.removeAttr("class").css({
				"font-size" : lineHeight,
				"line-height" : lineHeight + "px"
			}).addClass("orgm-square-content");
			
			setTimeout(function(){
				$$.find("p").css("font-size", lineHeight);
			}, 50);
			
		});
		
	};
})(jQuery);



/**
 * Origami Template Engine for Typeahead.js
 * Wrapped jQuery.tmpl
 */

ORGM.tmpl = {
	compile: function(template){
		this.template = template;
		return this;
	},
	render: function(context){
		return $.tmpl(this.template, context).eq(0).html();
	}
};

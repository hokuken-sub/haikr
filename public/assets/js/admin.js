//------------------------------------------------------------------------
//[For admin window & other plugin] copyright(c) 2007 Hokuken lab.
//------------------------------------------------------------------------
$(document).ready(function(){

	var $msg = $("#msg")
	  , isPreview = $("#preview_body").length;
	  
	// ! loading animation
	$(document)
	.on("ajaxStart", function(e){
/* console.log("ajax start"); */
		if (typeof ORGM.loadingIndicator !== "undefined" && ORGM.loadingIndicator) {
			$("#orgm_loading_indicator").addClass("in");
		}
		
	})
	.on("ajaxStop ajaxError", function(e){
/* console.log("ajax stop or error"); */
		if ((typeof ORGM.loadingIndicator !== "undefined" && ORGM.loadingIndicator)
		 || $("#orgm_loading_indicator").hasClass("in")) {
			$("#orgm_loading_indicator").removeClass("in");
		}
	});
	
	// ! 編集画面
	if ($msg.length > 0) {

		//ブログ編集画面
		if ($("div.qblog_edit_form").length) {
			// オリジナルデータをセット for unload_confirm
			$msg.data("original", $msg.val());
		}
		//通常編集画面
		else {
			$msg.data("original", $msg.val());
		}
		
		//本文にフォーカス
		var msgfocus_timeout = setTimeout(function(){$msg.focus()}, 1000);
		$(window).on("scroll", function(){
        	if ($(this).scrollTop() > ORGM.navbarHTotal) {
	        	clearTimeout(msgfocus_timeout);
	        }
		});

		//not iframe
		if (window == parent) {
			$("#edit_form_main input:submit, #edit_form_cancel input:submit")
			.click(function(){
				// どのボタンが押されたかを保存
				$(this).closest('form').data('clickedButton', $(this).attr('name')); 

				var $submit = $(this).prop("disabled", true);
				$submit.before('<input type="hidden" name="'+$submit.attr("name")+'" value="'+ $submit.val()+'" />');
				$submit.closest("form").submit();
				return false;
			});
		}
		
		$(document).on("click", "[data-edit-type]", function(){
			var btnName = $(this).data('editType');
			if (btnName == 'write') {
				if ($(this).data('name') == 'publish'){
					$('#edit_form_main input:checkbox[name=notimestamp]').prop('checked', false);
					btnName = 'write';
				}
				else
				{
					$('#edit_form_main input:checkbox[name=notimestamp]').prop('checked', true);
				}
			}
		    if (typeof ORGM.loadingIndicator !== "undefined") {
		    	if (typeof ORGM.check_login === "undefined") {
			        $("#orgm_loading_indicator").addClass("in");
			        setTimeout(function(){
				        $("#orgm_loading_indicator").removeClass("in");
			        }, 10000);
			    	
		    	}
		    }

			$('#edit_form_main input:submit[name='+btnName+']').click();
		});
		
		$('#edit_form_main .edit_buttons').hide();
		
		//ボタンを作る
		if (typeof ORGM.toolbuttons !== "undefined") {
			var $box = $("#orgm_toolbox").addClass("btn-toolbar");
			
			for (var i in ORGM.toolbuttons) {
				var $group = $('<div></div>').addClass("btn-group");
				var btn = ORGM.toolbuttons[i], name;
				
				if (typeof btn === "string") {
					name = btn;
				}
				else {
					name = btn.name;
				}
				
				if (typeof ORGM.plugins[name] != "undefined") {
					
					var $btn = $('<a></a>').addClass("btn btn-default btn-sm")
								.attr("data-name", name).attr("data-textarea", "#msg").text(ORGM.plugins[name].label);

					if (typeof ORGM.plugins[name].labelPrefix != "undefined") {
						$btn.prepend(ORGM.plugins[name].labelPrefix);
					}
					if (typeof ORGM.plugins[name].labelSuffix != "undefined") {
						$btn.append(ORGM.plugins[name].labelSuffix);
					}

					if (typeof ORGM.plugins[name].style != "undefined") {
						$btn.css(ORGM.plugins[name].style);
					}
					ORGM.PluginHelper.init($btn);
					$group.append($btn);
					
					if (typeof btn.children != "undefined" && btn.children.length > 0) {
						$ul = $('<ul></ul>').addClass("dropdown-menu");
						
						for (var j in btn.children) {
							var child = btn.children[j];
							if (typeof child === "string") {
								name = child;
							}
							else {
								name = child.name;
							}
							
							if (typeof ORGM.plugins[name] != "undefined") {
								var $li = $('<li><a href="#"></a></li>')
									.children("a").attr("data-name", name).attr("data-textarea", "#msg")
									.text(ORGM.plugins[name].label).css(ORGM.plugins[name].style)
								.end();
								$ul.append($li);
								
								ORGM.PluginHelper.init($li.children("a"));


							}
							
						}
						
						var $dropbtn = $('<a href="#"></a>').addClass("btn btn-default btn-sm dropdown-toggle").attr("data-toggle", "dropdown");
						$dropbtn.append('<span class="caret"></span>');
						$group.append($dropbtn).append($ul);
						
					}
					$box.append($group);
				}
			}

//			var offsetTop = $msg.offset().top - $("#toolbar_upper").height() - $("#orgm_toolbox").height();
			var offsetTop = $("#admin_nav").height();
			$box.addClass("affix").attr("data-spy", "affix").attr("data-offset-top", offsetTop).css({top: $("#toolbar_upper").height()});

			//plugins
			ORGM.PluginHelper.initList();
			
		}
		
		
		// !check login on edit
		if (typeof ORGM.check_login !== "undefined") {

			var $editForm = $("#edit_form_main")
			.on("submit.pluginCheckLogin", function(e){
				e.preventDefault();
				
				var callback = function(){
					//更新する
					var target = $editForm.data("clicked") || "preview";
					$editForm.off("submit.pluginCheckLogin")
						.find("input:submit[name="+target+"]").click();
					
					//load-indicator	
			        $("#orgm_loading_indicator").addClass("in");
			        setTimeout(function(){
				        $("#orgm_loading_indicator").removeClass("in");
			        }, 10000);

					
				};

				ORGM.check_login.check(
					//always
					function(){
						// ページの更新、プレビューボタンのロックを解除
						$(".edit_buttons", $editForm)
							.find("input:submit").prop("disabled", false)
						.end()
							.find("input[type=hidden]").remove();
					},
					//done
					function(res){
						//切れていればlogout notifier 表示
						if (res.status == ORGM.check_login.LOGOUT) {
						
							ORGM.check_login.callback = function(){
								callback.call();
							};
							
							ORGM.check_login.open();
							return;						
						}

						//更新を続行する
						callback.call();
						
					},
					//fail
					function(){
						//更新を続行する
						callback.call();
					}
				);
			});
			
			$editForm.find("input:submit")
			.on("click.pluginCheckLogin", function(){
				$editForm.data("clicked", $(this).attr("name"));
			});
			
		
		}

	}

	// !login form on page
	if (typeof ORGM.check_login !== "undefined") {

		var $loginModal = $("#orgm_login_form")
		.on("shown.bs.modal", function(){
			$("input[name=username]", this).focus();
		})
		.on("click", "[data-login]", function(){
			$loginModal.find("form").submit();
		})
		.on("keydown", "input", function(e){
			if( e.keyCode == 13 ) $("[data-login]", $loginModal).click();
		})
		.on("submit", "form", function(e){
			e.preventDefault();

			var data = $loginModal.find("form").serialize();

			//auth
			$.when($.ajax({
				url: ORGM.baseUrl,
				global: false,
				data: data,
				dataType: "json",
				type: "POST"
			}))
			.done(function(res){

				if (res.status == ORGM.check_login.OK) {
					ORGM.notify(res.message);
					
					setTimeout(function(){
						var callback = $loginModal.data("callback");
						if (typeof ORGM.check_login.callback === "function") {
							ORGM.check_login.callback.call();
						}
						
						$loginModal.modal("hide");
						
					}, 300);
					
					
				} else {
					ORGM.notify(res.message, "error");
					
					//retry
					$loginModal.find("input[name=username]").focus();
				}
			})
			.fail(function(){
				ORGM.notify("通信に失敗しました。もう一度「ログイン」を押してください。", "error");
				//retry
				$loginModal.find("input[name=username]").focus();
			});

		});
		
		ORGM.check_login.open = function(){
			$loginModal.modal();
		};
		
		ORGM.check_login.check = function(always, done, fail){
				$.when($.ajax({
					url: ORGM.baseUrl,
					global: false,
					data: {cmd: "check_login", mode: "check"},
					dataType: "json",
					type: "GET"
				}))
				.always(always)
				.done(done)
				.fail(fail);
			};
	
	}

	
	// プレビュー時のタイムスタンプを変えずに更新
	$("#notimestamp_preview").click(function(){
		var $form = $(this).closest('form');
		$form.find('input:hidden[name=notimestamp]').val('true');
		$form.find('input:submit[name=write]').click();
	});

	// ! unload confirm
	//画面遷移時に変更を破棄するか確認
	if (ORGM.options.unload_confirm) {
		
		//edit
		if ($msg.length > 0) {
			//form からのsubmit では遷移確認を出さない
			$("#edit_form_main").submit(function(e){
				$(window).off(".orgm");
			});
			$("input:submit[name=write], input:submit[name=preview], input:submit[name=cancel]").click(function(){
				$(window).off(".orgm");
			});
		
			$(window).on("beforeunload.orgm", function(e) {
				if ($msg.val() != $msg.data("original")) {
					return '編集中です。移動すると、作成中の内容は保存されません。';
				}
			});
		}
		//preview
		else if ($("#re_edit_button").length > 0) {
			//form からのsubmit では遷移確認を出さない
			$("#edit_form_preview").submit(function(e){
				$(window).off(".orgm");
			});
		
			$(window).on("beforeunload.orgm", function(e) {
				return 'プレビュー中です。移動すると、作成中の内容は保存されません。';
			});
			
		}
	}



	// ! keyboard shortcut on global

	ORGM.waitNextKey = false;
	$(document)
	.on("keydown", function(e){
	
		if ( this !== e.target && (/textarea|select/i.test( e.target.nodeName ) ||
			/text|search|email|password/i.test(e.target.type) || $(e.target).prop('contenteditable') == 'true' )) {
			return;
		}
		
		var character = String.fromCharCode( e.which ).toLowerCase();

		//open shortcut cheat sheat
		if (e.shiftKey && e.keyCode === 191) {
			$("#orgm_shortcut_cheatsheat").modal();
			return;
		}

		//a-z
		if ( ! /[a-z]/.test(character))
			return;


		if (ORGM.waitNextKey) {
			ORGM.waitNextKey = false;
			clearTimeout(ORGM.waitNextKeyQueue);

			switch (character) {
				case 'c'://config
					location.href = ORGM.links.config;
					break;
				case 'd'://design
					$("#designlink").click();
					break;
				case 'e'://edit
					if ($("#re_edit_button").length > 0) $("#re_edit_button").click();
					else if (ORGM.page.length > 0) location.href = ORGM.links.edit;
					break;
				case 'f'://filer
					location.href = ORGM.links.filer;
					break;
				case 'g'://google
					window.open("http://www.google.co.jp");
					break;
				case 'h'://top
					location.href = ORGM.baseUrl;
					break;
				case 'l'://page list
					location.href = ORGM.links.filelist;
					break;
				case 'm'://page meta
					$("#pageinfolink").click();
					break;
				case 'n'://new page
					location.href = ORGM.links.new;
					break;
				case 'q'://search
					$("#sitelink").click();
					break;
				case 't'://go to Top
					$("html,body").animate({scrollTop:0}, "fast");
					break;
			}

		}
		else if (character === "g") {
			ORGM.waitNextKey = true;
			ORGM.waitNextKeyQueue = setTimeout(function(){
				ORGM.waitNextKey = false;
			}, 2000);
		}
	});

	// keyboard shortcut in textarea#msg
	var isWin = (navigator.platform.indexOf('win') != -1);
	
	$msg.keydown(function(e){
		//[esc]
		if (e.keyCode == 27) {
			$(this).blur();
		}
		// ^+1-0 で履歴呼び出し
		else if (((isWin && e.ctrlKey) || (! isWin && e.metaKey)) && e.keyCode >= 48 && e.keyCode <= 57) {
			e.preventDefault();
			var num = ((e.keyCode - 48) + 9) % 10;
			if (typeof ORGM.PluginHelper.recent[num] !== "undefined") {
				ORGM.PluginHelper.directCall({name: ORGM.PluginHelper.recent[num], textarea: "#msg"});
			}
		}
		else if (((isWin && e.ctrlKey) || (! isWin && e.metaKey)) && e.shiftKey && e.keyCode == 80) {
			ORGM.PluginHelper.directCall({name: "allPlugin", textarea: "#msg"});
		}
		//Save [Ctrl + S] [Command + S]
		else if (((isWin && e.ctrlKey) || (! isWin && e.metaKey)) && e.keyCode == 83) {
			e.preventDefault();
			$("[data-edit-type=write]").click();
		}
		//Preview [Ctrl + P] [Command + P]
		else if (((isWin && e.ctrlKey) || (! isWin && e.metaKey)) && e.keyCode == 80) {
			e.preventDefault();
			$("[data-edit-type=preview]").click();
		}
	});
	
	//Share
	$("#sharelink").parent().click(function(){
		$("#orgm_share_page").modal();
	});
	$("#orgm_share_page")
	.on("click", "input", function(){
		$(this).select().focus();
	})
	.on("click", "a[rel=facebook]", function(){
		if (typeof FB === "undefined") return;
		
		var obj = {
			method: 'feed',
			link: location.href,
		};

		FB.ui(obj);
	})
	.on("keyup", "textarea", function(){
		var tweeturl_fmt = $("#orgm_share_page a.shareTwitter").attr("data-format");
		var url = $("#orgm_share_page a.shareTwitter").attr("data-url");
		var title = $("title").text();
		var text = $(this).val().replace('%URL%', url).replace('%TITLE%', title);
		var tweeturl = tweeturl_fmt.replace('$text', encodeURIComponent(text)).replace('$url', url);
		$("#orgm_share_page a.shareTwitter").attr("href", tweeturl);
	})
		.find("textarea").each(function(){
			var title = $("title").text();
			$(this).val($(this).val().replace('%TITLE%', title));
		});
	

    // ! #sitelink クリックで検索欄にフォーカス
    $("#sitelink").on("focus", function(){
    	var $self = $(this);
	    setTimeout(function(){
	    	if ($self.parent("li.dropdown").hasClass("open")) {
			    $self.next().find("input:text").focus().select();
	    	}
	    }, 300);
    });

	// ! admin slider
	$("#admin_slider_link").sidr({
		name: "slider-right",
		source: "#admin_slider",
		side: "right",
		renaming: false,
		onOpen: function(){
			$(document).on("click.adminSlider keydown.adminSlider", "*", function(e){
				
				e.stopPropagation();
				
				if ( ! $(e.target).is("[data-toggle=modal]") && $(e.target).closest(".haik-admin-slider").length > 0) return;
				
				$.sidr('close', 'slider-right');
			});

			$(".haik-admin-slider .close").on('click', function(){
				$.sidr('close', 'slider-right');
			});

		},
		onClose: function(){
			$(document).off(".adminSlider");
		}
	});

    
/*
    // ! #admin_nav 以外の .btn-navbar クリックで #admin_nav を開けないようにする
    $(".btn-navbar:not(.orgm-btn-admin-navbar)").each(function(){
	    var $btn = $(this).closest(".navbar-inner").find(".btn-navbar[data-toggle=collapse][data-target='.nav-collapse']");
	    $btn.attr("data-target", ".navbar:not(#admin_nav) " + $btn.attr("data-target"));
    });
*/

    
    // ! radio-wrapper
    $(".radio-wrapper input:radio").on("click", function(){
	    
	    $(this)
	    	.closest(".radio-wrapper")
	    		.children(".radio-addon").removeClass("hide")
	    	.end()
	    		.siblings(".radio-wrapper")
	    			.children(".radio-addon").addClass("hide");
	    
    });
    
    // ! include wrapper
    $(".orgm-include-wrapper")
    .hover(function(){
		    
	    
	    
    }, function(){
    
	    
    });
    
    // ! ファイル選択ウィンドウ
    if ($("#orgm_filer_selector").length > 0) {
    	
	    var $filer = $("#orgm_filer_selector")
	    .on("show.bs.modal", function(){
	    	var footer = $filer.data("footer")
	    	  , $footer = $filer.find(".modal-footer");
	    	if ($footer.length > 0 && typeof footer !== "undefined") {
		    	var original = $footer.html();
		    	$filer.data("originalFooter", original);
		    	$footer.html(footer);
	    	}
	    
	    	var $iframe = $(this).find("iframe"),
	    		url = $iframe.data("url");
	    	url += "&search_word=" + encodeURIComponent($iframe.data("search_word"))
	    		+ "&select_mode=" + encodeURIComponent($iframe.data("select_mode"));
	    		
	    	if (typeof $iframe.data("org_search_word") === "undefined")
		    	$iframe.data("org_search_word", $iframe.data("search_word"));

		    $iframe.attr("src", url);
		    
		    $("#orgm_filer_search").typeahead({
				name: "filer-search",
				local: ORGM.filerSuggestionData,
				engine: ORGM.tmpl,
				template: '<p><strong>${label}</strong><small>${value}</small></p>'
		    });
	    })
	    .on("hidden.bs.modal", function(){
	    	var orgFooter = $filer.data("originalFooter")
	    	  , $footer = $filer.find(".modal-footer");
		    if ($footer.length > 0 && typeof orgFooter !== "undefined") {
			    $footer.html(orgFooter);
		    }
		    $filer.removeData("context");
		    $("#orgm_filer_search_form input:text[name=search_word]").val("");
	    })
	    .on("click", "[data-cancel]", function(){
		    $filer.modal("hide");
	    })
	    .on("click", ".filer-star-link a, .filer-all-link a", function(e){
		    e.preventDefault();
		    
		    var search_word = $(this).data("search_word")
		      , $iframe = $filer.find("iframe");
		    
		    $iframe.data("search_word", $iframe.data("org_search_word") + " " + search_word);
		    $filer.triggerHandler("show");

			$(".filer-revert-link", $filer).show();
		    
	    })
	    .on("click", ".filer-revert-link a", function(e){
		    e.preventDefault();

		    var $iframe = $filer.find("iframe")
		      , $li = $(this).parent();
		    
		    $iframe.data("search_word", $iframe.data("org_search_word"));
		    $filer.triggerHandler("show");
		    
		    $("#orgm_filer_search_form input:text[name=search_word]").val("");
		    
		    setTimeout(function(){
			    $li.hide();
		    }, 100);
		    
	    })
	    .on("submit", "#orgm_filer_search_form", function(e){
		    e.preventDefault();

		    var search_word = $("input[name=search_word]", this).val()
		      , $iframe = $filer.find("iframe");
		    
		    $iframe.data("search_word", $iframe.data("org_search_word") + " " + search_word);
		    $filer.triggerHandler("show");

			$(".filer-revert-link", $filer).show();
		    
	    })
	    // !フルスクリーン起動
	    .on("click", ".filer-fullscreen-link", function(){

			var iframe = $filer.find("iframe").get(0), interval, loadMore;
			
			ORGM.fullScreen(iframe);
			
			iframe.contentWindow.ORGM.filer.fullscreen = true;
			loadMore = iframe.contentWindow.document.getElementById('load_more');
			loadMore.style.display = "block";
			
			interval = setInterval(function(){
				if (iframe !== document.webkitFullscreenElement
				 && iframe !== document.mozFullScreenElement 
				 && iframe !== document.fullscreenElement) {
					iframe.contentWindow.ORGM.filer.fullscreen = false;
					if (loadMore) loadMore.style.display = "none";
					clearInterval(interval);
				}
			}, 2000);

	    });
	    

	    // ! ダミー画像
	    // D&D で画像アップロード
	    // クリックで画像選択
	    $(document).on("click", ".img-dummy a[data-dummy]", function(e){
	    	e.preventDefault();
	    	
	    	if (isPreview) return;
	    	
		    var data = $(this).data();
			
			$filer.data("context", this).find("iframe").data(data.filerOptions);
			$filer.modal();
	
	    })
		.on("selectFiles", function(e, files){
			var $self = $($filer.data('context'));
			
			if ($self.is("[data-dummy]"))
			{
				var file = files.pop();
				var data = {
					id      : $self.data("dummy"),
					options : $self.data("options"),
					filename: file.filename,
					digest  : ORGM.pageDigest
				};
				
				$.post(ORGM.show.postUrl, data, function(res){
					
					if (res.error) {
						ORGM.notify(res.error, 'error');
					}
					
					 $self.closest('.img-dummy').replaceWith(res.html);
					 ORGM.pageDigest = res.digest;

				}, "json");

				$('#orgm_filer_selector').modal('hide');
			}
			else {

			}
		});
		
		
		//drag で選択画面起動
		$(".img-dummy a[data-dummy]").each(function(e){
			var $self = $(this);
			var dropZone = $(this);
			

		    $(this).next().fileupload({
		    	url: ORGM.show.postUrl,
		    	dataType: 'json',
		    	dropZone: dropZone,
		    	add: function(e, data){
			    	
			    	data.formData = {
						id      : $self.data("dummy"),
						options : $self.data("options"),
						digest  : ORGM.pageDigest
			    	},
			    	
			    	data.submit();
			    },
		        fail: function(e){

		        },
		    	done: function(e, data){
					if (data.result.error) {
						ORGM.notify(data.result.error, 'error');
					}
					
					 $self.closest('.img-dummy').replaceWith(data.result.html);
					 ORGM.pageDigest = data.result.digest;

		    	}
		    });
			
		})
		.on("dragenter", function(e){
			e.preventDefault();
			e.stopPropagation();

		    var dropZone = $(this).closest('.img-dummy');
	        	dropZone.addClass('in');
	        	$(this).text('画像をアップロード');
		})
		.on("dragleave", function(e){
			e.preventDefault();
			e.stopPropagation();

		    var dropZone = $(this).closest('.img-dummy');
	        	dropZone.removeClass('in');
	        	$(this).text('クリックして画像を選択');
		});

    }


    // ! フォーム選択ウィンドウ
    if ($("#orgm_former_selector").length > 0) {
    	
	    var $former = $("#orgm_former_selector")
	    .on("show.bs.modal", function(){
	    	var $iframe = $(this).find("iframe"),
	    		url = $iframe.data("url");

		    $iframe.attr("src", url);
	    })
	    .on("hidden.bs.modal", function(){
	    })
	    .on("click", "[data-cancel]", function(){
		    $former.modal("hide");
	    });

	}
	
	// ! 新規ページ作成
	$('.plugin-newpage')
	.on('click', '[data-template]', function(){
		var $div = $(this).closest('div.controls');
		var template = $(this).data("template");

		$("input:hidden[name=template_name]", $div).val(template);
		$(this).addClass("active").siblings().removeClass("active");
	});

	
	// ! ページ設定 Meta Customizer open-close
	var $metaModal = $("#orgm_meta_customizer")
	.on("show.bs.modal", function(){
		
		$("#tmpl_meta_customizer").tmpl(ORGM.pageMeta).replaceAll("#orgm_meta_customizer .modal-body")
			.find("textarea").exnote({css:{height:"3.5em", fontSize:"14px"}});
		
		$("input:radio[name=close]",$metaModal).val([ORGM.pageMeta.close]).filter(":checked").click();
		$("input:radio[name=redirect_status]",$metaModal).val([ORGM.pageMeta.redirect_status]);
			
	
	})
	.on("click", "[data-template]", function(){
		
		var template = $(this).data("template");
		$("input:hidden[name=template_name]", $metaModal).val(template);
		
		$(this).addClass("active").siblings().removeClass("active");
		
		return false;
	})
	.on("click", "[data-save]", function(){
		
		var data = $("input,textarea", $metaModal).serialize();
		var url = $("form", $metaModal).attr("action");

		$('.control-group', $metaModal).filter('.error').removeClass('error')
			.find('[data-error-message]').remove();
		
		$.post(url, data, function(res){
			if (res.error) {
				$metaModal.find("input, select, textarea").filter("[name="+res.item+"]")
					.after('<span class="help-block" data-error-message>'+res.error+'</span>')
					.closest(".form-group").addClass("error");
			}
			
			if (res.success) {
				location.href = res.redirect;
			}
			
		}, 'json');
		
		return false;

	})
	.on("click", "input:radio[name=close]", function(){
		var sts = $(this).val();
		$("[data-close-set]", $metaModal).hide();
		if ($("#close_"+sts).length)
		{
			if ($(this).prop("checked"))
			{
				$("#close_"+sts).show();
			}
		}
	})
	.on("click", "[data-close-set] input.uneditable-input", function(){
		$(this).select();
	})
	.on("click keydown", "#orgm_page_meta_shortened_url", function(e){
		e.preventDefault();
		$(this).focus().select();
	})

	// ! tooltip link
	$("[data-tooltip]").tooltip();


	
	// !特定のリンクにホバーで強調
	var links = {
		SiteNavigatorLink: "#orgm_nav ul",
		SiteFooterLink: "#orgm_footer",
		MenuBarLink: "#orgm_menu"
	};
	
	var timeout = false;
	$("[data-category=sitelink] > ul > li > a").mouseenter(function(){
		if (timeout !== false) clearTimeout(timeout);
	});
	$("[data-category=editlink] ul > li > a").mouseenter(function(){
		if (timeout !== false) clearTimeout(timeout);
	});

	
	for (var link in links) {
		$("#" + link).hover(function(){
			var link = $(this).attr("id");
			if ($(links[link]).is(":empty")) return;
			
			timeout = setTimeout(function(){
				ORGM.scroll(links[link]);
			}, 500);
			$(links[link]).addClass("highlight");
		}, function(){
			var link = $(this).attr("id");
			$(links[link]).removeClass("highlight");
		}).click(function(){
			if (timeout !== false) clearTimeout(timeout);
		});
	}

	// !プレビュー時のハイライト
	$($('.preview_highlight').data("target")).addClass("highlight");
	if ($(".highlight").length){
		ORGM.scroll($('.preview_highlight').data("target"), 600);
		setTimeout(function(){
			$(".highlight").removeClass("highlight");
		}, 1500);
	}
	
	// !更新チェック
	$.getJSON(ORGM.baseUrl + '?cmd=app_update&mode=check_version', function(data){
		if (data.update) {
			$("#updatelink").html($("#updatelink").text() + ' <i class="orgm-icon-notification"></i>')
				.parent().addClass("update-comes");
		}
	});
	$.getJSON(ORGM.baseUrl + '?cmd=design_wand&mode=check_version', function(data){
		if (data.updates.length > 0) {
			$("#skinupdatelink").html($("#skinupdatelink").text() + ' <i class="orgm-icon-notification"></i>')
				.parent().addClass("update-comes").removeClass("hide");
			$(".orgm-plugin-desgin-wand-link").removeClass("hide");
		}
	});

	// ! Admin methods

	ORGM = $.extend(true, ORGM, {
		getSelectedFiles: function(files){
			$(document).trigger("selectFiles", [files]);
		},
		getSelectedForm: function(id){
			$(document).trigger("selectForm", [id]);
		},
		getPages: function(){
			return ORGM.pages || $.getJSON(ORGM.baseUrl + "?cmd=list&json=1", function(res){
				ORGM.pages = res;
			});
		},
		getPagesForTypeahead: function(){
			return ORGM.pagesForTypeahead || $.when(ORGM.getPages()).done(function(){
				if ( ! ORGM.pagesForTypeahead) {
					ORGM.pagesForTypeahead = _.map(ORGM.pages, function(v, key){
						return {
							value: key,
							tokens: (v==key? [v] : [v, key]),
							title: v
						};
					});
				}
				return new $.Deferred().resolve();
			}).promise();
		},
		pageSuggestionTemplateForTypeahead: '<p><strong>${title}</strong>{{if title!=value}}<small>${value}</small>{{/if}}</p>',
		filerSuggestionData: [
			{value:":image", tokens: [":image", "image", "photo", "画像", "写真"], label: "画像検索"},
			{value:":video", tokens: [":video", "video", "movie", "動画", "映像"], label: "動画検索"},
			{value: ":audio", tokens: [":audio", "audio", "music", "音"], label: "音声検索"},
			{value: ":doc", tokens: [":doc", "document", "書類", "PDF"], label: "書類検索"},
			{value: ":all", tokens: [":all", "all", "全体"], label: "全体検索"},
			{value: ":star", tokens: [":star", "star", "スター", "星"], label: "スター付き検索"}
		],
		fullScreen: function(target){
			if (target.webkitRequestFullScreen) {
				target.webkitRequestFullScreen();
			} else if (target.mozRequestFullScreen) {
				target.mozRequestFullScreen();
			} else {
				target.requestFullScreen();
			}
		},
		fireFullScreen: function(element){
			$(document).trigger("orgmfullscreenchange", [element]);
		}
		
	});
});

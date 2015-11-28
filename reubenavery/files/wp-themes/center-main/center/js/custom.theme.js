function fnInitPhotoSwipeFromDOM(gallerySelector){
	// parse slide data (url, title, size ...) from DOM elements 
	// (children of gallerySelector)
	var parseThumbnailElements = function(el){
		var thumbElements = jQuery(el).find('[data-lightbox=true]'),
			numNodes = thumbElements.length,
			items = [],
			figureEl,
			linkEl,
			size,
			item;

		for(var i = 0; i < numNodes; i++){

			figureEl = thumbElements[i]; // <figure> element

			// include only element nodes 
			if(figureEl.nodeType !== 1){
				continue;
			}

			//linkEl = figureEl.children[0]; // <a> element
			linkEl = jQuery(figureEl).find('.lightbox-item');

			size = linkEl.attr('data-size').split('x');

			// create slide object
			item = {
				src: linkEl.attr('href'),
				w: parseInt(size[0], 10),
				h: parseInt(size[1], 10)
			};



			if(figureEl.children.length > 1){
				// <figcaption> content
				item.title = linkEl.attr('title'); 
			}

			if(linkEl.find('img').length > 0){
				// <img> thumbnail element, retrieving thumbnail url
				item.msrc = linkEl.find('img').attr('src');
			} 

			item.el = figureEl; // save link to element for getThumbBoundsFn
			items.push(item);
		}

		return items;
	};

	// find nearest parent element
	var closest = function closest(el, fn){
		return el && (fn(el) ? el : closest(el.parentNode, fn));
	};

	// triggers when user clicks on thumbnail
	var onThumbnailsClick = function(e){
		e = e || window.event;
		e.preventDefault ? e.preventDefault() : e.returnValue = false;

		var eTarget = e.target || e.srcElement;

		// find root element of slide
		var clickedListItem = closest(eTarget, function(el){
			if(el.tagName){
				return (el.hasAttribute('data-lightbox') && el.getAttribute('data-lightbox') === 'true'); 
			}
		});

		if(!clickedListItem){
			return;
		}

		// find index of clicked item by looping through all child nodes
		// alternatively, you may define index via data- attribute
		var clickedGallery = jQuery(clickedListItem).parents('.lightbox-photoswipe'),
			childNodes = clickedGallery.find('[data-lightbox=true]'),
			numChildNodes = childNodes.length,
			nodeIndex = 0,
			index;

		for (var i = 0; i < numChildNodes; i++){
			if(childNodes[i].nodeType !== 1){ 
				continue; 
			}

			if(childNodes[i] === clickedListItem){
				index = nodeIndex;
				break;
			}
			nodeIndex++;
		}
		
		if(index >= 0){
			// open PhotoSwipe if valid index found
			openPhotoSwipe(index, clickedGallery[0]);
		}
		return false;
	};

	// parse picture index and gallery index from URL (#&pid=1&gid=2)
	var photoswipeParseHash = function(){
		var hash = window.location.hash.substring(1),
		params = {};

		if(hash.length < 5) {
			return params;
		}

		var vars = hash.split('&');
		for (var i = 0; i < vars.length; i++) {
			if(!vars[i]) {
				continue;
			}
			var pair = vars[i].split('=');  
			if(pair.length < 2) {
				continue;
			}           
			params[pair[0]] = pair[1];
		}

		if(params.gid) {
			params.gid = parseInt(params.gid, 10);
		}

		if(!params.hasOwnProperty('pid')) {
			return params;
		}
		params.pid = parseInt(params.pid, 10);
		return params;
	};

	var openPhotoSwipe = function(index, galleryElement, disableAnimation){
		var pswpElement = document.querySelectorAll('.pswp')[0],
			gallery,
			options,
			items;

		items = parseThumbnailElements(galleryElement);

		// define options (if needed)
		options = {
			index: index,

			// define gallery index (for URL)
			galleryUID: galleryElement.getAttribute('data-pswp-uid'),

			getThumbBoundsFn: function(index) {
				// See Options -> getThumbBoundsFn section of documentation for more info
				var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
					pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
					rect = thumbnail.getBoundingClientRect(); 

				return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
			}

		};

		if(disableAnimation) {
			options.showAnimationDuration = 0;
		}

		// Pass data to PhotoSwipe and initialize it
		gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
		gallery.init();
	};

	// loop through all gallery elements and bind events
	var galleryElements = document.querySelectorAll(gallerySelector);
	
	for(var i = 0, l = galleryElements.length; i < l; i++){
		galleryElements[i].setAttribute('data-pswp-uid', i+1);
		galleryElements[i].onclick = onThumbnailsClick;
	}

	// Parse URL and open gallery if it contains #&pid=3&gid=1
	var hashData = photoswipeParseHash();
	if(hashData.pid > 0 && hashData.gid > 0) {
		openPhotoSwipe( hashData.pid - 1 ,  galleryElements[ hashData.gid - 1 ], true );
	}
}

(function($){

    "use strict"; 
	
	var themeData                    = [];
	var parallaxImages               = [];
	var galleryListMoreID            = '';
	var galleryListPrevID            = '';
	var galleryListNextID            = '';
	var galleryListWrap              = [];
	var galleryListMorePermalink     = '';
	var galleryListCurrentPermalink  = false;
	var galleryFlexslider            = '';
	
	var galleryIsLoaded              = false;
	var galleryIsClosed              = false;
	var galleryIsRevealed            = false;
	var galleryIsNavi                = false;
	
	var galleryParentTitle           = $('title').text();
	var galleryParentUrl             = window.location.href;
	
	//window
	themeData.win                    = $(window);
	themeData.winHeight              = themeData.win.height();
	themeData.winScrollTop           = themeData.win.scrollTop();
	themeData.winHash                = window.location.hash.replace('#', '');
	themeData.stateObject            = {};
	
	//document
	themeData.doc                    = $(document);
	themeData.docHeight              = themeData.doc.height();

	//ID A~Z
	themeData.header                 = $('#main-navi');
	themeData.jplayer                = $('#jquery_jplayer');
	themeData.logo                   = $('#logo');
	themeData.MainNaviInn            = $('#main-navi-inn');
	themeData.MenuToggle             = $('#menu_toggle');
	themeData.navi                   = $('#navi');
	themeData.naviMenu               = $('#navi .menu');
	themeData.container              = $('#wrap');
	themeData.WrapOurter             = $('#wrap-outer');
	themeData.searchOpen             = $('#search-top-btn');
	themeData.searchOverlay          = $('#search-overlay');
	themeData.searchClose            = $('#search-overlay-close');
	themeData.searchResult           = $('#search-result');
	themeData.socialHeader           = $('#social-header-out');
	themeData.topSliderFlexslider    = $('#top-slider').find('.flexslider');
	themeData.galleryListTitle       = $('#gallery-list-title');
	themeData.galleryListMore        = $('#gallery-list-more, #top-slider .slide-item');
	themeData.galleryWrapAjaxContent = $('#gallery-wrap-ajax-content');
	themeData.galleryWrapAjaxMask    = $('#gallery-wrap-ajax-mask');
	themeData.contentWrap            = $('#content_wrap');
	
	//tag
	themeData.body                   = $('body');
	
	//tag class
	themeData.uxResponsive           = $('body.responsive-ux');
	themeData.headerNaviMenu         = themeData.header.find('#navi ul.menu');
	themeData.galleryCollage         = $('section.Collage');
	
	//class
	themeData.audioUnit              = $('.audio-unit');
	themeData.flexDirectionNav       = $('.flex-direction-nav');
	themeData.GalleryListSlider      = $('.gallery-list-slider');
	themeData.lightboxPhotoSwipe     = $('.lightbox-photoswipe');
	themeData.Menu                   = $('.menu');
	themeData.pagenumsDefault        = $('.pagenums-default');
	themeData.pageLoading            = $('.loading-mask1');
	themeData.pageLoading2           = $('.loading-mask2');
	themeData.tooltip                = $('.tool-tip');
	themeData.RelaPostCarousel       = $('.related-posts-carousel');
	themeData.blurFrontImage         = $('.top-hot-img-wrap');
	themeData.blurBgImage            = $('.top-hot-blur-img-wrap');
	themeData.searchForm             = $('.search-overlay-form');
	
	themeData.videoFace              = $('.blog-unit-img-wrap');
	themeData.videoOverlay           = $('.video-overlay');
	
	themeData.blogPagenumsTwitter    = $('.blog-list .pagenums.page_twitter a, .magzine-list .pagenums.page_twitter a');
	themeData.blogPagenumsSelect     = $('.blog-list .pagenums .select_pagination, .magzine-list .pagenums .select_pagination');
	
	
	themeData.pageTemplateSlider     = $('.page-template-slider');
	themeData.pageTemplateNaviPost   = $('.page-template-slider .gallery-navi-post');
	themeData.pageTemplateFooter     = $('.page-template-slider #footer');
	themeData.galleryNaviLink        = $('.gallery-navi-a');
	themeData.galleryNaviPrev        = themeData.pageTemplateSlider.find('.gallery-navi-post .gallery-navi-prev');
	themeData.galleryNaviNext        = themeData.pageTemplateSlider.find('.gallery-navi-post .gallery-navi-next');
	
	
	//define
	themeData.globalFootHeight       = 0;
	
	var resizeTimer = null;
	
	//condition
	themeData.isResponsive = function(){
		if(themeData.uxResponsive.length){
			return true;
		}else{
			return false;
		}
	}
	
	if( themeData.headerNaviMenu.find('> li').length > 7 ){
		var switchWidth = 979;
	}else{
		var switchWidth = 769;
	}
	
	themeData.isMobile = function(){
		if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || themeData.win.width() < switchWidth){
			return true; 
		}else{
			return false;
		}
	}
	
	
	//function
	//Top Slider function
	themeData.fnTopSlider = function(){
		themeData.topSliderFlexslider.each(function(){
			var flexslider = [];
			
			flexslider.item = $(this);
			flexslider.direction = flexslider.item.data('direction');
			flexslider.control = flexslider.item.data('control');
			flexslider.speed = flexslider.item.data('speed');
			flexslider.animationSpeed = 500;
			
			if(themeData.pageTemplateSlider.length){
				flexslider.item.find('.slide-item').each(function(){
					var the_ID = $(this).attr('data-id');
					var the_permalink = $(this).attr('data-permalink');
					
					galleryListWrap[the_ID] = the_permalink;
				});
			}
			
			galleryFlexslider = flexslider.item;
			
			flexslider.item.flexslider({
				animation: "slide",
				animationLoop: true,
				animationSpeed: flexslider.animationSpeed,
				slideshow: false, 
				smoothHeight: true,  
				controlNav: flexslider.control, //Dot Nav
				directionNav: true,  // Next\Prev Nav
				touch: false, 
				slideshowSpeed: flexslider.speed * 1000,
				start: function(slider){
					if(themeData.topSliderFlexslider.length){
						galleryListMoreID = flexslider.item.find('.flex-active-slide').attr('data-id');
						galleryListPrevID = flexslider.item.find('.flex-active-slide').prev().attr('data-id');
						galleryListNextID = flexslider.item.find('.flex-active-slide').next().attr('data-id');
						
						themeData.galleryListTitle.text(flexslider.item.find('.flex-active-slide').attr('title'));
					}
				},
				after: function(slider){
					if(themeData.topSliderFlexslider.length){
						galleryListMoreID = flexslider.item.find('.flex-active-slide').attr('data-id');
						galleryListPrevID = flexslider.item.find('.flex-active-slide').prev().attr('data-id');
						galleryListNextID = flexslider.item.find('.flex-active-slide').next().attr('data-id');
						
						galleryListMorePermalink = flexslider.item.find('.flex-active-slide').attr('data-permalink');
						themeData.fnGalleryNaviCurrent(galleryListMorePermalink);
						
						themeData.galleryListTitle.text(flexslider.item.find('.flex-active-slide').attr('title'));
						
						/*if(galleryIsNavi){
							themeData.fnGalleryScrollToggle(true, galleryListMoreID, galleryListWrap[galleryListMoreID]);
						}*/
						
					}
				}

			});

			themeData.win.bind('resize', function() { 
				setTimeout(function(){ 
					var sliderdata = flexslider.item.data('flexslider'); 
					
					if(themeData.win.width() > switchWidth) {
						var flexsliderH = themeData.win.height()-130;
					} else {
						var flexsliderH = themeData.win.height()-160;
					}

					flexslider.item.height(flexsliderH);
					flexslider.item.find('.slide-item').height(flexsliderH);
					sliderdata.resize();
				}, 1000);
			});

		});
	}
	

	//Search show
	themeData.fnSerchShow = function(){

		themeData.searchOverlay.css('height',themeData.winHeight);

		themeData.searchOpen.click(function(){
			if(!themeData.searchOverlay.hasClass('search-fadein')){
				themeData.searchOverlay.addClass('search-fadein');
				$('body,html').addClass('no-scroll').css('height',themeData.winHeight);
				$('.search-overlay-input-text').focus();
			}
		});
		themeData.searchClose.click(function(){
			if(themeData.searchOverlay.hasClass('search-fadein')){
				themeData.searchOverlay.removeClass('search-fadein');
				$('body,html').removeClass('no-scroll').css('height','auto');
			}
		});
	}
	
	//Search form
	themeData.fnSearchForm = function(){
		themeData.searchForm.submit(function(event){
			var search_result = themeData.searchForm.find('input[name=s]');
			var search_loading = $('<div id="search-loading"><div class="search-loading">...</div></div>');
			
			event.preventDefault();
			themeData.searchResult.html(search_loading);
			var data = {
				'keywords' : search_result.val(),
				'paged'    : 1
			}
			
			$.post(AJAX_M, {
				'mode': 'search-list',
				'data': data
			}).done(function(content){
				var content = $(content);
				themeData.searchResult.html(content);
				themeData.fnSearchPaged(search_result.val(), search_loading);
				
				themeData.searchResult.find('.search-result-unit a').click(function(){
					themeData.fnPageLoadingEvent($(this));
				});
			});
		});
	}
	
	//Search form paged
	themeData.fnSearchPaged = function(keywords, loading){
		var load_more = themeData.searchResult.find('a.tw-style-a');
		if(load_more.length){
			load_more.click(function(){
				var paged = $(this).attr('data-paged');
				
				$(this).parent().remove();
				themeData.searchResult.append(loading);
				
				var data = {
					'keywords' : keywords,
					'paged'    : paged
				}
				
				$.post(AJAX_M, {
					'mode': 'search-list',
					'data': data
				}).done(function(content){
					var content = $(content);
					themeData.searchResult.append(content);
					themeData.searchResult.find('#search-loading').remove();
					themeData.fnSearchPaged(keywords, loading);
					
				});
			});
		}
	}

	//Responsive Mobile Menu function
	themeData.fnResponsiveMenu = function(){
		 
		if(!themeData.header.length) return;
		
		var 
		menu                 = $('#navi ul.menu'),
		container            = themeData.container,
		mobile_advanced      = menu.clone().attr({id:"mobile-advanced", "class":""}),
		menu_added           = false;


						
			if(themeData.win.width() > switchWidth) {
				themeData.body.removeClass('ux-mobile');
				if(themeData.body.hasClass('navi-top-layout')) {
					themeData.MainNaviInn.css('display','inline-block');
				} else {
					themeData.MainNaviInn.css('display','block');
					themeData.GalleryListSlider.css('min-height',themeData.win.height());
				}
				
			} else {
				themeData.body.addClass('ux-mobile');
				themeData.MainNaviInn.css('display','none');
				if(themeData.body.hasClass('navi-side-layout')) {
					themeData.GalleryListSlider.css('min-height',themeData.win.height() - 80);
				}
			}

			themeData.win.resize(function(){
				if(themeData.win.width() > switchWidth) {
					themeData.body.removeClass('ux-mobile');
					themeData.GalleryListSlider.css('min-height',themeData.win.height());
					if(themeData.body.hasClass('navi-top-layout')) {
						themeData.MainNaviInn.css('display','inline-block');
					} else {
						themeData.MainNaviInn.css('display','block');
						themeData.GalleryListSlider.css('min-height',themeData.win.height());
					}
					
				} else {
					themeData.body.addClass('ux-mobile');
					themeData.MainNaviInn.css('display','none');
					if(themeData.body.hasClass('navi-side-layout')) {
						themeData.GalleryListSlider.css('min-height',themeData.win.height() - 80);
					}
					
				}
				
			});
		

		themeData.MenuToggle.click(function () {
			if (themeData.MainNaviInn.is(":visible")) {
				themeData.MainNaviInn.slideUp()
			} else {
				themeData.MainNaviInn.slideDown()
			}
			return false;
		});	
    }
	
	
	//audio player function
	themeData.fnJplayerCall = function(){
		if(themeData.jplayer.length){
			themeData.jplayer.jPlayer({
				ready: function(){
					$(this).jPlayer("setMedia", {
						mp3:""
					});
				},
				swfPath: JS_PATH,
				supplied: "mp3",
				wmode: "window"
			});
			
			themeData.audioPlayClick(themeData.body);
			themeData.audioPauseClick(themeData.body);
		}
	}
	
	//call player play
	themeData.audioPlayClick = function(container){
		container.find('.pause').click(function(){
			var thisID = $(this).attr("id");
			container.find('.audiobutton').removeClass('play').addClass('pause');
			$(this).removeClass('pause').addClass('play');
			themeData.jplayer.jPlayer("setMedia", {
				mp3: $(this).attr("rel")
			});
			themeData.jplayer.jPlayer("play");
			themeData.jplayer.bind($.jPlayer.event.ended, function(event) {
				$('#'+thisID).removeClass('play').addClass('pause');
			});
			themeData.audioPauseClick(container);
			themeData.audioPlayClick(container);
		})
	}
	
	//call player pause
	themeData.audioPauseClick = function(container){
		container.find('.play').click(function(){
			$(this).removeClass('play').addClass('pause');
			themeData.jplayer.jPlayer("stop");
			themeData.audioPlayClick(container);
		})
	}
	
	//page loading event
	themeData.fnPageLoadingEvent = function(el){
		var _url = el.attr('href');
		if(_url){
			themeData.pageLoading2.addClass('mask2-show');
			setTimeout(function(){
				window.location.href = _url;
			}, 2000);
			
		}
	}
	
	//video face
	themeData.fnVideoFace = function(arrayVideo){
		arrayVideo.each(function(){
			var videoFace = [];
			var videoOverlay = [];
			
			videoFace.item = $(this);
			videoFace.playBtn = videoFace.item.find('.blog-unit-video-play');
			videoFace.videoWrap = videoFace.item.find('.video-wrap');
			videoFace.videoIframe = videoFace.videoWrap.find('iframe');
			
			videoOverlay.item = themeData.videoOverlay;
			videoOverlay.videoWrap = videoOverlay.item.find('.video-wrap');
			videoOverlay.close = videoOverlay.item.find('.video-close');
			
			videoFace.playBtn.click(function(){
				var src = videoFace.videoIframe.attr('src').replace('autoplay=0', 'autoplay=1');
				videoFace.videoIframe.attr('src', src);
				videoOverlay.close.before(videoFace.videoWrap.removeClass('hidden').attr('style', 'height:100%;padding-bottom:0px;'));
				videoOverlay.item.addClass('video-slidedown');
				
				return false;
			});
			
			videoOverlay.close.click(function(){
				videoOverlay.item.removeClass('video-slidedown');
				videoOverlay.item.find('.video-wrap').remove();
			});
		});
	}
	
	//Module Load Ajax
	themeData.fnModuleLoad = function(data, container){
		$.post(AJAX_M, {
			'mode': 'module',
			'data': data
		}).done(function(content){
			var newElems = $(content); 
			switch(data['mode']){
				case 'pagenums': 
					var this_pagenums = container.find('a[data-post='+data["module_post"]+'][data-paged='+data["paged"]+']');
					this_pagenums.text(data["paged"]);
					$('html,body').animate({
						scrollTop: container.parent().offset().top - 80
					},
					1000); 

					container.parent().find('section').remove();
					container.before(newElems);
				break;
				case 'twitter': 
					var this_twitter = container.find('a[data-post='+data["module_post"]+']');
					this_twitter.attr('data-paged',Number(data['paged']) + 1).text('...').removeClass('tw-style-loading');
					if(data['paged'] == this_twitter.data('count')){
						this_twitter.fadeOut(300);
						this_twitter.parent('.page_twitter').css('margin-top','0');
					}

					container.before(newElems);
				break;
			}
			
			//Fadein theitems of next page 
			newElems.animate({opacity:1}, 1000); 
			
			//gallery
			themeData.gallerycarousel = $('.blog-gallery-carousel');
			if(themeData.gallerycarousel.length){
				themeData.fnGalleryCarousel();
			}

			//Audio player
			themeData.fnJplayerCall();
			themeData.jplayer.jPlayer("stop");
			themeData.audioPlayClick(newElems);
			themeData.audioPauseClick(newElems);
			
			//Video play
			if(newElems.find('.blog-unit-img-wrap').length){
				themeData.fnVideoFace(newElems.find('.blog-unit-img-wrap'));
			}

			//gallery list
			if(newElems.find('.Collage').length){
				$('.Collage').imagesLoaded(function(){ 
					$('.Collage').removeWhitespace().collagePlus({
						'fadeSpeed'     : 2000,
						'targetHeight'  : 200
					});
				});
			}

			//Lightbox
			if(newElems.find('.lightbox').length){
				$('.lightbox').magnificPopup({
					type:'image',
					removalDelay: 500,
					zoom: {
						enabled: true,
						duration: 300 // don't foget to change the duration also in CSS
					},
					mainClass: 'mfp-with-zoom mfp-img-mobile'
				});
			}
			//Lightbox group
			if(newElems.find('.lightbox-parent').length){
				$('.lightbox-parent').each(function(){
					$(this).magnificPopup({
						delegate: 'a.lightbox-item',
						type: 'image',
						preload: [1,3],
						removalDelay: 300,
						mainClass: 'mfp-fade mfp-img-mobile',
						zoom: {
							enabled: true,
							duration: 300 // don't foget to change the duration also in CSS
						},
				        gallery: { enabled: true }
					});
				});
			}

		});
	}
	
	//gallery collage
	themeData.fnGalleryCollage = function(collageWrap){
		collageWrap.removeWhitespace().collagePlus({
			'fadeSpeed'     : 2000,
			'targetHeight'  : 200
		});
	}
	
	//gallery navi current
	themeData.fnGalleryNaviCurrent = function(get_the_permalink){
		var the_permalink = get_the_permalink ? get_the_permalink : galleryListCurrentPermalink;
		
		if(the_permalink){
			themeData.galleryNaviLink.each(function(index){
				if(the_permalink == $(this).attr('href')){
					themeData.galleryNaviLink.parent().removeClass('gallery-navi-li-active');
					$(this).parent().addClass('gallery-navi-li-active');
				}
			});
		}
	}
	
	//gallery navi
	themeData.fnGalleryNavi = function(){
		themeData.galleryNaviLink.each(function(index){
			$(this).click(function(){
				var time = 0;
				
				if(themeData.topSliderFlexslider.is(':hidden')){
					time = 1200;
				}
				
				if(!!(window.history && history.pushState)){
					if(!Modernizr.touch){
						if(galleryIsRevealed){
							themeData.fnGalleryScrollToggle(false);
						}
					}
				}
				
				themeData.galleryNaviLink.parent().removeClass('gallery-navi-li-active');
				$(this).parent().addClass('gallery-navi-li-active');
				//galleryIsNavi = true;
				setTimeout(function(){
					themeData.topSliderFlexslider.flexslider(index);
				}, time);
				
				return false;
			});
        });
	}
	
	//gallery more
	themeData.fnGalleryListMore = function(){
		themeData.galleryListMore.click(function(){
			if(galleryListMoreID != ''){
				themeData.fnGalleryScrollToggle(true, galleryListMoreID, galleryListWrap[galleryListMoreID]);
			}
		});
	}
	
	//gallery navi prev
	themeData.fnGalleryNaviPrev = function(){
		themeData.galleryNaviPrev.click(function(){
			galleryIsLoaded = false;
			if(galleryListPrevID != ''){
				if(galleryIsRevealed){
					themeData.fnGalleryScrollToggle(false);
				}
				galleryIsNavi = true;
				setTimeout(function(){
					themeData.topSliderFlexslider.flexslider('prev');
				}, 1200);
				//themeData.fnGalleryScrollToggle(true, galleryListPrevID, galleryListWrap[galleryListPrevID]);
				themeData.fnGalleryNaviCurrent(galleryListWrap[galleryListPrevID]);
			}
		});
	}
		
	//gallery navi next
	themeData.fnGalleryNaviNext = function(){
		themeData.galleryNaviNext .click(function(){
			galleryIsLoaded = false;
			if(galleryListNextID != ''){
				if(galleryIsRevealed){
					themeData.fnGalleryScrollToggle(false);
				}
				galleryIsNavi = true;
				setTimeout(function(){
					themeData.topSliderFlexslider.flexslider('next');
				}, 1200);
				//themeData.fnGalleryScrollToggle(true, galleryListNextID, galleryListWrap[galleryListNextID]);
				themeData.fnGalleryNaviCurrent(galleryListWrap[galleryListNextID]);
			}
		});
	}
	
	//gallery wrap
	themeData.fnGalleryWrap = function(the_ID, the_permalink){
		//themeData.fnGalleryScrollToggle(1, the_ID, the_permalink);
	}
	
	//Gallery Scroll
	themeData.fnGalleryScroll = function(){
		var DomScrollY = themeData.fnDomScrollY();
		if(DomScrollY <= 0 && galleryIsRevealed){
			themeData.fnGalleryScrollToggle(false);
		}else if(DomScrollY > 0 && !galleryIsRevealed){
			themeData.fnGalleryScrollToggle(true, galleryListMoreID, galleryListWrap[galleryListMoreID]);
		}
	}
	
	//Gallery Scroll Toggle
	themeData.fnGalleryScrollToggle = function(reveal, the_ID, the_permalink){
		var to_permalink = false;
		
		if(!!(window.history && history.pushState)){
			if(Modernizr.touch){
				to_permalink = true;
			}
		}else{
			to_permalink = true;
		}
		
		if(to_permalink){
			document.location.href = the_permalink;
		}else{
			if(reveal){
				if(the_permalink && !galleryIsLoaded){
					var the_title = '';
					
					galleryIsLoaded = true;
					galleryIsRevealed = true;
					
					themeData.galleryWrapAjaxMask.fadeIn('slow');
					themeData.galleryWrapAjaxContent.hide(0).removeClass('visible');
					themeData.galleryWrapAjaxContent.load(the_permalink+ ' #content_wrap > *', function(){
						//lightbox
						fnInitPhotoSwipeFromDOM('.lightbox-photoswipe');
					});
					themeData.galleryWrapAjaxContent.prev().removeClass('modify');
					
					setTimeout(function(){
						themeData.galleryWrapAjaxContent.prev().hide(0, function(){
							setTimeout(function(){
								themeData.galleryWrapAjaxContent.show(function(){
									themeData.galleryWrapAjaxMask.fadeOut('fast');
									themeData.galleryWrapAjaxContent.addClass('visible');
									themeData.pageTemplateNaviPost.show().addClass('visible');
									if(the_ID){
										galleryListPrevID = galleryFlexslider.find('[data-id=' +the_ID+ ']').prev().attr('data-id');
										galleryListNextID = galleryFlexslider.find('[data-id=' +the_ID+ ']').next().attr('data-id');
									}
									
									setTimeout(function(){themeData.pageTemplateFooter.fadeIn();},900);
									
									the_title = themeData.galleryWrapAjaxContent.find('h1.title-h1').text();
									window.history.pushState(themeData.stateObject, the_title, the_permalink);
									
									$('title').text(the_title);
	
									//call js after ajax
									//Collage
									if(themeData.galleryWrapAjaxContent.find('section.Collage').length){
										themeData.galleryWrapAjaxContent.find('img').imagesLoaded(function(){ 
											themeData.fnGalleryCollage(themeData.galleryWrapAjaxContent.find('section.Collage'));
										});
									}
									//Audio player
									if(themeData.galleryWrapAjaxContent.find('.audio_player_list').length){
										themeData.fnJplayerCall();
										themeData.jplayer.jPlayer("stop"); 
									}
								});
							}, 400);
						});
					}, 400);
				}
			}else{
				galleryIsRevealed = false;
				$('body, html').animate({
					scrollTop: 0
				}, 400, function(){
					galleryIsLoaded = false;
					themeData.galleryWrapAjaxMask.fadeIn();
					window.history.pushState(themeData.stateObject, galleryParentTitle, galleryParentUrl);
					
					$('title').text(galleryParentTitle);
					//themeData.galleryWrapAjaxContent.hide().find('> *').remove();
					themeData.galleryWrapAjaxContent.removeClass('visible');
					setTimeout(function(){
						themeData.galleryWrapAjaxContent.find('> *').remove()
					},600);
					themeData.galleryWrapAjaxContent.prev().show(0, function(){
						themeData.galleryWrapAjaxContent.prev().addClass('modify');
						//themeData.galleryWrapAjaxContent.removeClass('visible');
						themeData.pageTemplateNaviPost.hide().removeClass('visible');
						themeData.pageTemplateFooter.hide();
					});
				});
			}
		}
	}

	//Navi - Sidebar fixed
	var smartAffix = function(sidebarID) {
	  var sidebar = $(sidebarID)
	    , threshold
	    , windowWidth;
	  
	  var affixSidebar = function() {
	    if(windowWidth > 768 && $(window).scrollTop() > threshold && $(sidebar).outerHeight()>$(window).height()) {
	      $(sidebar).addClass('affix');
	    } else {
	      $(sidebar).removeClass('affix');
	    }
	  };

	  var smartAffix_init = function() {
	    $(sidebar).removeClass('affix');

	    var sidebarHeight = $(sidebar).outerHeight()
	      , windowHeight = $(window).height()
	      , offsetTop = $(sidebar).offset().top
	      , offsetBottom = windowHeight - (sidebarHeight + offsetTop);

	    if(offsetBottom > 0) {
	      // large screens (sidebar content requires no scrolling)
	      threshold = 0;
	    } else { 
	      // smaller screens (scroll sidebar height before affixing)
	      offsetBottom = 40
	      threshold = sidebarHeight + offsetTop + offsetBottom - windowHeight;
	    }
	    
	    //$(sidebar).css('bottom', offsetBottom).css('top','auto');
	    windowWidth = $(window).width();
	    affixSidebar();
	  };

	  smartAffix_init();
	  $(window).scroll(affixSidebar).resize(smartAffix_init);

	}
	
	//scroll Y
	themeData.fnDomScrollY = function(){
		return themeData.win.scrollTop();
	}
	
	//document ready
	themeData.doc.ready(function(){

		if( Modernizr.touch ) {
			if (!themeData.body.hasClass('ux-mobile')){
				jQuery( '#navi li:has(ul)' ).doubleTapToGo();
			}
		}
		
		//call mobile menu
		if(themeData.isResponsive()){
			themeData.fnResponsiveMenu();
		}

		//Pageone navi
		if($('.anchor-in-current-page').length){
			if(themeData.WrapOurter.hasClass('enbale-onepage')) {
				themeData.Menu.onePageNav({
					currentClass: 'current',
					filter: ':not(.external)'
				});
			}
		}
		
		//Call Lightbox 
		if(themeData.lightboxPhotoSwipe.length){
			fnInitPhotoSwipeFromDOM('.lightbox-photoswipe');
		}
		
		//Call Tip
		if(themeData.tooltip.length){
			themeData.tooltip.tooltip();
		}
		
		//Pagenumber re-layout
		if(themeData.pagenumsDefault.length) {
			themeData.pagenumsDefault.each(function(){
				if($(this).find('.prev').length && $(this).find('.next').length){
					$(this).find('.next').after($(this).find('.prev'));
				}
			});
		}
		
		//Call audio player
		if(themeData.audioUnit.length > 0){
			themeData.fnJplayerCall();
		}
		
		
		//call video popup
		if(themeData.videoFace.length){
			themeData.fnVideoFace(themeData.videoFace);
		}
		
		//Page Loading
		if(themeData.pageLoading.length){
			//if(!Modernizr.touch){

	
				//sidebar menu
				$('#navi ul.menu li:not(.anchor-in-current-page) a').click(function(){
					if(!Modernizr.touch){
						if(!$(this).parent().hasClass('current-menu-anchor')){
							themeData.fnPageLoadingEvent($(this));
							return false;
						}
					} else {
						if(!$(this).parent().hasClass('current-menu-anchor')&& !$(this).parent().hasClass('menu-item-has-children')){
							themeData.fnPageLoadingEvent($(this));
							return false;
						}
					}	
				});
			
				//all search form
				$('.search_top_form_text').parents('form').submit(function(){
					$("html, body").css({height:themeData.winHeight, overflow:"hidden"});
					themeData.pageLoading.fadeIn(300, function(){
						themeData.pageLoading.addClass('visible');
					});
				});
			
				//Logo
				$('#logo a').click(function(){
					themeData.fnPageLoadingEvent($(this));
					return false;
				});
	
				//WPML
				if($('.wpml-language-flags').length) {
					$('.wpml-language-flags a').click(function(){
						themeData.fnPageLoadingEvent($(this));
						return false;
					});
				}
	
				//post navi, Related posts
				$('.post-navi-unit-a,.post-navi-unit-tit a, .related-posts-carousel-li a, .page-numbers').click(function(){
					themeData.fnPageLoadingEvent($(this));
					return false;
				});
				
				//gallery navi
				$('.single .gallery-navi-post a').click(function(){
					themeData.fnPageLoadingEvent($(this));
					return false;
				});
			
				//slide template / archive unit
				$('.disable-scroll-a,.blog-unit-tit a,.subscribe-link-a,.article-meta-unit a,.blog-unit-more-a').click(function(){
					themeData.fnPageLoadingEvent($(this));
					return false;
				});
			
				//sidebar widget
				$('.widget_archive a, .widget_recent_entries a, .widget_search a, .widget_pages a, .widget_nav_menu a, .widget_tag_cloud a, .widget_calendar a, .widget_text a, .widget_meta a, .widget_categories a, .widget_recent_comments a, .widget_tag_cloud a').click(function(){
					themeData.fnPageLoadingEvent($(this));
					return false;
				});
			
				/** Module*/
				$('.moudle .iterlock-caption a, .moudle .tab-content a, .moudle .accordion-inner a, .moudle .blog-item a, .moudle .isotope a, .moudle .ux-btn, .moudle .post-carousel-item a, .moudle .caroufredsel_wrapper:not(.portfolio-caroufredsel) a').click(function(){
					if($(this).is('.lightbox')||$(this).is('.tw-style-a')||$(this).is('.lightbox-item')){}else if($(this).is('.liquid_list_image')){}else if($(this).is('.ajax-permalink')){}else{
						themeData.fnPageLoadingEvent($(this));
						return false;
					}
				});
	
				//Porfolio template
				$('.related-post-unit a,.tags-wrap a').click(function(){	
					themeData.fnPageLoadingEvent($(this));
					return false;
				});
		
				//Woocommerce
				$('.prouduct-item-a').click(function(){	
					themeData.fnPageLoadingEvent($(this));
					return false;
				});
		
			//}
		
			$("html, body").css({height: themeData.winHeight});
			
		}

		//PageCover  Scroll Pushed Effect
		
		// detect if IE : from http://stackoverflow.com/a/16657946		
		var ie = (function(){
			var undef,rv = -1; // Return value assumes failure.
			var ua = window.navigator.userAgent;
			var msie = ua.indexOf('MSIE ');
			var trident = ua.indexOf('Trident/');

			if (msie > 0) {
				// IE 10 or older => return version number
				rv = parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
			} else if (trident > 0) {
				// IE 11 (or newer) => return version number
				var rvNum = ua.indexOf('rv:');
				rv = parseInt(ua.substring(rvNum + 3, ua.indexOf('.', rvNum)), 10);
			}

			return ((rv > -1) ? rv : undef);
		}());


		// disable/enable scroll (mousewheel and keys) from http://stackoverflow.com/a/4770179					
		// left: 37, up: 38, right: 39, down: 40,
		// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
		var keys = [32, 37, 38, 39, 40], wheelIter = 0;

		function preventDefault(e) {
			e = e || window.event;
			if (e.preventDefault)
			e.preventDefault();
			e.returnValue = false;  
		}

		function keydown(e) {
			for (var i = keys.length; i--;) {
				if (e.keyCode === keys[i]) {
					preventDefault(e);
					return;
				}
			}
		}

		function touchmove(e) {
			preventDefault(e);
		}

		function wheel(e) {
		}

		function disable_scroll() {
			window.onmousewheel = document.onmousewheel = wheel;
			document.onkeydown = keydown;
			//document.body.ontouchmove = touchmove;
		}

		function enable_scroll() {
			window.onmousewheel = document.onmousewheel = document.onkeydown = document.body.ontouchmove = null;  
		}

		var docElem = window.document.documentElement,
			scrollVal,
			isRevealed, 
			noscroll, 
			isAnimating,
			container = $('#wrap-outer'),
			scrollTrigger = $('#scroll-trigger');

		
		
		function scrollPage() {
			scrollVal = scrollY();
			
			if( noscroll && !ie ) {
				if( scrollVal < 0 ) return false;
				// keep it that way
				window.scrollTo( 0, 0 );
			}

			if( container.hasClass('notrans') ) {
				container.removeClass('notrans');
				return false;
			}


			if( isAnimating ) {
				return false;
			}
			
			if( scrollVal <= 0 && isRevealed ) {
				toggle(0);
			}
			else if( scrollVal > 0 && !isRevealed ){
				toggle(1);
			}
		}

		function toggle( reveal ) {
			isAnimating = true;
			
			if( reveal ) {
				container.addClass('modify');
			}
			else {
				noscroll = true;
				disable_scroll();
				container.removeClass('modify');
			}

			// simulating the end of the transition:
			setTimeout( function() {
				isRevealed = !isRevealed;
				isAnimating = false;
				if( reveal ) {
					noscroll = false;
					enable_scroll();
				}
			}, 1200 );
		}

		// refreshing the page...
		var pageScroll = 0;
		noscroll = pageScroll === 0;
		
		if( pageScroll ) {
			isRevealed = true;
			container.addClass('notrans');
			container.addClass('modify');
		}

		if($('body').hasClass('cover-push') && !Modernizr.touch) { 
			disable_scroll();
			window.addEventListener( 'scroll', scrollPage );
			scrollTrigger.click(function(){
				toggle( 'reveal' ); 
			});
		}
		
		

	});
	
	//win load
	themeData.win.load(function(){
		themeData.pageLoading.removeClass('visible');
		//themeData.pageLoading2.removeClass('mask2-hide');
		setTimeout(function(){
		///	themeData.body.addClass('body-loaded');
		},500);
		
		$("html, body").css({height: "auto"});

		// Go archor
		if(themeData.winHash){
			themeData.winHashTarget = $('a[name=\"' + themeData.winHash + '\"]');
		}else{
			themeData.winHashTarget = $('body');
		} 
		if(themeData.winHashTarget.length){
			themeData.win.find('img').imagesLoaded(function(){
				setTimeout(function(){ 
					$("html, body").animate({scrollTop:themeData.winHashTarget.offset().top}, 300);
				},30);
				 
			});
		}

		if(themeData.searchOverlay.length){
			themeData.fnSerchShow();
		}
		
		if(themeData.searchForm.length){
			themeData.fnSearchForm();
		}

		themeData.body.removeClass("preload");
		
		if(themeData.galleryCollage.length){
			themeData.win.find('img').imagesLoaded(function(){ 
				themeData.fnGalleryCollage(themeData.galleryCollage);
			});
		}
		//Call top slider  
		if(themeData.topSliderFlexslider.length){
			themeData.fnTopSlider();
			if(themeData.galleryNaviLink.length){
				themeData.fnGalleryNavi();
			}
			//themeData.galleryWrapAjaxMask.width(themeData.topSliderFlexslider.width());
		}
		
		if(themeData.galleryListMore.length&& !$('#top-slider').hasClass('disable-scroll')){
			themeData.fnGalleryListMore();
		}
		
		if(themeData.galleryNaviPrev.length){
			themeData.fnGalleryNaviPrev();
		}
		
		if(themeData.galleryNaviNext.length){
			themeData.fnGalleryNaviNext();
		}


		if(themeData.body.hasClass('navi-side-layout') && !themeData.isMobile()) {
			smartAffix('#main-navi');
		}

		//
		
		if(themeData.pageTemplateSlider.length && !Modernizr.touch && !$('#top-slider').hasClass('disable-scroll')) { 
			if(!!(window.history && history.pushState)){
				//themeData.win.scrollTop(10);
				themeData.win.mousewheel(function(event, delta){
					if(delta == 1 && galleryIsRevealed){
						if(themeData.win.scrollTop() <= 0){
							themeData.fnGalleryScrollToggle(false);
						}
					}else if(delta == -1 && !galleryIsRevealed){
						themeData.fnGalleryScrollToggle(true, galleryListMoreID, galleryListWrap[galleryListMoreID]);
					}
				});
			}
		}
		
	});
	
	
	//win resize
	themeData.win.resize(function(){
		if(themeData.galleryCollage.length){
			$('.Collage .Image_Wrapper').css("opacity", 0);
			if (resizeTimer) clearTimeout(resizeTimer);
			resizeTimer = setTimeout(themeData.fnGalleryCollage, 200);
		}
		if(themeData.body.is('.show_mobile_menu')){ 
			setTimeout(function() {themeData.body.removeClass('show_mobile_menu'); },20);
		}
	});

	window.onpageshow = function(event) {
	    if (event.persisted) {
	        window.location.reload() 
	    }
	};
	
})(jQuery);
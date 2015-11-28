/**
 * Isotope v1.5.25
 * An exquisite jQuery plugin for magical layouts
 * http://isotope.metafizzy.co
 *
 * Commercial use requires one-time purchase of a commercial license
 * http://isotope.metafizzy.co/docs/license.html
 *
 * Non-commercial use is licensed under the MIT License
 *
 * Copyright 2013 Metafizzy
 */
(function(window,$,undefined){'use strict';var document=window.document;var Modernizr=window.Modernizr;var capitalize=function(str){return str.charAt(0).toUpperCase()+str.slice(1)};var prefixes='Moz Webkit O Ms'.split(' ');var getStyleProperty=function(propName){var style=document.documentElement.style,prefixed;if(typeof style[propName]==='string'){return propName}propName=capitalize(propName);for(var i=0,len=prefixes.length;i<len;i++){prefixed=prefixes[i]+propName;if(typeof style[prefixed]==='string'){return prefixed}}};var transformProp=getStyleProperty('transform'),transitionProp=getStyleProperty('transitionProperty');var tests={csstransforms:function(){return!!transformProp},csstransforms3d:function(){var test=!!getStyleProperty('perspective');if(test){var vendorCSSPrefixes=' -o- -moz- -ms- -webkit- -khtml- '.split(' '),mediaQuery='@media ('+vendorCSSPrefixes.join('transform-3d),(')+'modernizr)',$style=$('<style>'+mediaQuery+'{#modernizr{height:3px}}</style>').appendTo('head'),$div=$('<div id="modernizr" />').appendTo('html');test=$div.height()===3;$div.remove();$style.remove()}return test},csstransitions:function(){return!!transitionProp}};var testName;if(Modernizr){for(testName in tests){if(!Modernizr.hasOwnProperty(testName)){Modernizr.addTest(testName,tests[testName])}}}else{Modernizr=window.Modernizr={_version:'1.6ish: miniModernizr for Isotope'};var classes=' ';var result;for(testName in tests){result=tests[testName]();Modernizr[testName]=result;classes+=' '+(result?'':'no-')+testName}$('html').addClass(classes)}if(Modernizr.csstransforms){var transformFnNotations=Modernizr.csstransforms3d?{translate:function(position){return'translate3d('+position[0]+'px, '+position[1]+'px, 0) '},scale:function(scale){return'scale3d('+scale+', '+scale+', 1) '}}:{translate:function(position){return'translate('+position[0]+'px, '+position[1]+'px) '},scale:function(scale){return'scale('+scale+') '}};var setIsoTransform=function(elem,name,value){var data=$.data(elem,'isoTransform')||{},newData={},fnName,transformObj={},transformValue;newData[name]=value;$.extend(data,newData);for(fnName in data){transformValue=data[fnName];transformObj[fnName]=transformFnNotations[fnName](transformValue)}var translateFn=transformObj.translate||'',scaleFn=transformObj.scale||'',valueFns=translateFn+scaleFn;$.data(elem,'isoTransform',data);elem.style[transformProp]=valueFns};$.cssNumber.scale=true;$.cssHooks.scale={set:function(elem,value){setIsoTransform(elem,'scale',value)},get:function(elem,computed){var transform=$.data(elem,'isoTransform');return transform&&transform.scale?transform.scale:1}};$.fx.step.scale=function(fx){$.cssHooks.scale.set(fx.elem,fx.now+fx.unit)};$.cssNumber.translate=true;$.cssHooks.translate={set:function(elem,value){setIsoTransform(elem,'translate',value)},get:function(elem,computed){var transform=$.data(elem,'isoTransform');return transform&&transform.translate?transform.translate:[0,0]}}}var transitionEndEvent,transitionDurProp;if(Modernizr.csstransitions){transitionEndEvent={WebkitTransitionProperty:'webkitTransitionEnd',MozTransitionProperty:'transitionend',OTransitionProperty:'oTransitionEnd otransitionend',transitionProperty:'transitionend'}[transitionProp];transitionDurProp=getStyleProperty('transitionDuration')}var $event=$.event,dispatchMethod=$.event.handle?'handle':'dispatch',resizeTimeout;$event.special.smartresize={setup:function(){$(this).bind("resize",$event.special.smartresize.handler)},teardown:function(){$(this).unbind("resize",$event.special.smartresize.handler)},handler:function(event,execAsap){var context=this,args=arguments;event.type="smartresize";if(resizeTimeout){clearTimeout(resizeTimeout)}resizeTimeout=setTimeout(function(){$event[dispatchMethod].apply(context,args)},execAsap==="execAsap"?0:100)}};$.fn.smartresize=function(fn){return fn?this.bind("smartresize",fn):this.trigger("smartresize",["execAsap"])};$.Isotope=function(options,element,callback){this.element=$(element);this._create(options);this._init(callback)};var isoContainerStyles=['width','height'];var $window=$(window);$.Isotope.settings={resizable:true,layoutMode:'masonry',containerClass:'isotope',itemClass:'isotope-item',hiddenClass:'isotope-hidden',hiddenStyle:{opacity:0,scale:0.001},visibleStyle:{opacity:1,scale:1},containerStyle:{position:'relative',overflow:'hidden'},animationEngine:'best-available',animationOptions:{queue:false,duration:800},sortBy:'original-order',sortAscending:true,resizesContainer:true,transformsEnabled:true,itemPositionDataEnabled:false};$.Isotope.prototype={_create:function(options){this.options=$.extend({},$.Isotope.settings,options);this.styleQueue=[];this.elemCount=0;var elemStyle=this.element[0].style;this.originalStyle={};var containerStyles=isoContainerStyles.slice(0);for(var prop in this.options.containerStyle){containerStyles.push(prop)}for(var i=0,len=containerStyles.length;i<len;i++){prop=containerStyles[i];this.originalStyle[prop]=elemStyle[prop]||''}this.element.css(this.options.containerStyle);this._updateAnimationEngine();this._updateUsingTransforms();var originalOrderSorter={'original-order':function($elem,instance){instance.elemCount++;return instance.elemCount},random:function(){return Math.random()}};this.options.getSortData=$.extend(this.options.getSortData,originalOrderSorter);this.reloadItems();this.offset={left:parseInt((this.element.css('padding-left')||0),10),top:parseInt((this.element.css('padding-top')||0),10)};var instance=this;setTimeout(function(){instance.element.addClass(instance.options.containerClass)},0);if(this.options.resizable){$window.bind('smartresize.isotope',function(){instance.resize()})}this.element.delegate('.'+this.options.hiddenClass,'click',function(){return false})},_getAtoms:function($elems){var selector=this.options.itemSelector,$atoms=selector?$elems.filter(selector).add($elems.find(selector)):$elems,atomStyle={position:'absolute'};$atoms=$atoms.filter(function(i,atom){return atom.nodeType===1});if(this.usingTransforms){atomStyle.left=0;atomStyle.top=0}$atoms.css(atomStyle).addClass(this.options.itemClass);this.updateSortData($atoms,true);return $atoms},_init:function(callback){this.$filteredAtoms=this._filter(this.$allAtoms);this._sort();this.reLayout(callback)},option:function(opts){if($.isPlainObject(opts)){this.options=$.extend(true,this.options,opts);var updateOptionFn;for(var optionName in opts){updateOptionFn='_update'+capitalize(optionName);if(this[updateOptionFn]){this[updateOptionFn]()}}}},_updateAnimationEngine:function(){var animationEngine=this.options.animationEngine.toLowerCase().replace(/[ _\-]/g,'');var isUsingJQueryAnimation;switch(animationEngine){case'css':case'none':isUsingJQueryAnimation=false;break;case'jquery':isUsingJQueryAnimation=true;break;default:isUsingJQueryAnimation=!Modernizr.csstransitions}this.isUsingJQueryAnimation=isUsingJQueryAnimation;this._updateUsingTransforms()},_updateTransformsEnabled:function(){this._updateUsingTransforms()},_updateUsingTransforms:function(){var usingTransforms=this.usingTransforms=this.options.transformsEnabled&&Modernizr.csstransforms&&Modernizr.csstransitions&&!this.isUsingJQueryAnimation;if(!usingTransforms){delete this.options.hiddenStyle.scale;delete this.options.visibleStyle.scale}this.getPositionStyles=usingTransforms?this._translate:this._positionAbs},_filter:function($atoms){var filter=this.options.filter===''?'*':this.options.filter;if(!filter){return $atoms}var hiddenClass=this.options.hiddenClass,hiddenSelector='.'+hiddenClass,$hiddenAtoms=$atoms.filter(hiddenSelector),$atomsToShow=$hiddenAtoms;if(filter!=='*'){$atomsToShow=$hiddenAtoms.filter(filter);var $atomsToHide=$atoms.not(hiddenSelector).not(filter).addClass(hiddenClass);this.styleQueue.push({$el:$atomsToHide,style:this.options.hiddenStyle})}this.styleQueue.push({$el:$atomsToShow,style:this.options.visibleStyle});$atomsToShow.removeClass(hiddenClass);return $atoms.filter(filter)},updateSortData:function($atoms,isIncrementingElemCount){var instance=this,getSortData=this.options.getSortData,$this,sortData;$atoms.each(function(){$this=$(this);sortData={};for(var key in getSortData){if(!isIncrementingElemCount&&key==='original-order'){sortData[key]=$.data(this,'isotope-sort-data')[key]}else{sortData[key]=getSortData[key]($this,instance)}}$.data(this,'isotope-sort-data',sortData)})},_sort:function(){var sortBy=this.options.sortBy,getSorter=this._getSorter,sortDir=this.options.sortAscending?1:-1,sortFn=function(alpha,beta){var a=getSorter(alpha,sortBy),b=getSorter(beta,sortBy);if(a===b&&sortBy!=='original-order'){a=getSorter(alpha,'original-order');b=getSorter(beta,'original-order')}return((a>b)?1:(a<b)?-1:0)*sortDir};this.$filteredAtoms.sort(sortFn)},_getSorter:function(elem,sortBy){return $.data(elem,'isotope-sort-data')[sortBy]},_translate:function(x,y){return{translate:[x,y]}},_positionAbs:function(x,y){return{left:x,top:y}},_pushPosition:function($elem,x,y){x=Math.round(x+this.offset.left);y=Math.round(y+this.offset.top);var position=this.getPositionStyles(x,y);this.styleQueue.push({$el:$elem,style:position});if(this.options.itemPositionDataEnabled){$elem.data('isotope-item-position',{x:x,y:y})}},layout:function($elems,callback){var layoutMode=this.options.layoutMode;this['_'+layoutMode+'Layout']($elems);if(this.options.resizesContainer){var containerStyle=this['_'+layoutMode+'GetContainerSize']();this.styleQueue.push({$el:this.element,style:containerStyle})}this._processStyleQueue($elems,callback);this.isLaidOut=true},_processStyleQueue:function($elems,callback){var styleFn=!this.isLaidOut?'css':(this.isUsingJQueryAnimation?'animate':'css'),animOpts=this.options.animationOptions,onLayout=this.options.onLayout,objStyleFn,processor,triggerCallbackNow,callbackFn;processor=function(i,obj){obj.$el[styleFn](obj.style,animOpts)};if(this._isInserting&&this.isUsingJQueryAnimation){processor=function(i,obj){objStyleFn=obj.$el.hasClass('no-transition')?'css':styleFn;obj.$el[objStyleFn](obj.style,animOpts)}}else if(callback||onLayout||animOpts.complete){var isCallbackTriggered=false,callbacks=[callback,onLayout,animOpts.complete],instance=this;triggerCallbackNow=true;callbackFn=function(){if(isCallbackTriggered){return}var hollaback;for(var i=0,len=callbacks.length;i<len;i++){hollaback=callbacks[i];if(typeof hollaback==='function'){hollaback.call(instance.element,$elems,instance)}}isCallbackTriggered=true};if(this.isUsingJQueryAnimation&&styleFn==='animate'){animOpts.complete=callbackFn;triggerCallbackNow=false}else if(Modernizr.csstransitions){var i=0,firstItem=this.styleQueue[0],testElem=firstItem&&firstItem.$el,styleObj;while(!testElem||!testElem.length){styleObj=this.styleQueue[i++];if(!styleObj){return}testElem=styleObj.$el}var duration=parseFloat(getComputedStyle(testElem[0])[transitionDurProp]);if(duration>0){processor=function(i,obj){obj.$el[styleFn](obj.style,animOpts).one(transitionEndEvent,callbackFn)};triggerCallbackNow=false}}}$.each(this.styleQueue,processor);if(triggerCallbackNow){callbackFn()}this.styleQueue=[]},resize:function(){if(this['_'+this.options.layoutMode+'ResizeChanged']()){this.reLayout()}},reLayout:function(callback){this['_'+this.options.layoutMode+'Reset']();this.layout(this.$filteredAtoms,callback)},addItems:function($content,callback){var $newAtoms=this._getAtoms($content);this.$allAtoms=this.$allAtoms.add($newAtoms);if(callback){callback($newAtoms)}},insert:function($content,callback){this.element.append($content);var instance=this;this.addItems($content,function($newAtoms){var $newFilteredAtoms=instance._filter($newAtoms);instance._addHideAppended($newFilteredAtoms);instance._sort();instance.reLayout();instance._revealAppended($newFilteredAtoms,callback)})},appended:function($content,callback){var instance=this;this.addItems($content,function($newAtoms){instance._addHideAppended($newAtoms);instance.layout($newAtoms);instance._revealAppended($newAtoms,callback)})},_addHideAppended:function($newAtoms){this.$filteredAtoms=this.$filteredAtoms.add($newAtoms);$newAtoms.addClass('no-transition');this._isInserting=true;this.styleQueue.push({$el:$newAtoms,style:this.options.hiddenStyle})},_revealAppended:function($newAtoms,callback){var instance=this;setTimeout(function(){$newAtoms.removeClass('no-transition');instance.styleQueue.push({$el:$newAtoms,style:instance.options.visibleStyle});instance._isInserting=false;instance._processStyleQueue($newAtoms,callback)},10)},reloadItems:function(){this.$allAtoms=this._getAtoms(this.element.children())},remove:function($content,callback){this.$allAtoms=this.$allAtoms.not($content);this.$filteredAtoms=this.$filteredAtoms.not($content);var instance=this;var removeContent=function(){$content.remove();if(callback){callback.call(instance.element)}};if($content.filter(':not(.'+this.options.hiddenClass+')').length){this.styleQueue.push({$el:$content,style:this.options.hiddenStyle});this._sort();this.reLayout(removeContent)}else{removeContent()}},shuffle:function(callback){this.updateSortData(this.$allAtoms);this.options.sortBy='random';this._sort();this.reLayout(callback)},destroy:function(){var usingTransforms=this.usingTransforms;var options=this.options;this.$allAtoms.removeClass(options.hiddenClass+' '+options.itemClass).each(function(){var style=this.style;style.position='';style.top='';style.left='';style.opacity='';if(usingTransforms){style[transformProp]=''}});var elemStyle=this.element[0].style;for(var prop in this.originalStyle){elemStyle[prop]=this.originalStyle[prop]}this.element.unbind('.isotope').undelegate('.'+options.hiddenClass,'click').removeClass(options.containerClass).removeData('isotope');$window.unbind('.isotope')},_getSegments:function(isRows){var namespace=this.options.layoutMode,measure=isRows?'rowHeight':'columnWidth',size=isRows?'height':'width',segmentsName=isRows?'rows':'cols',containerSize=this.element[size](),segments,segmentSize=this.options[namespace]&&this.options[namespace][measure]||this.$filteredAtoms['outer'+capitalize(size)](true)||containerSize;segments=Math.floor(containerSize/segmentSize);segments=Math.max(segments,1);this[namespace][segmentsName]=segments;this[namespace][measure]=segmentSize},_checkIfSegmentsChanged:function(isRows){var namespace=this.options.layoutMode,segmentsName=isRows?'rows':'cols',prevSegments=this[namespace][segmentsName];this._getSegments(isRows);return(this[namespace][segmentsName]!==prevSegments)},_masonryReset:function(){this.masonry={};this._getSegments();var i=this.masonry.cols;this.masonry.colYs=[];while(i--){this.masonry.colYs.push(0)}},_masonryLayout:function($elems){var instance=this,props=instance.masonry;$elems.each(function(){var $this=$(this),colSpan=Math.ceil($this.outerWidth(true)/props.columnWidth);colSpan=Math.min(colSpan,props.cols);if(colSpan===1){instance._masonryPlaceBrick($this,props.colYs)}else{var groupCount=props.cols+1-colSpan,groupY=[],groupColY,i;for(i=0;i<groupCount;i++){groupColY=props.colYs.slice(i,i+colSpan);groupY[i]=Math.max.apply(Math,groupColY)}instance._masonryPlaceBrick($this,groupY)}})},_masonryPlaceBrick:function($brick,setY){var minimumY=Math.min.apply(Math,setY),shortCol=0;for(var i=0,len=setY.length;i<len;i++){if(setY[i]===minimumY){shortCol=i;break}}var x=this.masonry.columnWidth*shortCol,y=minimumY;this._pushPosition($brick,x,y);var setHeight=minimumY+$brick.outerHeight(true),setSpan=this.masonry.cols+1-len;for(i=0;i<setSpan;i++){this.masonry.colYs[shortCol+i]=setHeight}},_masonryGetContainerSize:function(){var containerHeight=Math.max.apply(Math,this.masonry.colYs);return{height:containerHeight}},_masonryResizeChanged:function(){return this._checkIfSegmentsChanged()},_fitRowsReset:function(){this.fitRows={x:0,y:0,height:0}},_fitRowsLayout:function($elems){var instance=this,containerWidth=this.element.width(),props=this.fitRows;$elems.each(function(){var $this=$(this),atomW=$this.outerWidth(true),atomH=$this.outerHeight(true);if(props.x!==0&&atomW+props.x>containerWidth){props.x=0;props.y=props.height}instance._pushPosition($this,props.x,props.y);props.height=Math.max(props.y+atomH,props.height);props.x+=atomW})},_fitRowsGetContainerSize:function(){return{height:this.fitRows.height}},_fitRowsResizeChanged:function(){return true},_cellsByRowReset:function(){this.cellsByRow={index:0};this._getSegments();this._getSegments(true)},_cellsByRowLayout:function($elems){var instance=this,props=this.cellsByRow;$elems.each(function(){var $this=$(this),col=props.index%props.cols,row=Math.floor(props.index/props.cols),x=(col+0.5)*props.columnWidth-$this.outerWidth(true)/2,y=(row+0.5)*props.rowHeight-$this.outerHeight(true)/2;instance._pushPosition($this,x,y);props.index++})},_cellsByRowGetContainerSize:function(){return{height:Math.ceil(this.$filteredAtoms.length/this.cellsByRow.cols)*this.cellsByRow.rowHeight+this.offset.top}},_cellsByRowResizeChanged:function(){return this._checkIfSegmentsChanged()},_straightDownReset:function(){this.straightDown={y:0}},_straightDownLayout:function($elems){var instance=this;$elems.each(function(i){var $this=$(this);instance._pushPosition($this,0,instance.straightDown.y);instance.straightDown.y+=$this.outerHeight(true)})},_straightDownGetContainerSize:function(){return{height:this.straightDown.y}},_straightDownResizeChanged:function(){return true},_masonryHorizontalReset:function(){this.masonryHorizontal={};this._getSegments(true);var i=this.masonryHorizontal.rows;this.masonryHorizontal.rowXs=[];while(i--){this.masonryHorizontal.rowXs.push(0)}},_masonryHorizontalLayout:function($elems){var instance=this,props=instance.masonryHorizontal;$elems.each(function(){var $this=$(this),rowSpan=Math.ceil($this.outerHeight(true)/props.rowHeight);rowSpan=Math.min(rowSpan,props.rows);if(rowSpan===1){instance._masonryHorizontalPlaceBrick($this,props.rowXs)}else{var groupCount=props.rows+1-rowSpan,groupX=[],groupRowX,i;for(i=0;i<groupCount;i++){groupRowX=props.rowXs.slice(i,i+rowSpan);groupX[i]=Math.max.apply(Math,groupRowX)}instance._masonryHorizontalPlaceBrick($this,groupX)}})},_masonryHorizontalPlaceBrick:function($brick,setX){var minimumX=Math.min.apply(Math,setX),smallRow=0;for(var i=0,len=setX.length;i<len;i++){if(setX[i]===minimumX){smallRow=i;break}}var x=minimumX,y=this.masonryHorizontal.rowHeight*smallRow;this._pushPosition($brick,x,y);var setWidth=minimumX+$brick.outerWidth(true),setSpan=this.masonryHorizontal.rows+1-len;for(i=0;i<setSpan;i++){this.masonryHorizontal.rowXs[smallRow+i]=setWidth}},_masonryHorizontalGetContainerSize:function(){var containerWidth=Math.max.apply(Math,this.masonryHorizontal.rowXs);return{width:containerWidth}},_masonryHorizontalResizeChanged:function(){return this._checkIfSegmentsChanged(true)},_fitColumnsReset:function(){this.fitColumns={x:0,y:0,width:0}},_fitColumnsLayout:function($elems){var instance=this,containerHeight=this.element.height(),props=this.fitColumns;$elems.each(function(){var $this=$(this),atomW=$this.outerWidth(true),atomH=$this.outerHeight(true);if(props.y!==0&&atomH+props.y>containerHeight){props.x=props.width;props.y=0}instance._pushPosition($this,props.x,props.y);props.width=Math.max(props.x+atomW,props.width);props.y+=atomH})},_fitColumnsGetContainerSize:function(){return{width:this.fitColumns.width}},_fitColumnsResizeChanged:function(){return true},_cellsByColumnReset:function(){this.cellsByColumn={index:0};this._getSegments();this._getSegments(true)},_cellsByColumnLayout:function($elems){var instance=this,props=this.cellsByColumn;$elems.each(function(){var $this=$(this),col=Math.floor(props.index/props.rows),row=props.index%props.rows,x=(col+0.5)*props.columnWidth-$this.outerWidth(true)/2,y=(row+0.5)*props.rowHeight-$this.outerHeight(true)/2;instance._pushPosition($this,x,y);props.index++})},_cellsByColumnGetContainerSize:function(){return{width:Math.ceil(this.$filteredAtoms.length/this.cellsByColumn.rows)*this.cellsByColumn.columnWidth}},_cellsByColumnResizeChanged:function(){return this._checkIfSegmentsChanged(true)},_straightAcrossReset:function(){this.straightAcross={x:0}},_straightAcrossLayout:function($elems){var instance=this;$elems.each(function(i){var $this=$(this);instance._pushPosition($this,instance.straightAcross.x,0);instance.straightAcross.x+=$this.outerWidth(true)})},_straightAcrossGetContainerSize:function(){return{width:this.straightAcross.x}},_straightAcrossResizeChanged:function(){return true}};$.fn.getOutOfHere=function(callback){var $this=this,$images=$this.find('img').add($this.filter('img')),len=$images.length,blank='data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==',loaded=[];function triggerCallback(){callback.call($this,$images)}function imgLoaded(event){var img=event.target;if(img.src!==blank&&$.inArray(img,loaded)===-1){loaded.push(img);if(--len<=0){setTimeout(triggerCallback);$images.unbind('.imagesLoaded',imgLoaded)}}}if(!len){triggerCallback()}$images.bind('load.imagesLoaded error.imagesLoaded',imgLoaded).each(function(){var src=this.src;this.src=blank;this.src=src});return $this};var logError=function(message){if(window.console){window.console.error(message)}};$.fn.isotope=function(options,callback){if(typeof options==='string'){var args=Array.prototype.slice.call(arguments,1);this.each(function(){var instance=$.data(this,'isotope');if(!instance){logError("cannot call methods on isotope prior to initialization; attempted to call method '"+options+"'");return}if(!$.isFunction(instance[options])||options.charAt(0)==="_"){logError("no such method '"+options+"' for isotope instance");return}instance[options].apply(instance,args)})}else{this.each(function(){var instance=$.data(this,'isotope');if(instance){instance.option(options);instance._init(callback)}else{$.data(this,'isotope',new $.Isotope(options,this,callback))}})}return this}})(window,jQuery);

/* UX Isotope Grid  */
function ThemeIsotope(){
	var ux_ts = this;
	var theme_win = jQuery(window);
	
	//ts init
	this.init = function(){
		//ThemeIsotope: isotope list double width
		var _isotope_width4 = jQuery('.isotope .width4');
		if(_isotope_width4.length){
			ux_ts.isotopewidth4();
		}
		
		//ThemeIsotope: Portfolio #3D Flip Mouseover IE HACK
		var _container3d = jQuery('.container3d');
		if(_container3d.length){
			if((jQuery.browser.msie == true && parseInt(jQuery.browser.version) < 9)){
				ux_ts.flipcenterie();
				//ux_ts.flipie();
			}
		}
		
		//ThemeIsotope: Run isotope
		$allcontainer = jQuery('.container-fluid.main');
		
		//ThemeIsotope: Call isotope
		var _isotope = jQuery('.isotope');
		if(_isotope.length){
			ux_ts.callisotope();
		}
		
		//ThemeIsotope: isotope filter
		var _filters = jQuery('.filters');
		if(_filters.length){
			ux_ts.isotopefilters();
		}
		
		//win smartresize
		theme_win.smartresize(function(){
			ux_ts.refresh();
		}).resize();
		
		theme_win.load(function(){
			ux_ts.refresh();
		});
	}
	
	this.refresh = function(){
		var _isotope = jQuery('.isotope');
		if(_isotope.length){
			_isotope.each(function(index, element) {
				var _this = jQuery(this),
					image_size = jQuery(this).data('size');
				
				ux_ts.setWidths(image_size, _this);
				_this.isotope({
					masonry: {
						columnWidth: ux_ts.getUnitWidth(image_size, _this)
					}
				});
			})
		}
	}
	
	//ThemeIsotope: isotope list double width
	this.isotopewidth4 = function(){
		var _isotope_width4 = jQuery('.isotope .width4');
		_isotope_width4.each(function(index, element) {
			var width = jQuery(this).find('.fade_wrap').width();
			jQuery(this).find('img').width(width);
		});
	}
	
	//ThemeIsotope: isotope list responsive
	this.getUnitWidth = function(size, container){
		var width;
		switch(size){
			case 'medium':
				if (container.width() <= 320) {
					width = Math.floor(container.width() / 1);
				} else if (container.width() >= 321 && container.width() <= 480) {
					width = Math.floor(container.width() / 1);
				} else if (container.width() >= 481 && container.width() <= 768) {
					width = Math.floor(container.width() / 3);
				} else if (container.width() >= 769 && container.width() <= 979) {
					width = Math.floor(container.width() / 3);
				} else if (container.width() >= 980 && container.width() <= 1200) {
					width = Math.floor(container.width() / 3);
				} else if (container.width() >= 1201 && container.width() <= 1600) {
					width = Math.floor(container.width() / 6);
				} else if (container.width() >= 1601 && container.width() <= 1824) {
					width = Math.floor(container.width() / 6);
				} else if (container.width() >= 1825) {
					width = Math.floor(container.width() / 6);
				}
				
				if(container.is('.team-isotope')){
					if(container.width() <= 480){
						width = Math.floor(container.width() / 1);
					}else if(container.width() >= 481){
						width = Math.floor(container.width() / 3);
					}
				}
			break;
			
			case 'large':
				if (container.width() <= 320) {
					width = Math.floor(container.width() / 1);
				} else if (container.width() >= 321 && container.width() <= 480) {
					width = Math.floor(container.width() / 2);
				} else if (container.width() >= 481 && container.width() <= 768) {
					width = Math.floor(container.width() / 2);
				} else if (container.width() >= 769 && container.width() <= 979) {
					width = Math.floor(container.width() / 2);
				} else if (container.width() >= 980 && container.width() <= 1200) {
					width = Math.floor(container.width() / 3);
				} else if (container.width() >= 1201 && container.width() <= 1600) {
					width = Math.floor(container.width() / 3);
				} else if (container.width() >= 1601 && container.width() <= 1824) {
					width = Math.floor(container.width() / 4);
				} else if (container.width() >= 1825) {
					width = Math.floor(container.width() / 6);
				}
				
				if(container.is('.team-isotope')){
					if(container.width() <= 480){
						width = Math.floor(container.width() / 1);
					}else if(container.width() >= 481){
						width = Math.floor(container.width() / 2);
					}
				}
			break;
			
			case 'small':
				if (container.width() <= 320) {
					width = Math.floor(container.width() / 2);
				} else if (container.width() >= 321 && container.width() <= 480) {
					width = Math.floor(container.width() / 2);
				} else if (container.width() >= 481 && container.width() <= 768) {
					width = Math.floor(container.width() / 4);
				} else if (container.width() >= 769 && container.width() <= 979) {
					width = Math.floor(container.width() / 4);
				} else if (container.width() >= 980 && container.width() <= 1200) {
					width = Math.floor(container.width() / 6);
				} else if (container.width() >= 1201 && container.width() <= 1600) {
					width = Math.floor(container.width() / 6);
				} else if (container.width() >= 1601 && container.width() <= 1824) {
					width = Math.floor(container.width() / 8);
				} else if (container.width() >= 1825) {
					width = Math.floor(container.width() / 10);
				}
				if(container.is('.team-isotope')){
					if(container.width() <= 480){
						width = Math.floor(container.width() / 1);
					}else if(container.width() >= 481){
						width = Math.floor(container.width() / 4);
					}
				}
			break;
			
			case 'brick':
				if (container.width() > 1440) {
					width = Math.floor(container.width() / 7);
				} else if (container.width() > 1365) {
					width = Math.floor(container.width() / 4);
				} else if (container.width() > 1279) {
					width = Math.floor(container.width() / 4);
				} else if (container.width() > 1023) {
					width = Math.floor(container.width() / 4);
				} else if (container.width() > 767) {
					width = Math.floor(container.width() / 3);
				} else if (container.width() > 479) {
					width = Math.floor(container.width() / 2);
				} else {
					width = Math.floor(container.width() / 1);
				}
			break;
		}
		return width;
	}
	
	this.setWidths = function(size,container){
		var unitWidth = ux_ts.getUnitWidth(size,container) - 0;
		container.children(":not(.width2)").css({
			width: unitWidth
		});
		
		if (container.width() <= 480) {
			container.children(".width2").css({
				width: unitWidth * 1
			});
			container.children(".width4").css({
				width: unitWidth * 2
			});
			container.children(".width6").css({
				width: unitWidth * 2
			});
			container.children(".width8").css({
				width: unitWidth * 2
			});
			
			//brick
			container.children(".width-and-small").css({ width: unitWidth * 1, height: unitWidth * 1 });
			container.children(".width-and-big").css({ width: unitWidth * 1, height: unitWidth * 1 });
			container.children(".width-and-long").css({ width: unitWidth * 1, height: unitWidth / 2 });
			container.children(".width-and-height").css({ width: unitWidth * 1, height: unitWidth * 2 });
		}
		if (container.width() >= 481) {
			container.children(".width8").css({
				width: unitWidth * 8
			});
			container.children(".width6").css({
				width: unitWidth * 6
			});
			container.children(".width4").css({
				width: unitWidth * 4
			});
			container.children(".width2").css({
				width: unitWidth * 1
			});
			
			if(container.is('.team-isotope')){
				container.children(".width2").css({
					width: unitWidth * 1
				});
			}
			
			//brick --- thumb small
			container.children(".width-and-small").css({ width: unitWidth * 1, height: unitWidth * 1 });
			container.find(".width-and-small img").css({ width: unitWidth * 1 });
			
			//brick --- thumb big
			container.children(".width-and-big").css({ width: unitWidth * 2, height: unitWidth * 2 });
			container.find(".width-and-big img").css({ width: unitWidth * 2, });
			
			//brick --- thumb long
			container.children(".width-and-long").css({ width: unitWidth * 2, height: unitWidth * 1 });
			container.find(".width-and-long img").css({ width: unitWidth * 2 });
			
			//brick --- thumb height
			container.children(".width-and-height").css({ width: unitWidth * 1, height: unitWidth * 2 });
			container.find(".width-and-height img").css({ width: unitWidth * 1 });
			
			//brick set height
			if(size == 'brick'){
				container.children().each(function(){
					var _this = jQuery(this);
					var _this_height = jQuery(this).height();
					
					if(Math.floor(_this.find('img').height()) < Math.floor(_this_height)){
						_this.find('img').css({
							width: 'auto',
							height: _this_height
						});
					}
				});
			}
			
		} else {
			container.children(".width2").css({
				width: unitWidth
			});
		}
	}
	
	//ThemeIsotope: Call isotope
	this.callisotope = function(){
		var _isotope = jQuery('.isotope');
		
		_isotope.each(function(index, element) {
			var _this = jQuery(this);
			var image_size = _this.data('size');
			
			
			if(image_size != 'brick'){
				ux_ts.setWidths(image_size, _this);
			}
				
			_this.imagesLoaded(function(){
				if(_this.is('.masonry')){
					_this.isotope({
						animationEngine : 'css',
						//resizable: false,
						masonry: {
							columnWidth: ux_ts.getUnitWidth(image_size, _this)
						}
					});
				}else if(_this.is('.grid_list')){
					_this.isotope({
						layoutMode : 'fitRows',
						animationEngine : 'css',
						//resizable: false,
						masonry: {
							columnWidth: ux_ts.getUnitWidth(image_size, _this)
						}
					});
				}
			});
			
			_this.addClass('isotope_fade');
			_this.siblings('#isotope-load').fadeOut(300);
		});
	}
	
	//ThemeIsotope: isotope filter
	this.isotopefilters = function(){
		var _filters = jQuery('.filters');
		_filters.delegate('a', 'click', function() {
			$container = jQuery(this).parent().parent().parent().next().find('.isotope');
			jQuery(this).parent().parent().find('li').removeClass('active');
			jQuery(this).parent().addClass('active');
			var selector = jQuery(this).attr('data-filter');
			$container.isotope({
				filter: selector
			});
			return false;
		});

		if( _filters.find('.filter-floating-triggle').length ){

			_filters.find('ul').contents().filter(function() {
				return this.nodeType === 3;
			}).remove();

		}
	}
	
	//ThemeIsotope: Portfolio #3D Flip Mouseover IE HACK
	/*this.flipie = function(){
		var _card = jQuery('.card');
		var _container3d = jQuery('.container3d');
		_card.live("mouseenter", function(e){
			e.preventDefault();
			jQuery(this).find('.front').stop().animate({"opacity": 0}, 300);
			jQuery(this).find('.back').stop().animate({"opacity": 1}, 300).css( { 'z-index' : 100,'display':'block'});	
		});  
	
		_container3d.live("mouseleave", function(e){
			e.preventDefault();
			var $this = jQuery(this);
				$this.find('.back').stop().css( { 'opacity' : 0, 'z-index' : 0});
				$this.find('.front').stop().animate({"opacity": 1}, 300);
		});
	
		jQuery('div.container3d .card .face.back').css( { 'display' : 'none'});
	}	*/
	//Flip centered IE8 hack
	this.flipcenterie = function(){
		var _flipback = jQuery('.flip_wrap_back_con');
		_flipback.each(function(){
			var 
			flipTitHeight  = jQuery(this).find('h2').height(),
			flipMarginTop  = -((flipTitHeight + 60 )/2);
			
			jQuery(this).css({'margin-top':+flipMarginTop,'left':'0' });
		});
	}
}

//
// Call pagebuild js
//

(function($){

    "use strict";
	
	var themePB = [];
	
	//window
	themePB.win                   = $(window);
	themePB.winHeight             = themePB.win.height();
	themePB.winScrollTop          = themePB.win.scrollTop();
	themePB.winHash               = window.location.hash.replace('#', '');
	
	//document
	themePB.doc                   = $(document);
	
	//ID A~Z
	themePB.content               = $('#content');
	themePB.jplayer               = $('#jquery_jplayer');
	themePB.wrap                  = $('#wrap');
	
	//tag
	themePB.html                  = $('html');
	themePB.body                  = $('body');
	
	//tag class
	
	//class
	themePB.moduleAjaxWrap        = $('.portfolio-ajaxwrap');
	themePB.moduleAjaxWrapLoading = $('.portfolio-ajaxwrap-loading');
	themePB.moduleAjaxWrapInn     = $('.portfolio-ajaxwrap-inn');
	themePB.moduleAjaxWrapClose   = $('.portfolio-ajaxwrap-close');
	
	themePB.module                = $('.moudle');
	themePB.moduleFullwidthWrap   = $('.fullwidth-wrap');
	themePB.moduleFullwidthTabs   = $('.fullwrap-with-tab-nav');
	themePB.moduleParallax        = $('.parallax');
	themePB.modulePage            = false;
	themePB.modulePaged           = 1;
	themePB.moduleAjaxPermalink   = themePB.module.find('.ajax-permalink');
	themePB.moduleAccordion       = themePB.module.find('.accordion-ux');
	themePB.moduleBlog            = themePB.module.find('.blog-wrap');
	themePB.moduleContactForm     = themePB.module.find('.contact_form');
	themePB.moduleCountdown       = themePB.module.find('.countdown');
	themePB.moduleClientsWrap     = themePB.module.find('.clients_wrap');
	themePB.moduleFlexSliderWrap  = themePB.module.find('.flex-slider-wrap');
	themePB.moduleGoogleMap       = themePB.module.find('.module-map-canvas');
	themePB.moduleIconbox         = themePB.module.find('.iconbox-plus');
	themePB.moduleImagebox        = themePB.module.find('.image-box-svg-wrap');
	themePB.moduleImageShadow     = themePB.module.find('.shadow');
	themePB.moduleLiquidlist      = themePB.module.find('.isotope-liquid-list');
	themePB.moduleLiquidImage     = themePB.module.find('.liquid_list_image');
	themePB.moduleListItemSlider  = themePB.module.find('.listitem_slider');
	themePB.moduleMessageBox      = themePB.module.find('.message-box');
	themePB.moduleMouseoverMask   = themePB.module.find('.mask-hover');
	themePB.moduleTabs            = themePB.module.find('.nav-tabs');
	themePB.modulePostCarousel    = themePB.module.find('.post-carousel-wrap');
	themePB.modulePromoteCenter   = themePB.module.find('.promote-wrap-2c');
	themePB.modulePromoteButton   = themePB.module.find('.promote-button-wrap');
	themePB.modulePagenumsTwitter = themePB.module.find('.pagenums.page_twitter a');
	themePB.modulePagenumsSelect  = themePB.module.find('.pagenums .select_pagination');
	themePB.moduleSeparator       = themePB.module.find('.separator');
	themePB.moduleTabsV           = themePB.module.find('.tabs-v');
	
	themePB.moduleHasAnimation    = $('.moudle_has_animation');
	
	themePB.videoFace             = $('.video-face');
	themePB.videoOverlay          = $('.video-overlay');
	
	//items
	themePB.itemIconboxs          = [];
	themePB.itemSeparator         = [];
	themePB.itemClients           = [];
	themePB.itemPostCarousel      = [];
	themePB.itemParallax          = [];
	themePB.itemParallax          = [];
	themePB.itemListItemSlider    = [];
	
	
	//define
	themePB.themeIsotope          = new ThemeIsotope;
	themePB.themeIsotope.init();
	
	//condition
	themePB.isMobile = function(){
		if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || themePB.win.width() < 769){
			return true; 
		}else{
			return false;
		}
	}
	
	//hash
	if(themePB.winHash){
		themePB.winHash = themePB.winHash.split("/");
		
		if(themePB.winHash[1]){
			themePB.modulePage = themePB.winHash[1];
		}
		
		if(themePB.winHash[2]){
			if(themePB.winHash[2] != '1'){
				themePB.modulePaged = themePB.winHash[2];
			}
		}
		
		if(themePB.winHash[0]){
			themePB.winHash = themePB.winHash[0];
		}
	}
	
	//function
	//Pagebuild: Tab-v responsive
	themePB.fnTabResponsive = function(){
		themePB.moduleTabsV.each(function(){
			
			var tab = $(this),
				tabNav = tab.find('.nav-tabs-v'),
				tabContent = tab.find('.nav-tabs-v');
				
			// if(tab.width() < 561){
			// 	tabNav.css('width', '45%');
			// 	tabContent.css('width', '55%');
			// }
			// else{
			// 	tabNav.css('width', '25%');
			// 	tabContent.css('width', '75%');
			// }
		});
	}
	
	//Captcha
	themePB.fnCaptcha = function(formVerifyWrap){
		formVerifyWrap.find('img').click(function(){
			$.post(AJAX_M, {
				'mode': 'captcha',
				'data': ''
			}).done(function(content){
				formVerifyWrap.html(content);
				themePB.fnCaptcha(formVerifyWrap);
			});
		});
	}
	
	//Contact Form Verification and Ajax Send
	themePB.fnContactForm = function(){
		themePB.moduleContactForm.each(function(){
			
			var form = $(this),
				formMessage = form.find('input[type="hidden"].info-tip').data('message'),
				formSending = form.find('input[type="hidden"].info-tip').data('sending'),
				formErrorTip = form.find('input[type="hidden"].info-tip').data('error'),
				formVerifyWrap = form.find('.verify-wrap');
				
				themePB.fnCaptcha(formVerifyWrap);
				
				form.submit(function() {
					var hasError = false;
					
					form.find('.requiredField').each(function(){
						if($.trim($(this).val()) == '' || $.trim($(this).val()) == 'Name*' || $.trim($(this).val()) == 'Email*' || $.trim($(this).val()) == 'Required' || $.trim($(this).val()) == 'Invalid email'){
						
							$(this).attr("value", "Required");
							hasError = true;
							
						}else if($(this).hasClass('email')){
							var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
							
							if(!emailReg.test($.trim($(this).val()))){
								$(this).attr("value", "Invalid email");
								hasError = true;
							}
						
						}else if($(this).hasClass('captcha')){
							var captchaReg = $(this).prev('[name=ux_captcha_word]');
							
							if($(this).val().toUpperCase() != captchaReg.val()){
								$(this).attr("value","Error Captcha");
								hasError = true;
							}
						}

					});

					//After verification, print some infos. 
					if(!hasError){	
						if(form.hasClass('single-feild')){
							form.find('#idi_send').val(formSending).attr('disabled','disabled');
						}else{	
							form.find('#idi_send').fadeOut('normal', function(){
								form.parent().append('<p class="sending">' + formSending + '</p>');
							});
						}
						var formInput = form.serialize();
						
						$.post(form.attr('action'),formInput, function(data){		
							form.slideUp("fast", function() {
								if(form.hasClass('single-feild')){
									form.before('<p class="success" style=" text-align:center">' + formMessage + '</p>');
								}else{
									form.before('<p class="success">' + formMessage + '</p>');
									form.find('.sending').fadeOut();
								}
							});
						});
					}
					
					return false;
				});
				
		});//End each
	}
	
	//Pagebuild: Promote centered
	themePB.fnPromoteCentered = function(){
		themePB.modulePromoteCenter.each(function(){	
			var promote = [];
			
			promote.item = $(this);
			promote.itemWidth = promote.item.width();
			promote.button = promote.item.find('.promote-button-wrap');
			promote.buttonWidth = promote.button.width();
		
			if(promote.itemWidth < 300){
				promote.item.removeClass('promote-wrap-2c');
				promote.item.find('.promote-text').css('margin-right','0');
			}else{
				promote.item.addClass('promote-wrap-2c');
				promote.item.find('.promote-text').css('margin-right',promote.buttonWidth);
			}
		});
	}
	
	//Pagebuild: Client Moudle
	themePB.fnClients = function(){
		$.each(themePB.itemClients, function(index, clients){
			clients.firstChildImg.imagesLoaded(function(){
				clients.lists.carouFredSel({
					responsive : true,
					width      : '100%',
					items      : clients.column,
					scroll     : clients.column,
					prev       : function() { return clients.prev},
					next       : function() { return clients.next},
					auto       : false
				});
				
				clients.images.imagesLoaded(function(){
					clients.imagesHeight = clients.images.height();
					clients.listItem.css('height',clients.imagesHeight);
					clients.lists.css('height',clients.imagesHeight);
					clients.caroufredsel.css('height',clients.imagesHeight);
					clients.item.css('height',clients.imagesHeight);
				});
				
				clients.carouselBtn.delegate('a', 'hover', function(){
					if(clients.listItem.is('.animation-scroll-ux')){
						clients.listItem.attr('class', 'client-li');
					}
				});
			});
			
			if(clients.column >= clients.listItem.length){
				clients.carouselBtn.hide();
			}else{
				clients.carouselBtn.show();
			}
		});
	}
	
	//Pagebuild: GoogleMap initialize
	themePB.fnMapInit = function(gm){
		var geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng(gm.l, gm.r);
		var dismouse = gm.dismouse == 't' ? true : false;
		var markers = [];
		var map_type;
		//var draggable_touch = themePB.isMobile == true ? 'false' : 'true';
		switch(gm.view){
			case 'map': map_type = google.maps.MapTypeId.ROADMAP; break;
			case 'satellite': map_type = google.maps.MapTypeId.SATELLITE; break;
			case 'map_terrain': map_type = google.maps.MapTypeId.TERRAIN; break;
		}
		if(themePB.isMobile()) {
			var mapOptions = {
				zoom: gm.zoom,
				center: latlng,
				mapTypeId: map_type,
				scrollwheel: dismouse,
				draggable: false,
				mapTypeControlOptions: {
					mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
				}
			}
		} else {
			var mapOptions = {
				zoom: gm.zoom,
				center: latlng,
				mapTypeId: map_type,
				scrollwheel: dismouse,
				draggable: true,
				mapTypeControlOptions: {
					mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
				}
			}

		}
		var google_map = new google.maps.Map(gm.element, mapOptions);
		
		if(gm.pin == 't'){
			if(gm.pin_custom != ''){
				var image = {
					url: gm.pin_custom
				};
				
				var marker = new google.maps.Marker({
					position: latlng,
					map: google_map,
					icon: image
				});
			}else{
				var marker = new google.maps.Marker({
					position: latlng,
					map: google_map
				});
			}
				
			//marker.setAnimation(google.maps.Animation.BOUNCE);
		}
		
		if(gm.style == 't' && eval(gm.style_code)){
			var styledMap = new google.maps.StyledMapType(eval(gm.style_code), {name: "Styled Map"});
			 
			google_map.mapTypes.set('map_style', styledMap);
			google_map.setMapTypeId('map_style');
		}
	}
	
	//Pagebuild: Post Carousel Moudle
	themePB.fnPostCarousel = function(){
		themePB.modulePostCarousel.each(function(){
			var postCarousel = [];
			
			postCarousel.item = $(this);
			postCarousel.itemWidth = postCarousel.item.width();
			postCarousel.pagination = postCarousel.item.find('.post-carousel-pagination');
			postCarousel.section = postCarousel.item.find('section');
			postCarousel.carousel = postCarousel.item.find('.post-carousel');
			postCarousel.prev = postCarousel.item.find('.prev');
			postCarousel.next = postCarousel.item.find('.next');
			postCarousel.caroufredsel = postCarousel.item.find('.caroufredsel');
			postCarousel.column = 1;
			
			if(postCarousel.itemWidth > 1500){
				postCarousel.column = 6;
			}else if(postCarousel.itemWidth > 1100 && postCarousel.itemWidth <= 1500){
				postCarousel.column = 5;	
			}else if(postCarousel.itemWidth > 768 && postCarousel.itemWidth <= 1100){
				postCarousel.column = 4;	
			}else if(postCarousel.itemWidth > 300 && postCarousel.itemWidth <= 768){
				postCarousel.column = 2;
			}else if(postCarousel.itemWidth <= 300){
				postCarousel.column = 1; 
			}
			
			if(postCarousel.column >= postCarousel.section.length){
				postCarousel.pagination.hide();
			}else{
				postCarousel.pagination.show();
			}
			
			postCarousel.carousel.carouFredSel({
				responsive : true,
				width      : '100%',
				items      : postCarousel.column,
				scroll     : postCarousel.column,
				swipe      : {
						onTouch : true, 
						onMouse : true 
				},
				pagination : function() { return postCarousel.pagination},
				prev       : function() { return postCarousel.prev},
				next       : function() { return postCarousel.next},
				auto       : false
			
			});
			
			var _getmax = new Array();
			//postCarousel.item.find('img').imagesLoaded(function(){
			postCarousel.section.each(function(index, element){
				//setTimeout(function(){ 
					_getmax.push($(this).height());
				//},500);	
			});
			//});
			var ulHeight = 0;
			
			

			if(postCarousel.item.find('.portfolio-caroufredsel-item-inn').length){
				ulHeight = eval("Math.max("+_getmax.toString()+")") - 33;
			}else{
				ulHeight = eval("Math.max("+_getmax.toString()+")") + 40;
			}

			postCarousel.section.css('height',ulHeight);
			postCarousel.caroufredsel.css('height',ulHeight);
			postCarousel.item.css('height',ulHeight);
			postCarousel.carousel.animate({'opacity':1 },300);
			
			
		});
	}
	
	//Pagebuild: Fullwrap Parallax
	themePB.fnSetTranslate3DTransform = function(el, xPosition, yPosition){
		var value = "translate3d(" + xPosition + "px" + ", " + yPosition + "px" + ", 0)";
		el.css({
			'transform': value,
			'msTransform': value,
			'webkitTransform': value,
			'mozTransform': value,
			'oTransform': value,
		});
	}
	
	//Pagebuild: Call Carousel Slider, Content slider responsive
	themePB.fnContentslider = function(){
		$.each(themePB.itemListItemSlider, function(index, slider){
			
			slider.itemWidth = slider.item.width();
			slider.imageHeight = slider.itemWidth * 0.57;
			slider.titleHeight = slider.title.height();
			slider.descriptionHeight = slider.description.height();
			slider.panelHeight = slider.titleHeight + slider.descriptionHeight;
			
			if(slider.itemWidth < 561){
				
				slider.itemItem.css({'height':'auto'});
				slider.carouselImage.css({'height':slider.imageHeight,'width':'100%','float':'none'});
				slider.panel.css({'width':'100%','float':'none','height':'400px'});
				slider.image.css({'width':'100%','height':'auto'});
				slider.carouselIndicators.css({'width':'100%'});
				slider.titleH2.css({'font-size':'18px','line-height':'20px'});
				
			}else if(slider.itemWidth > 562 &&  slider.itemWidth < 725){
				
				slider.itemItem.css({'height':'400px'});
				slider.carouselImage.css({'height':'400px','width':'60%','float':'left'});
				slider.panel.css({'width':'40%','float':'left','height':'400px'});
				slider.image.css({'width':'auto','height':'100%'});
				slider.carouselIndicators.css({'width':'40%'});
				slider.titleH2.css({'font-size':'18px','line-height':'20px'});
				
			}else{
				
				slider.itemItem.css({'height':'400px'});
				slider.carouselImage.css({'height':'400px','width':'60%','float':'left'});
				slider.panel.css({'width':'40%','float':'left','height':'400px'});
				slider.image.css({'width':'100%','height':'auto'});
				slider.carouselIndicators.css({'width':'40%'});
				slider.titleH2.css({'font-size':'30px','line-height':'40px'});
				
			}
		});
	}
	
	//Pagebuild: Flex Slider
	themePB.fnFlexslider = function(){
		themePB.moduleFlexSliderWrap.each(function(){
			var flexslider = [];
			
			flexslider.item = $(this);
			flexslider.direction = flexslider.item.data('direction');
			flexslider.control = flexslider.item.data('control');
			flexslider.speed = flexslider.item.data('speed');
			flexslider.animation = flexslider.item.data('animation');
			flexslider.children = flexslider.item.find('.flexslider');
			
			flexslider.children.flexslider({
				animation: ''+flexslider.animation+'', //String: Select your animation type, "fade" or "slide"
				animationLoop: true,
				slideshow: true, 
				smoothHeight: true,  
				controlNav: flexslider.control, //Dot Nav
				directionNav: flexslider.direction,  // Next\Prev Nav
				touch: true, 
				slideshowSpeed: flexslider.speed * 1000 
				//itemWidth: 210,
				//itemMargin: 5
			});
		});
	}
	
	//Pagebuild: Module Load Ajax
	themePB.fnModuleLoad = function(data, container){
		$.post(AJAX_M, {
			'mode': 'module',
			'data': data
		}).done(function(content){
			if(container.is('.container-isotope')){
				var newElems = $(content).css({ opacity: 0 }),
				    oldElems = container.find('.isotope-item');

				switch(data['mode']){
					case 'pagenums': 
						var this_pagenums = $('.pagination a[data-post='+data["module_post"]+'][data-paged='+data["paged"]+']');
						this_pagenums.text(data["paged"]);
						container.find('.isotope').isotope( 'remove', oldElems );
						$('html,body').animate({
							scrollTop: container.offset().top - 80
						},
						1000); 
					break;
					case 'twitter': 
						var this_twitter = $('.page_twitter a[data-post='+data["module_post"]+']');
						this_twitter.attr('data-paged',Number(data['paged']) + 1).text('...');
						if(data['paged'] == this_twitter.data('count')){
							this_twitter.fadeOut(300);
							this_twitter.parent('.page_twitter').css('margin-top','0');
						}
						container.append(newElems);
						this_twitter.find('div').remove();
					break;
				}
				newElems.imagesLoaded(function(){
					container.find('.isotope').isotope('insert', newElems);
					var image_size = container.find('.isotope').data('size');
					themePB.themeIsotope.setWidths(image_size, container.find('.isotope'));

					//3Dflip hover center IE8 hack
					if( $('.container3d').length > 0 ) {
						if( ($.browser.msie == true && parseInt($.browser.version) < 9)){
							themePB.themeIsotope.flipcenterie();
						}
					}
					
					container.find('.isotope').isotope({
						masonry: {
							columnWidth: themePB.themeIsotope.getUnitWidth(image_size, container.find('.isotope'))
						}
					});
					themePB.fnLiquidlist();
					if(newElems.find('.liquid_list_image').length){
						newElems.find('.liquid_list_image').each(function(){
                            themePB.fnLiquidClick($(this));
                        });
					}
					themePB.audioPlayClick(newElems);
					themePB.fnAnimationScroll(newElems);
					
					fnInitPhotoSwipeFromDOM('.lightbox-photoswipe');
					
					/*var animationItem = [];
						
					animationItem.item = $(this);
					animationItem.classB = animationItem.item.data('animationend');
					
					animation.item.css({'opacity': 1});
					animationItem.item.css('transform', null);
					setInterval(function(){
						animationItem.item.css({'opacity': 1});
						animationItem.item.addClass(animationItem.classB);
					}, index * 50);*/
					
				});
				
				if(data["module_id"] != 'portfolio'){
					themePB.fnJplayerCall();
					themePB.jplayer.jPlayer("stop");
				}
				themePB.audioPlayClick(newElems);
				themePB.audioPauseClick(newElems);
				themePB.fnVideoFace(newElems);
				
				if(newElems.find('.songtitle').length){
					newElems.find('.songtitle').tooltip({
						track: true
					});
				}
			}else{
				var newElems = $(content); 
				switch(data['mode']){
					case 'pagenums': 
						var this_pagenums = $('.pagination a[data-post='+data["module_post"]+'][data-paged='+data["paged"]+']');
						this_pagenums.text(data["paged"]);
						$('html,body').animate({
							scrollTop: container.offset().top - 80
						},
						1000); 

						container.html(content);
					break;
					case 'twitter': 
						var this_twitter = $('.page_twitter a[data-post='+data["module_post"]+']');
						this_twitter.attr('data-paged',Number(data['paged']) + 1).text('...').removeClass('tw-style-loading');
						if(data['paged'] == this_twitter.data('count')){
							this_twitter.fadeOut(300);
							this_twitter.parent('.page_twitter').css('margin-top','0');
						}

						container.append(newElems);
						this_twitter.find('div').remove();
					break;
				}

				//Fadein theitems of next page 
				newElems.animate({opacity:1}, 1000); 

				//Audio player
				if(data["module_id"] != 'portfolio'){
					themePB.fnJplayerCall();
					themePB.jplayer.jPlayer("stop");
				}
				themePB.audioPlayClick(newElems);
				themePB.audioPauseClick(newElems);
				themePB.fnAnimationScroll(newElems);
				
				if(container.find('.video-face').length){
					themePB.fnVideoFace(container.find('.video-face'));
				}
				
				fnInitPhotoSwipeFromDOM('.lightbox-photoswipe');
			} 
			

		});
	}
	
	//audio player function
	themePB.fnJplayerCall = function(){
		if(themePB.jplayer.length){
			themePB.jplayer.jPlayer({
				ready: function(){
					$(this).jPlayer("setMedia", {
						mp3:""
					});
				},
				swfPath: JS_PATH,
				supplied: "mp3",
				wmode: "window"
			});
		}
	}
	
	//call player play
	themePB.audioPlayClick = function(container){
		container.find('.pause').click(function(){
			var thisID = $(this).attr("id");
			container.find('.audiobutton').removeClass('play').addClass('pause');
			$(this).removeClass('pause').addClass('play');
			themePB.jplayer.jPlayer("setMedia", {
				mp3: $(this).attr("rel")
			});
			themePB.jplayer.jPlayer("play");
			themePB.jplayer.bind($.jPlayer.event.ended, function(event) {
				$('#'+thisID).removeClass('play').addClass('pause');
			});
			themePB.audioPauseClick(container);
			themePB.audioPlayClick(container);
		})
	}
	
	//call player pause
	themePB.audioPauseClick = function(container){
		container.find('.play').click(function(){
			$(this).removeClass('play').addClass('pause');
			themePB.jplayer.jPlayer("stop");
			themePB.audioPlayClick(container);
		})
	}
	
	//call ligntbox
	themePB.fnLightbox = function(){
		themePB.lightbox = $('.lightbox');
		themePB.lightboxParent = $('.lightbox-parent');
		
		if(themePB.lightbox.length){
			themePB.lightbox.magnificPopup({
				type:'image',
				removalDelay: 500,
				mainClass: 'mfp-with-zoom mfp-img-mobile'
			});
		}
		
		if(themePB.lightboxParent.length){
			themePB.lightboxParent.each(function(){
				$(this).magnificPopup({
					delegate: 'a.lightbox-item',
					type: 'image',
					preload: [1,3],
					removalDelay: 300,
					mainClass: 'mfp-fade mfp-img-mobile',
					gallery: { enabled: true }
				});
			});
		}
	}
	
	//Pagebuild: Liquid List
	themePB.fnLiquidlist = function(){
		themePB.moduleLiquidlist.each(function(){
			var liquid = [];
			
			liquid.item = $(this);
			liquid.isotopeItem = liquid.item.find('.isotope-item');
			
			liquid.isotopeItem.each(function(index) {
				$(this).attr('data-num', index + 1);
			});
			
		});
	}
	
	//Pagebuild: Liquid Click
	themePB.fnLiquidClick = function(liquid){
		liquid.click(function(){
			themePB.jplayer.jPlayer("stop");
			
			var liquid_handler = $('.liquid_handler');
			if(liquid_handler.length == 0){
				liquid.addClass('liquid_handler');
				if(liquid.is('.flip_wrap_back')){
					themePB.fnLiquidAjax(liquid.find('a.liquid_list_image'));
				}else{
					themePB.fnLiquidAjax(liquid);
				}
			}
			return false;
		});
	}
	
	//Pagebuild: Liquid Remove
	themePB.fnLiquidRemove = function(isotope, mode){
		var liquid = [];
		
		liquid.parents = isotope.parents('.isotope-liquid-list');
		liquid.width = liquid.parents.attr('data-width');
		liquid.size = liquid.parents.attr('data-size');
		liquid.space = liquid.parents.attr('data-space');
		liquid.isotopeNum = isotope.attr('data-num');
		liquid.isotopeItem = liquid.parents.find('.isotope-item');
		
		liquid.isotopeItem.each(function(index, element) {
            var isotopeItem = [];
			
			isotopeItem.item = $(this);
			isotopeItem.num = isotopeItem.item.attr('data-num');
			isotopeItem.liquidInside = isotopeItem.item.find('.liquid_inside');
			isotopeItem.liquidExpand = isotopeItem.item.find('.liquid-expand-wrap');
			
			switch(mode){
				case 'this' :
					if(liquid.isotopeNum == isotopeItem.num){
						$(this).removeClass(liquid.width).addClass('width2');
						
						isotopeItem.liquidExpand.fadeOut(100, function(){
							isotopeItem.liquidInside.fadeIn(300).css('overflow','visible');
							isotopeItem.liquidExpand.remove();
							themePB.themeIsotope.setWidths(liquid.size, liquid.parents);
							if(liquid.isotopeNum > 1){
								liquid.arget = liquid.isotopeNum - 1;
								liquid.parents.find('.isotope-item[data-num='+liquid.arget+']').after(isotope);
							}else if(liquid.isotopeNum == 1){
								liquid.arget = liquid.isotopeNum + 1;
								liquid.parents.find('.isotope-item[data-num='+liquid.arget+']').before(isotope);
							}
							liquid.parents.isotope('appended', isotope);
							liquid.parents.isotope('reLayout');
							
							if($.browser.msie == true && parseInt($.browser.version) < 9){}else{
								setTimeout(function(){
									var _html_top = $('html').css('margin-top');
									liquid.space = liquid.space.replace('px','');
									_html_top = _html_top.replace('px','');
									if($.browser.msie == true && parseInt($.browser.version) < 9){
										if(_html_top == 'auto'){
											_html_top = 0;
										}
									}
									var _offset_top = isotopeItem.item.offset().top;
									$('html,body').animate({
										scrollTop: _offset_top - liquid.space - _html_top
									}, 500);
								}, 1000);
							}
						});
					}
				break;
				
				case 'other':
					if(liquid.isotopeNum != isotopeItem.num){
						if(isotopeItem.liquidExpand.length > 0){
							isotopeItem.item.removeClass(liquid.width).addClass('width2');
							isotopeItem.liquidExpand.fadeOut(100, function(){
								isotopeItem.liquidInside.fadeIn(300).css('overflow','visible');
								isotopeItem.liquidExpand.remove();
								if(isotopeItem.num > 1){
									liquid.arget = isotopeItem.num - 1;
									liquid.parents.find('.isotope-item[data-num='+liquid.arget+']').after(isotopeItem.item);
								}else if(isotopeItem.num == 1){
									liquid.arget = isotopeItem.num + 1;
									liquid.parents.find('.isotope-item[data-num='+liquid.arget+']').before(isotopeItem.item);
								}
								liquid.parents.isotope('appended', isotopeItem.item);
								liquid.parents.isotope('reLayout');
							});
						}
					}
				break;
			}
        });
	}
	
	//Pagebuild: Liquid Column
	themePB.fnLiquidcolumn = function(isotope){
		var liquid = [];
		
		liquid.target = false;
		liquid.parents = isotope.parents('.isotope-liquid-list');
		liquid.isotopeItem = liquid.parents.find('isotope-item');
		liquid.isotopeNum = isotope.data('num');
		liquid.size = liquid.parents.data('size');
		liquid.width = liquid.parents.data('width');
		liquid.column = liquid.parents.width() / themePB.themeIsotope.getUnitWidth(liquid.size, liquid.parents) / 2,
		liquid.column = parseInt(liquid.column);
		liquid.baseNum = liquid.isotopeNum%liquid.column;
		
		switch(liquid.column){
			case 5:
				if(liquid.size == 'small' && liquid.width == 'width8'){
					if(liquid.baseNum%3 == 0){
						liquid.target = liquid.isotopeNum + 2;
					}
					if(liquid.baseNum%4 == 0){
						liquid.target = liquid.isotopeNum + 1;
					}
				}
			break;
			
			case 4:
				if((liquid.size == 'small' && liquid.width == 'width8') || (liquid.size == 'medium' && liquid.width == 'width8')){
					if(liquid.baseNum%2 == 0){
						liquid.target = liquid.isotopeNum + 3;
					}
					if(liquid.baseNum%3 == 0){
						liquid.target = liquid.isotopeNum + 2;
					}
					if(liquid.baseNum%4 == 0){
						liquid.target = liquid.isotopeNum + 1;
					}
				}
				if((liquid.size == 'small' && liquid.width == 'width6') || (liquid.size == 'medium' && liquid.width == 'width6')){
					if(liquid.baseNum%3 == 0){
						liquid.target = liquid.isotopeNum + 2;
					}
				}
			break;
			
			case 3:
				if((liquid.size == 'small' && liquid.width == 'width8') || (liquid.size == 'small' && liquid.width == 'width6') || (liquid.size == 'medium' && liquid.width == 'width8') || (liquid.size == 'medium' && liquid.width == 'width6') || (liquid.size == 'large' && liquid.width == 'width6')){
					if(liquid.baseNum%2 == 0){
						liquid.target = liquid.isotopeNum + 2;
					}
					if(liquid.baseNum%3 == 0){
						liquid.target = liquid.isotopeNum + 1;
					}
				}
				if((liquid.size == 'small' && liquid.width == 'width8') || liquid.size == 'medium' && liquid.width == 'width8'){
					isotope.removeClass('width8');
					isotope.addClass('width6');
				}
			break;
			
			case 2:
				if((liquid.size == 'medium' && liquid.width == 'width8') || (liquid.size == 'medium' && liquid.width == 'width6') || (liquid.size == 'medium' && liquid.width == 'width4') || (liquid.size == 'large' && liquid.width == 'width6') || (liquid.size == 'large' && liquid.width == 'width4')){
					if(liquid.baseNum%2 == 0){
						liquid.target = liquid.isotopeNum + 1;
					}
				}
				if(liquid.size == 'medium' && liquid.width == 'width8'){
					isotope.removeClass('width8');
					isotope.addClass('width4');
				}
				if(liquid.size == 'medium' && liquid.width == 'width6'){
					isotope.removeClass('width6');
					isotope.addClass('width4');
				}
				
				if(liquid.size == 'large' && liquid.width == 'width6'){
					isotope.removeClass('width6');
					isotope.addClass('width2');
				}
			break;
		}
		
		return liquid.target;
	}
	
	//Pagebuild: Liquid Ajax
	themePB.fnLiquidAjax = function(el){
		var liquid = [];
		
		liquid.item = el;
		liquid.itemIsotopeItem = liquid.item.parents('.isotope-item');
		liquid.itemLiquidInside = liquid.item.parents('.liquid_inside');
		liquid.itemLiquidInsideHeight = liquid.itemLiquidInside.height();
		liquid.itemLiquidItem = liquid.itemLiquidInside.parents('.liquid-item');
		liquid.itemLiquidLoading = liquid.itemLiquidInside.next('.liquid-loading-wrap');
		liquid.itemLiquidHide = liquid.itemLiquidLoading.find('.liquid-hide');
		
		liquid.parents = liquid.item.parents('.isotope-liquid-list');
		
		liquid.isotopeItem = liquid.parents.find('.isotope-item');
		liquid.isotopeLength = liquid.isotopeItem.length;
		
		liquid.postID = liquid.item.attr('data-postid');
		liquid.type = liquid.item.attr('data-type');
		
		liquid.words = liquid.parents.attr('data-words');
		liquid.social = liquid.parents.attr('data-social');
		liquid.ratio = liquid.parents.attr('data-ratio');
		liquid.width = liquid.parents.attr('data-width');
		liquid.space = liquid.parents.attr('data-space');
		liquid.size = liquid.parents.attr('data-size');
		
		liquid.target = themePB.fnLiquidcolumn(liquid.itemIsotopeItem);
		
		if(liquid.type == 'magazine'){
			liquid.itemLiquidHide.html(liquid.itemLiquidItem.clone());
		}
		
		liquid.itemLiquidInside.hide(0,function(){
			liquid.itemLiquidLoading.height(liquid.itemLiquidInsideHeight).fadeIn(500);
		});
		
		$.post(AJAX_M, {
			'mode': 'liquid',
			'data': {
				'post_id'     : liquid.postID,
				'block_words' : liquid.words,
				'show_social' : liquid.social,
				'image_ratio' : liquid.ratio
			}
		}).done(function(content){
			liquid.itemIsotopeItem.append(content);
			
			liquid.itemLiquidExpand = liquid.itemIsotopeItem.find('.liquid-expand-wrap');
			liquid.itemLiquidClose = liquid.itemLiquidExpand.find('.liquid-item-close');
			
			liquid.itemIsotopeItem.removeClass('width2').addClass(liquid.width);
			liquid.itemLiquidExpand.css({'padding': liquid.space + ' 0 0 ' + liquid.space});
			
			liquid.itemIsotopeItem.imagesLoaded(function(){
				if(liquid.target){
					liquid.isotopeItem = liquid.parents.find('.isotope-item[data-num='+liquid.target+']');
					if(liquid.isotopeItem.length == 0){
						liquid.parents.find('.isotope-item[data-num='+liquid.isotopeLength+']').after(liquid.itemIsotopeItem);
					}else{
						liquid.parents.find('.isotope-item[data-num='+liquid.target+']').after(liquid.itemIsotopeItem);
					}
					liquid.parents.isotope('appended', liquid.itemIsotopeItem);
				}
				liquid.itemLiquidLoading.hide(0,function(){
					themePB.fnLiquidRemove(liquid.itemIsotopeItem, 'other');
					themePB.themeIsotope.setWidths(liquid.size, liquid.parents);
					liquid.itemLiquidExpand.fadeIn(300);
					liquid.parents.isotope({
						masonry: {
							columnWidth: themePB.themeIsotope.getUnitWidth(liquid.size, liquid.parents)
						}
					});
					$('.liquid_handler').removeClass('liquid_handler');
					
					if($.browser.msie == true && parseInt($.browser.version) < 9){}else{
						setTimeout(function(){
							themePB.htmlMarginTop = themePB.html.css('margin-top');
							liquid.space = liquid.space.replace('px','');
							themePB.htmlMarginTop  = themePB.htmlMarginTop.replace('px','');
							if($.browser.msie == true && parseInt($.browser.version) < 9){
								if(themePB.htmlMarginTop  == 'auto'){
									themePB.htmlMarginTop  = 0;
								}
							}
							liquid.itemIsotopeItemOffsetTop = liquid.itemIsotopeItem.offset().top;
							$('html,body').animate({
								scrollTop: liquid.itemIsotopeItemOffsetTop - liquid.space - themePB.htmlMarginTop  - 80
							}, 500);
						}, 1000);
					}
				});
			});

			//Call lightbox plugin
			themePB.fnLightbox();
			
			//call html5 player
			themePB.fnJplayerCall();
			themePB.audioPlayClick(liquid.itemIsotopeItem);
			themePB.audioPauseClick(liquid.itemIsotopeItem);
			
			liquid.itemLiquidClose.click(function(){
				themePB.fnLiquidRemove(liquid.itemIsotopeItem, 'this');
			});
		});
		
	}
	
	//Pagebuild: Pagenums Click
	themePB.fnPagenums = function(paged){
		var page = [];
		
		page.item = paged;
		page.moduleID = page.item.data('module');
		page.modulePost = page.item.data('post');
		page.postID = page.item.data('postid');
		page.paged = page.item.data('paged');
		
		paged.click(function(){
			page.item.parent().find('.select_pagination').removeClass('current');
			page.item.addClass('current').text('Loading');
			
			var ajax_data = {
				'module_id'   : page.moduleID,
				'module_post' : page.modulePost,
				'paged'       : page.paged,
				'post_id'     : page.postID,
				'mode'        : 'pagenums'
			}
			
			themePB.fnModuleLoad(ajax_data, $('div[data-post='+page.modulePost+']').not('.not_pagination'));
			//return false;
		});
	}
	
	//Portfolio: ajax permalink
	themePB.fnAjaxPermalink = function(){
		themePB.moduleAjaxPermalink.each(function(){
			var permalink = [];
			
			permalink.item = $(this);
			permalink.parent = permalink.item.parent();
			permalink.href = permalink.item.attr('href');
			permalink.bgcolor = permalink.parent.data('bgcolor');
			permalink.category = permalink.parent.data('category');
			permalink.inn = false;
			
			permalink.item.click(function(){
				themePB.fnAjaxPortfolio(permalink);
				return false;
			});
		});
		
		themePB.moduleAjaxWrapClose.click(function(){
			themePB.moduleAjaxWrapInn.removeClass('ajaxwrap-fadein').html(null);
			themePB.moduleAjaxWrapClose.addClass('hidden');
			themePB.moduleAjaxWrap.removeClass('ajaxwrap-shown');
		});
	}
	
	//portfolio: ajax processing
	themePB.fnAjaxPortfolio = function(permalink){
		if(permalink.href){
			themePB.moduleAjaxWrapLoading.fadeIn(300, function(){
				themePB.moduleAjaxWrapLoading.removeClass('hidden');
				if(!permalink.inn){
					themePB.moduleAjaxWrapLoading.addClass(permalink.bgcolor);
				}
			});
			themePB.moduleAjaxWrap.addClass('ajaxwrap-shown');
			themePB.moduleAjaxWrapInn.load(permalink.href + ' .gallery-wrap', {
				bgcolor: permalink.bgcolor,
				category: permalink.category,
				mode: 'ajax-portfolio'
			}, function(response, status, xhr){
				if(status == 'success'){
					if(permalink.inn){
						themePB.moduleAjaxWrapInn.removeClass('ajaxwrap-fadein');
					}
					themePB.moduleAjaxWrapLoading.fadeOut(300, function(){
						themePB.moduleAjaxWrapLoading.addClass('hidden').removeClass(permalink.bgcolor);
						themePB.moduleAjaxWrapInn.addClass('ajaxwrap-fadein');
					});
					themePB.moduleAjaxWrapClose.removeClass('hidden');
					
					$('.post-navi a, .related-post-unit-a').each(function(){
						var subPermalink = [];
						
						subPermalink.item = $(this);
						subPermalink.parent = subPermalink.item.parent();
						subPermalink.href = subPermalink.item.attr('href');
						subPermalink.bgcolor = subPermalink.parent.data('bgcolor');
						subPermalink.category = subPermalink.parent.data('category');
						subPermalink.inn = true;
						
						subPermalink.href = subPermalink.href.replace('#/', '');
						$.History.bind('/' + subPermalink.href, function(state){
							themePB.fnAjaxPortfolio(subPermalink);
						});
					});
					
					$('body, html').scrollTop(0);
				}
			});
		}
	}
	
	//pagebuild: animation scroll
	themePB.fnAnimationScroll = function(hasAnimation){
		hasAnimation.imagesLoaded(function(){
			hasAnimation.each(function(){
				var animation = [];
				
				animation.item = $(this);
				animation.scroll = animation.item.find('.animation-scroll-ux');
				
				if(animation.scroll.length){
					animation.scroll.each(function(index){
						var animationItem = [];
						
						animationItem.item = $(this);
						animationItem.classB = animationItem.item.data('animationend');
						
						animationItem.item.waypoint(function(){
							animation.item.css({'opacity': 1});
							animationItem.item.css('transform', null);
							setInterval(function(){
								animationItem.item.css({'opacity': 1});
								if(!animationItem.item.hasClass(animationItem.classB)){
									animationItem.item.addClass(animationItem.classB);
								}
								setTimeout(function(){
									animationItem.item.removeClass('animation-default-ux').removeClass('animation-scroll-ux');
								}, 1500);
							}, index * 50);
						}, {
							offset: '120%',
							triggerOnce: true
						});
					});
				}
			});
		})
	}
	
	
	
	//pagebuild: video face
	themePB.fnVideoFace = function(arrayVideo){
		arrayVideo.each(function(){
			var videoFace = [];
			var videoOverlay = [];
			
			videoFace.item = $(this);
			videoFace.playBtn = videoFace.item.find('.video-play-btn');
			videoFace.videoWrap = videoFace.item.find('.video-wrap');
			videoFace.videoIframe = videoFace.videoWrap.find('iframe');
			
			videoOverlay.item = themePB.videoOverlay;
			videoOverlay.videoWrap = videoOverlay.item.find('.video-wrap');
			videoOverlay.close = videoOverlay.item.find('.video-close');
			
			videoFace.playBtn.click(function(){
				var src = videoFace.videoIframe.attr('src').replace('autoplay=0', 'autoplay=1');
				videoFace.videoIframe.attr('src', src);
				videoOverlay.close.before(videoFace.videoWrap.removeClass('hidden').attr('style', 'height:100%;padding-bottom:0px;'));
				videoOverlay.item.addClass('video-slidedown');
			});
			
			videoOverlay.close.click(function(){
				videoOverlay.item.removeClass('video-slidedown');
				videoOverlay.item.find('.video-wrap').remove();
			});
		});
	}
	
	//document ready
	themePB.doc.ready(function(){
		
		//Contact form
		if(themePB.moduleContactForm.length){
			themePB.fnContactForm();
		}
		
		//Tabs Moudle Call
		if(themePB.moduleTabs.length){
			themePB.moduleTabs.each(function(){
				var tab = $(this);
				
				tab.delegate('a', 'click', function(e){
					e.preventDefault();
					jQuery(this).tab('show');
				});
			})
		}
		
		//Icon box Plus
		if(themePB.moduleIconbox.length){
			themePB.moduleIconbox.each(function(){
				var iconbox = [];
				
				iconbox.item = $(this);
				iconbox.animation = iconbox.item.data('animation');
				iconbox.svg = iconbox.item.find('.iconbox-plus-svg-wrap');
				
				themePB.itemIconboxs.push(iconbox);
			}); 
		}
		
		//AccordionToggle Moudle Call
		if(themePB.moduleAccordion.length){
			themePB.moduleAccordion.each(function(){
				var accordion = [];
				
				accordion.item = $(this);
				accordion.collapse = accordion.item.find('.collapse');
				accordion.accordion = accordion.item.find('.accordion');
				
				if(accordion.item.hasClass('accordion_toggle')){
					accordion.collapse.collapse({ toggle: false});
				}
	
				accordion.item.find('.accordion-body.in').prev().addClass("active");
	
				accordion.item.find('.accordion-toggle').click(function(e){
					if($(this).parent().hasClass('active')){
						$(this).parent().toggleClass('active');
						accordion.item.find(".accordion-heading").removeClass("active");
					}else{
						accordion.item.find(".accordion-heading").removeClass("active");
						$(this).parent().toggleClass('active');             
					}
					
					e.preventDefault;
					e.stopPropagation;
				});
			});
		}
		
		//Pagebuild: Separator 
		if(themePB.moduleSeparator.length){
			themePB.moduleSeparator.each(function(){
				var separator = [];
				
				separator.item = $(this);
				separator.title = separator.item.find('h4');
				separator.inn = separator.item.find('.separator_inn');
				
				themePB.itemSeparator.push(separator);
			})
		}
		
		//Pagebuild: Message Box Moudle	Close
		if(themePB.moduleMessageBox.length){
			themePB.moduleMessageBox.each(function(){
				var message = [];
				
				message.item = $(this);
				message.itemClose = message.item.find('.box-close');
				
				message.itemClose.click(function(){
					message.item.slideUp(400);
				});
			});
		}
		
		//Pagebuild: Countdown	
		if(themePB.moduleCountdown.length){
			themePB.moduleCountdown.each(function(){
				var countdown = [];
				
				countdown.item = $(this);
				countdown.dateUntil = countdown.item.data('until');
				countdown.dateFormat = countdown.item.data('dateformat');
				countdown.dateYears = Number(countdown.item.data('years'));
				countdown.dateMonths = Number(countdown.item.data('months'));
				countdown.dateDays = Number(countdown.item.data('days'));
				countdown.dateHours = Number(countdown.item.data('hours'));
				countdown.dateMinutes = Number(countdown.item.data('minutes'));
				countdown.dateSeconds = Number(countdown.item.data('seconds'));
				countdown.austDay = new Date(countdown.dateYears, countdown.dateMonths - 1, countdown.dateDays, countdown.dateHours, countdown.dateMinutes, countdown.dateSeconds);
				
				countdown.item.countdown({until: countdown.austDay, format: countdown.dateFormat});
			});
		}
		
		//Pagebuild: Client Moudle
		if(themePB.moduleClientsWrap.length){
			themePB.moduleClientsWrap.each(function(){
				var clients = [];
				
				clients.item = $(this);
				clients.column = clients.item.data('column');
				clients.images = clients.item.find('img');
				clients.lists = clients.item.find('ul');
				clients.listItem = clients.item.find('li');
				clients.firstChildImg = clients.item.find("li:first-child img");
				clients.prev = clients.item.find('.prev');
				clients.next = clients.item.find('.next');
				clients.caroufredsel = clients.item.find('.caroufredsel_wrapper');
				clients.carouselBtn = clients.item.find('.carousel-btn');
				
				if(themePB.win.width()<480) {
					clients.column = 2;
				}
				
				themePB.itemClients.push(clients);
			});
		}
		
		//Pagebuild: GoogleMap Moudle
		if(themePB.moduleGoogleMap.length){
			themePB.moduleGoogleMap.each(function(index, element) {
				var googlemap = [];
				
				googlemap.item = $(this);
				googlemap.element = element;
				googlemap.l = Number(googlemap.item.data('l'));
				googlemap.r = Number(googlemap.item.data('r'));
				googlemap.zoom = Number(googlemap.item.data('zoom'));
				googlemap.pin = googlemap.item.data('pin');
				googlemap.pin_custom = googlemap.item.data('pin-custom');
				googlemap.view = googlemap.item.data('view');
				googlemap.dismouse = googlemap.item.data('dismouse');
				googlemap.style = googlemap.item.data('style');
				googlemap.style_code = googlemap.item.next('.module-map-style-code').val();
				
				themePB.fnMapInit(googlemap);
			});
		}
		
		//Pagebuild: Fullwrap Tab
		if(themePB.moduleFullwidthTabs.length){
			themePB.moduleFullwidthTabs.each(function(){
				var tab = [];
				
				tab.item = $(this);
				tab.link = tab.item.children('a');
				tab.firstLink = tab.item.children('a:first');
				tab.itemid = tab.item.data('itemid');
				tab.parents = tab.item.parents('.fullwidth-wrap');
				tab.parentsRow = tab.parents.find('.row-fluid');
				
				tab.firstLink.addClass('full-nav-actived');
				tab.item.contents().filter(function() {
					return this.nodeType === 3;
				}).remove();
				
				tab.parentsRow.each(function(i){
					$(this).attr('id', 'tabs-' + tab.itemid + '-' + i);
					$(this).addClass('fullwrap-with-tab-inn');
					if(i == 0){
						$(this).addClass('enble');
					}else{
						$(this).addClass('disble');
					}
				});
				
				tab.link.each(function(i){
					var linkTarget = 'tabs-' + tab.itemid + '-' + i;
					$(this).attr('data-target', linkTarget);
					
					$(this).click(function(){
						var linkTargetParents = $(this).parents('.fullwidth-wrap');
						
						linkTargetParents.find('.fullwrap-with-tab-inn').removeClass('enble').addClass('disble');
						linkTargetParents.find('[id=' + linkTarget + ']').removeClass('disble').addClass('enble');
						
						if($(this).hasClass('full-nav-actived')){}else{
							$(this).addClass('full-nav-actived');
						}
						
						$(this).siblings('a').removeClass('full-nav-actived');
					});
				});
			});
		}
		
		//Pagebuild: Call Carousel Slider, Content slider responsive
		if(themePB.moduleListItemSlider.length){
			themePB.moduleListItemSlider.each(function(){
				var slider = [];
				
				slider.item = $(this);
				slider.itemItem = slider.item.find('.item');
				slider.title = slider.item.find('.slider-title');
				slider.titleH2 = slider.item.find('h2.slider-title');
				slider.description = slider.item.find('.slider-des');
				slider.panel = slider.item.find('.slider-panel');
				slider.image = slider.item.find('img');
				slider.carouselImage = slider.item.find('.carousel-img-wrap');
				slider.carouselIndicators = slider.item.find('.carousel-indicators');
				
				themePB.itemListItemSlider.push(slider);
			});
		}
		
		//Pagebuild: Flex Slider
		if(themePB.moduleFlexSliderWrap.length){
			themePB.fnFlexslider();
		}
		
		//Pagebuild: Pagnition/twitter style
		if(themePB.modulePagenumsTwitter.length){
			themePB.modulePagenumsTwitter.each(function(){
				var twitterLink = [];
				
				twitterLink.item = $(this);
				twitterLink.moduleID = twitterLink.item.data('module');
				twitterLink.modulePost = twitterLink.item.data('post');
				twitterLink.postID = twitterLink.item.data('postid');
				twitterLink.paged = twitterLink.item.data('paged');
				
				twitterLink.item.click(function(){
					twitterLink.item.html('<span>Loading...</span>');
					
					twitterLink.paged = twitterLink.item.attr('data-paged');
					
					var ajax_data = {
						'module_id'   : twitterLink.moduleID,
						'module_post' : twitterLink.modulePost,
						'paged'       : twitterLink.paged,
						'post_id'     : twitterLink.postID,
						'mode'        : 'twitter'
					}
					
					themePB.fnModuleLoad(ajax_data, $('div[data-post='+twitterLink.modulePost+']').not('.not_pagination'));
					return false;
				});
			})
			
		}
		
		//Pagebuild: Liquid List
		if(themePB.moduleLiquidlist.length){
			themePB.fnLiquidlist();
		}
		
		//Pagebuild: Liquid Click
		if(themePB.moduleLiquidImage.length){
			themePB.moduleLiquidImage.each(function(){
				$(this).css('cursor','pointer');
				themePB.fnLiquidClick($(this));
			})
		}
		
		//Pagebuild: Pagenums Click
		if(themePB.modulePagenumsSelect.length){
			themePB.modulePagenumsSelect.each(function(){
				themePB.fnPagenums($(this));
			})
		}
		
		//Portfolio: mouseover mask
		if(themePB.moduleMouseoverMask.length){
			themePB.moduleMouseoverMask.each( function() { 
				$(this).find('.mask-hover-inn').hoverdir(); 
			});
		}
		
		//Portfolio: ajax permalink
		if(themePB.moduleAjaxPermalink.length){
			themePB.moduleAjaxPermalink.each(function(){ 
				themePB.fnAjaxPermalink();
			});
		}
		
		//Portfolio: call video popup
		if(themePB.videoFace.length){
			themePB.fnVideoFace(themePB.videoFace);
		}

		//Modernizr.touch
		if(Modernizr.touch){
			if(themePB.moduleFullwidthWrap.length){
				themePB.moduleFullwidthWrap.each(function(){
					$(this).css('background-attachment','scroll');
				})
			}
		} // End if Modernizr.touch
		
	});
	
	//win load
	themePB.win.load(function(){
		
		//Tab-v responsive
		if(themePB.moduleTabsV.length){
			themePB.fnTabResponsive();
			themePB.win.on("debouncedresize", themePB.fnTabResponsive);
		}
		
		//Pagebuild: Promote centered
		if(themePB.modulePromoteCenter.length && themePB.modulePromoteButton.length){ 
			themePB.fnPromoteCentered(); 
			themePB.win.on("debouncedresize", themePB.fnPromoteCentered);
		}
		
		//Pagebuild: Client Moudle
		if(themePB.moduleClientsWrap.length){
			themePB.fnClients();
			themePB.win.on("debouncedresize", themePB.fnClients);
		}
		
		//Pagebuild: Image Box Moudle
		if(themePB.moduleImagebox.length){
			themePB.moduleImagebox.each(function(){
				if(Modernizr.touch){
					$(this).addClass('shown');
				}else{
					$(this).waypoint(function(){ $(this).addClass('shown'); }, { offset: '120%'});
				}
			});
		}
		
		//Pagebuild: Post Carousel Moudle
		if(themePB.modulePostCarousel.length){
			themePB.fnPostCarousel();
			themePB.win.on("debouncedresize", themePB.fnPostCarousel);
		}
		
		//Pagebuild: Fullwrap wrap:  set the padding for vertical cenerted, set the height for half fullwrap
		if(themePB.moduleFullwidthWrap.length){
			themePB.moduleFullwidthWrap.each(function(){
				var fullwidth = [];
				
				fullwidth.item = $(this);
				fullwidth.itemHeight = fullwidth.item.data('height');
				fullwidth.half = fullwidth.item.find('.fullwrap-half');
				fullwidth.halfBg = fullwidth.item.find('.fullwrap-half-bg');
				fullwidth.halfContent = fullwidth.item.find('.fullwrap-half-content');
				
				/*if(fullwidth.item.hasClass('height-no-auto')){
					//if set heigh for fullwrap
					if(fullwidth.half.length){
						
						fullwidth.itemRow = fullwidth.item.children('.row-fluid');
						fullwidth.itemRowHeight = fullwidth.itemRow.height();
						fullwidth.backimgHeight = fullwidth.itemRowHeight + 50;
						fullwidth.innerHeight = fullwidth.item.find('.fullwrap-half-content').height();
						fullwidth.WrapPadding = (fullwidth.itemRowHeight - fullwidth.innerHeight) /2;
						
						//set the height for half fullwrap's background image
						fullwidth.halfBg.css('min-height', fullwidth.itemRowHeight); 
						fullwidth.halfContent.css({'paddingTop':fullwidth.WrapPadding +'px','paddingBottom':fullwidth.WrapPadding +'px'});
						
					}else{
						//if general fllwrap	
						if(fullwidth.item.children('.container').length){
							//if boxed	
							fullwidth.innerHeight = fullwidth.item.find('.container').outerHeight(true);
							fullwidth.WrapPadding = (fullwidth.itemHeight - fullwidth.innerHeight) /2;
							fullwidth.item.css({'paddingTop':fullwidth.WrapPadding+'px','paddingBottom':fullwidth.WrapPadding+'px'});
							
						}else{
							//if content fill to width	
							fullwidth.itemRow = fullwidth.item.find('.row-fluid'),
							fullwidth.innerHeight = fullwidth.item.find('.row-fluid').outerHeight(true);

							if(fullwidth.itemRow.length == '1'){
								fullwidth.WrapPadding = (fullwidth.itemHeight - fullwidth.innerHeight) /2;
								fullwidth.item.css({'paddingTop':fullwidth.WrapPadding+'px','paddingBottom':fullwidth.WrapPadding+'px'});
							}
						}
					}
				}else{
					//if heigh auto for fullwrap	
					if(fullwidth.half.length){
						fullwidth.itemRow = fullwidth.item.find('.row-fluid');
						fullwidth.itemRowHeight = fullwidth.itemRow.height();
						fullwidth.backimgHeight = fullwidth.itemRowHeight + 50;

						//set the height for half fullwrap's background image
						fullwidth.halfBg.css('min-height', fullwidth.itemRowHeight);
					}
				}*/
			});
		}
		
		//Pagebuild: image module shadow
		if(themePB.moduleImageShadow.length){
			themePB.moduleImageShadow.each(function(){
				$(this).imagesLoaded(function(){
					$(this).css('opacity','1');
				});
			});
		}
		
		//Pagebuild: Call Carousel Slider, Content slider responsive
		if(themePB.moduleListItemSlider.length){
			themePB.fnContentslider();
			themePB.win.on("debouncedresize", themePB.fnContentslider);
		}
		
		//pagebuild: animation scroll
		if(themePB.moduleHasAnimation.length && !themePB.isMobile()){
			themePB.fnAnimationScroll(themePB.moduleHasAnimation);
		}
		
		//Icon box Plus
		$.each(themePB.itemIconboxs, function(index, iconbox){
			if(Modernizr.touch){
				iconbox.svg.addClass('breath').addClass(iconbox.animation);
			}else{
				iconbox.item.waypoint(function(){
					if(iconbox.animation == "rorate"){
						iconbox.svg.addClass('breath').addClass(iconbox.animation);
					}else{
						iconbox.svg.addClass('breath').addClass(iconbox.animation); 
					}
				}, { offset: '120%'});
			}
		});
		
		//Pagebuild: Separator 
		$.each(themePB.itemSeparator, function(index, separator){
			separator.titleWidth = separator.title.outerWidth();
			
			if(separator.item.hasClass('title_on_left')){
				separator.inn.css({'margin-left': separator.titleWidth + 'px'});
			}else if(separator.item.hasClass('title_on_right')){
				separator.inn.css({'margin-right': separator.titleWidth + 'px'});
			}
			
			separator.inn.css({zIndex: 0});
			separator.item.animate({ opacity:'1'}, 200);
		});
		
		//parallax
		if(themePB.moduleParallax.length){
			themePB.moduleParallax.each(function(){
				var parallax = {};
				
				parallax.element = $(this);
				parallax.ratio = parallax.element.data('ratio');
				parallax.ratio_speed = 1 + parallax.ratio;
				
				parallax.height = parallax.element.height();
				parallax.width = parallax.element.width();
				parallax.maxHeight = parallax.height * parallax.ratio_speed;
				
				parallax.image = parallax.element.find('img');
				parallax.image_height = parallax.image.height();
				parallax.image_width = parallax.image.width();
				
				parallax.xPosition = 0;
				parallax.yPosition = 0;
				parallax.outHeight = 0;
				parallax.outWidth = 0;
				
				if(!parallax.element.is('.front-background')){ 
					//if image height less than parallax height
					if(parallax.image_height <= parallax.maxHeight){
						parallax.image.css({
							'width': 'auto',
							'height': parallax.maxHeight + 'px',
							'max-width': 'inherit'
						});
					}
					
					parallax.outWidth = (parallax.width - parallax.image.width()) / 2;
					parallax.outHeight = (parallax.height - parallax.image.height()) / 2;
					
					parallax.xPosition = parallax.outWidth;
					parallax.yPosition = (parallax.element.offset().top - themePB.winScrollTop - parallax.outHeight) * (parallax.ratio / 3);
					parallax.yPosition = - parallax.yPosition;
					if(!themePB.isMobile()){
						themePB.fnSetTranslate3DTransform(parallax.element, parallax.xPosition, parallax.yPosition);
					}
				}
				
				themePB.itemParallax.push(parallax);
				
			});
		}
		
		/*if(themePB.winHash){
			themePB.winHashTarget = $('div[data-post=\"' + themePB.winHash + '\"]');
			if(themePB.winHashTarget.length){
				themePB.win.find('img').imagesLoaded(function(){
					setTimeout(function(){ 
						$("html, body").animate({scrollTop:themePB.winHashTarget.offset().top}, 300);
					}, 1000);
					 
				});
			}
		}*/
		
		if(themePB.modulePage){
			var moduleSelector =  $('a.pagenums-a[data-post=\"'+themePB.winHash+'\"][data-paged=\"'+themePB.modulePaged+'\"]');
			var moduleSelectorParent = moduleSelector.parent();
			
			moduleSelectorParent.find('a.pagenums-a').removeClass('current');
			moduleSelector.addClass('current');
			
			if(themePB.winHash){
				var ajax_data = {
					'module_id'   : moduleSelector.attr('data-module'),
					'module_post' : themePB.winHash,
					'paged'       : themePB.modulePaged,
					'post_id'     : moduleSelector.attr('data-postid'),
					'mode'        : 'pagenums'
				}
				
				themePB.fnModuleLoad(ajax_data, $('div[data-post='+themePB.winHash+']').not('.not_pagination'));
			}
		}
	});
	
	//win scroll
	themePB.win.scroll(function(){
		if(!themePB.isMobile()){
			themePB.winScrollTop = themePB.win.scrollTop();
			$.each(themePB.itemParallax, function(index, parallax){
				parallax.yPosition = (parallax.element.offset().top - themePB.winScrollTop - parallax.outHeight) * (parallax.ratio / 3);
				parallax.yPosition = - parallax.yPosition;
				themePB.fnSetTranslate3DTransform(parallax.element, parallax.xPosition, parallax.yPosition);
			});
		}
	});
	
})(jQuery);
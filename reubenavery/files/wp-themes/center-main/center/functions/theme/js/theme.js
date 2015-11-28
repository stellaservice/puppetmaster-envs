jQuery(document).ready(function(){
    //theme switch color
	jQuery('.switch-color').each(function(index, element){
        var _this = jQuery(this);
		var _this_parents = _this.parents('[data-scheme]');
		var _this_scheme_name = _this_parents.data('scheme');
		
		_this.minicolors({
			theme: 'bootstrap',
			letterCase: 'uppercase',
			changeDelay: 200,
			change: function(hex, opacity) {
				var _scheme = jQuery('.ux-theme-color-scheme');
				var _scheme_active = _scheme.find('.active');
				var _scheme_color = _scheme_active.find('[data-name=' + _this_scheme_name + ']');
				var _scheme_selected = _scheme_active.find('.selected');
				var _scheme_triangle = _scheme_active.find('.triangle');
				
				if(_this_scheme_name == 'scheme_theme_main_color'){
					_scheme_selected.css({'border-color': hex});
					_scheme_triangle.css({'border-bottom-color': hex});
				}
				
				if(_this_scheme_name == 'scheme_page_bg_color'){
					_scheme_active.css({'background-color': hex});
				}
				
				_scheme_color.val(hex);
				
			}
		});
    });
	
	//theme select images
	jQuery('.ux-theme-select-images').each(function(index, element){
        var _this = jQuery(this);
		var _this_name = _this.data('name');
		var _this_content = _this.parent().next('.theme-option-select-images-content').find('.nav');
		var _this_html = '';
		
		_this_content.sortable();
		_this.click(function(){
			var frame = wp.media({
				title : 'Insert Media',
				multiple : true,
				library : { type : 'image'},
				button : { text : 'Insert' }
			});
			
			frame.on('select',function() {
				
				attachments = frame.state().get('selection').toJSON();
				
				for(var i=0; i<attachments.length; i++){
					var id = attachments[i]['id'];
					var thumbnail = attachments[i]['url'];
					
					_this_html += '<li><img src="' + thumbnail + '" /><input type="hidden" name="ux_theme_option[' + _this_name + '][]" value="' + id + '"/><span class="glyphicon glyphicon-remove"></span></li>';
					
				}
				_this_content.append(_this_html);
				
				jQuery('.theme-option-select-images-content .nav > li').each(function(){
					jQuery(this).delegate('.glyphicon', 'click', function(){
						jQuery(this).parent().remove();
					});
				});
			});
				
			frame.open();
			
		});
		
		_this_content.find('> li').each(function(){
            jQuery(this).delegate('.glyphicon', 'click', function(){
				jQuery(this).parent().remove();
			});
        });
    });
	
	//theme scheme color
	jQuery('.ux-theme-color-scheme').each(function(index, element){
		var _this = jQuery(this);
		var _this_item = _this.find('.scheme-item');
		var _this_parents = _this.parents('#options-schemes');
		
		_this.delegate('.scheme-item', 'click', function(){
			var _item = jQuery(this);
			var _item_scheme = _item.find('[name]');
			var _item_id = _item.data('scheme-id');
			
			_this_item.removeClass('active');
			jQuery(this).addClass('active');
			
			_this.next('input:hidden').val(_item_id);
			
			_item_scheme.each(function(){
				var _scheme = jQuery(this);
				var _scheme_name = _scheme.attr('data-name');
                var _scheme_color = _scheme.val();
				
				var _target = _this_parents.find('[data-scheme=' + _scheme_name + ']');
				var _target_color = _target.find('.switch-color');
				var _target_swatch_color = _target.find('.minicolors-swatch-color');
				var _target_picker = _target.find('.minicolors-picker');
				
				_target_color.val(_scheme_color);
				_target_swatch_color.css({'background-color': _scheme_color});
				_target_picker.css({left:0, top:0});
            });
		});
    });
	
	//theme remove color
	jQuery('.ux-theme-remove-color').each(function(index, element){
		var _this = jQuery(this);
		var _this_switch = _this.parents('.ux-theme-switch-color');
		var _this_color = _this_switch.find('.switch-color');
		var _this_swatch_color = _this_switch.find('.minicolors-swatch-color');
		var _this_picker = _this_switch.find('.minicolors-picker');
		_this.click(function(){
			_this_color.val(null);
			_this_swatch_color.removeAttr('style');
			_this_picker.css({left:0, top:0});
		})
    });
	
	////theme new social medias event
	jQuery('.ux-theme-new-social-medias').each(function(){
        var _social_medias = jQuery(this).find('.ux-theme-social-medias');
		
		_social_medias.each(function(index, element){
			var _this = jQuery(this);
			var _this_parents = _this.parent();
			var _this_add = _this.find('.social-medias-add');
			var _this_remove = _this.find('.social-medias-remove');
			var _this_select_icon = _this.find('.new-media-col-select-icon button');
			var _this_icon = _this.find('.new-media-col-icon');
			var _this_last, _this_clone;
			
			_this_add.click(function(){
				_this_parents = _this.parents('.ux-theme-new-social-medias');
				_this_last = _this_parents.find('.ux-theme-social-medias:last');
				_this_last_rel = Number(_this_last.attr('rel'));
				_this_clone = _this_last.clone();
				_this_clone_rel = _this_last_rel + 1;
				_this_last.after(_this_clone);
				_this_clone.attr('rel', _this_clone_rel);
				_this_clone.find('.social-medias-add').parent().addClass('hidden');
				_this_clone.find('.social-medias-remove').parent().removeClass('hidden').css({'right': '40px'});
				_this_clone.find('.social-medias-remove').click(function(){
					jQuery(this).parents('.ux-theme-social-medias').remove();
				});
				_this_clone.find('.new-media-col-icon').click(function(){
					jQuery(this).find('.icon-content').html('');
					jQuery(this).find('input').val('');
				});
				
				ux_theme_col_select_icon(_this_clone.find('.new-media-col-select-icon button'));
			});
			
			_this_remove.click(function(){
				jQuery(this).parent().removeClass('hidden').parents('.ux-theme-social-medias').remove();
			});
			
			_this_icon.click(function(){
				jQuery(this).find('.icon-content').html('');
				jQuery(this).find('input').val('');
			});
			
			ux_theme_col_select_icon(_this_select_icon);
			
		});
    });
	
	function ux_theme_col_select_icon(el){
		el.click(function(){
			var _this_title = jQuery(this).data('title');
			var _this_rel = jQuery(this).parent().parent().attr('rel');
			var _this_parents = jQuery(this).parents('.ux-theme-new-social-medias');
			var _this_type = '';
			jQuery('#ux-theme-modal-title').text(_this_title);
			
			if(_this_parents.is('.ux-widget-social-network-icons')){
				_this_type = jQuery(this).parents('.widget').attr('id');
			}
			
			jQuery('#ux-theme-modal-body').html('');
			jQuery('#ux-theme-modal').modal('show');
			jQuery('#ux-theme-modal .modal-footer').hide();
			
			jQuery.post(ajaxurl, {
				'action': 'ux_theme_option_select_icons',
				'i': _this_rel,
				'type': _this_type
			}).done(function(content){
				jQuery('#ux-theme-modal-body').html(content);
			});
		});
	}
	
	//theme social medias event
	jQuery('.ux-theme-social-medias-lists').each(function(index, element){
        var _social_medias = jQuery(this).find('.ux-theme-social-medias');
		
		_social_medias.each(function(index, element){
			var _this = jQuery(this);
			var _this_parents = _this.parents('.ux-theme-social-medias-lists');
			var _this_add = _this.find('.social-medias-add');
			var _this_remove = _this.find('.social-medias-remove');
			var _this_last, _this_clone;
			
			_this_add.click(function(){
				_this_parents = _this.parents('.ux-theme-social-medias-lists');
				_this_last = _this_parents.find('.ux-theme-social-medias:last');
				_this_clone = _this_last.clone();
				_this_last.after(_this_clone);
				_this_clone.find('.social-medias-add').addClass('hidden');
				_this_clone.find('.social-medias-remove').removeClass('hidden').click(function(){
					jQuery(this).parents('.ux-theme-social-medias').remove();
				});
			});
			
			_this_remove.click(function(){
				jQuery(this).removeClass('hidden').parents('.ux-theme-social-medias').remove();
			});
		});
    });
	
	//theme control
	function ux_theme_switch_control(){
		jQuery('.theme-option-item[data-super]').each(function(){
			var _this = jQuery(this);
			var _this_name = _this.data('super');
			var _this_value = _this.data('supervalue');
			var _this_select = jQuery('[data-class=' + _this_name +']');
			var _this_select_val = _this_select.data('value');
			
			_this.hide();
			if(_this_select_val == _this_value){
				_this.show();
			}
		});
		
		jQuery('.theme-option-item [data-name]').each(function(){
			var _this = jQuery(this);
			var _this_name = _this.data('name');
			var _this_value = _this.data('value');
			var _this_parents = _this.parents('.theme-option-item');
			var _this_select = jQuery('[data-class=' + _this_name +']');
			var _this_select_val = _this_select.data('value');
			var _this_select_parents = _this_select.parents('[data-name]');
			
			if(_this_parents.is('.theme-option-item-do-action')){
				_this_select = _this_parents.find('[data-class=' + _this_name +']');
				_this_select_val = _this_select.data('value');
				_this_select_parents = _this_select.parents('[data-name]');
			}
			
			_this.hide();
			if(_this_select_val == _this_value){
				_this.show();
			}
			
			if(_this_select_parents.length > 0){
				var _parents_name = _this_select_parents.data('name');
				var _parents_value = _this_select_parents.data('value');
				var _parents_select = jQuery('[data-class=' + _parents_name +']');
				var _parents_select_val = _parents_select.data('value');
				
				if(_parents_select_val == _parents_value){
					_this.show();
					if(_this_select_val != _this_value){
						_this.hide();
					}
					ux_theme_switch_children(_parents_name, 'true');
				}else{
					_this.hide();
					ux_theme_switch_children(_parents_name, 'false');
				}
			}
		});
		
		var _post_format_gallery = jQuery('#post-format-gallery');
		var _layout_builder = jQuery('.theme_meta_enable_portfolio_list_layout_builder');
		
	}
	ux_theme_switch_control();
	
	//theme switch children
	function ux_theme_switch_children(_this_name, _switch){
		jQuery('.theme-option-item [data-name=' + _this_name + ']').each(function(index, element){
			var _this = jQuery(this);
			var _this_select = _this.find('[name*=ux_theme_meta]');
			var _this_select_name, _this_children, _this_select_val = 'false';
			
			if(_this_select.length){
				_this_select_name = _this_select.attr('name').replace('ux_theme_meta[', '');
				_this_select_name = _this_select_name.replace(']', '');
				_this_select_name = _this_select_name.replace('[]', '');
				if(_this_select.val()){
					_this_select_val = _this_select.val();
				}
				_this_children = jQuery('.theme-option-item [data-name=' + _this_select_name + '][data-value=' + _this_select_val + ']');
				
				if(_switch == 'true'){
					_this_children.fadeIn();
				}else{
					_this_children.fadeOut();
				}
			}
		});
	}
	
	//theme select change control 
	jQuery('select[name*=ux_theme_meta]').each(function(){
        var _this = jQuery(this);
		var _this_name = _this.attr('name');
		var _this_control, _super_control;
		
		_this_name = _this_name.replace('ux_theme_meta[', '');
		_this_name = _this_name.replace(']', '');
		_this_name = _this_name.replace('[]', '');
		_this_control = jQuery('.theme-option-item [data-name=' + _this_name + ']');
		_super_control = jQuery('.theme-option-item[data-super=' + _this_name + ']');
		
		_this.change(function(){
			var _this_value = jQuery(this).val();
			
			if(_super_control.length){
				_super_control.each(function(){
					var _super = jQuery(this);
					var _super_val = _super.attr('data-supervalue');
					if(_super_val == _this_value){
						_super.show();
					}else{
						_super.hide();
					}
				});
			}
			
			_this_control.each(function(){
				var _control_value = jQuery(this).attr('data-value');
				if(_this_value == _control_value){
					jQuery(this).show();
				}else{
					jQuery(this).hide();
				}
			});
			
		});
    });
	
	//theme switch
	jQuery('.make-switch').on('switch-change', function(e, data){
		var _this = jQuery(this);
		var _this_name = _this.find('[name]').attr('data-class');
		var _this_children = _this.children();
		var _this_input = _this.find('input[type=hidden]');
		var _this_control = jQuery('.theme-option-item [data-name=' + _this_name + ']');
		var _super_control = jQuery('.theme-option-item[data-super=' + _this_name + ']');
		var _this_val;
		
		if(_this_children.is('.switch-on')){
			_this_val = 'true';
			//_this_control.fadeIn();
			_this_input.removeData('value');
			_this_input.val('true').attr('data-value', 'true');
			//ux_theme_switch_children(_this_name, 'true');
		}else if(_this_children.is('.switch-off')){
			_this_val = 'false';
			//_this_control.fadeOut();
			_this_input.removeData('value');
			_this_input.val('false').attr('data-value', 'false');
			//ux_theme_switch_children(_this_name, 'false');
		}
		
		if(_super_control.length){
			_super_control.each(function(){
				var _super = jQuery(this);
				var _super_val = _super.attr('data-supervalue');
				if(_super_val == _this_val){
					_super.show();
				}else{
					_super.hide();
				}
			});
		}
		
		_this_control.each(function(){
            var _control = jQuery(this);
			var _control_val = _control.attr('data-value');
			if(_control_val == _this_val){
				_control.show();
			}else{
				_control.hide();
			}
        });
		
		ux_theme_switch_children(_this_name, _this_val);
		
		
	});
	
	//theme checkbox
	jQuery('.make-checkbox').each(function(index, element){
        var _this = jQuery(this);
		var _this_input = _this.next('input');
		
		if(_this_input.val() == 'true'){
			_this.attr('checked', 'checked');
		}else{
			_this.removeAttr('checked');
		}
		
		_this.click(function(){
			if(_this.is(':checked')){ _this_input.val(true); }else{ _this_input.val(false); }
		});
    });
	
	//theme upload image
	jQuery('.theme-option-upload').each(function(index, element){
        var _this = jQuery(this);
		var _this_input = _this.find('[name]');
		
		_this.delegate('.ux-theme-upload-image', 'click', function(){
			var _this_title = jQuery(this).data('title');
			
			jQuery('#ux-theme-modal-body').height(400).html('<iframe width="100%" height="100%" frameborder="0" src="media-upload.php?type=image"></iframe>');
			jQuery('#ux-theme-modal-title').text(_this_title);
			jQuery('#ux-theme-modal .modal-footer').hide();
			
			window.original_send_to_editor = window.send_to_editor;
			window.send_to_editor = function(html){
		
				if(_this_input){
					fileurl = jQuery('img',html).attr('src');
					_this_input.val(fileurl);
				}else{
					window.original_send_to_editor(html);
				}
				
				jQuery('#ux-theme-modal').modal('hide');
			}
		});
		
		_this.delegate('.ux-theme-remove-image', 'click', function(){
			_this_input.val('');
		});
    });
	
	//theme form submit
	jQuery('#ux-theme-option-form [type=submit]').click(function(event){
		jQuery(this).text(jQuery(this).data('loading'));
	});
	
	//theme button
	jQuery('[data-ux-button]').each(function(index, element){
        var _this = jQuery(this);
		var _this_type = _this.data('ux-button');
		var _this_url = _this.data('url');
		var _this_xml = _this.data('xml');
		var _this_notice = _this.data('notice');
		var _this_attachments = _this.data('attachments');
		var _this_wpnonce = _this.parent().find('[name=_wpnonce]').val();
		var _this_http_referer = _this.parent().find('[name=_wp_http_referer]').val();
		var _generate_content = jQuery('#generate-thumbs-content');
		
		_this.bind('click', function(){
			switch(_this_type){
				case 'font-synchronous':
					_this.button('loading');
					
					jQuery.post(ajaxurl, {
						'action':'ux_theme_option_googlefont'
					}).done(function(content){
						if(content == 'success'){
							_this.text('Updating accomplished');
							_this.removeClass('btn-primary').addClass('btn-success');
							_this.button('reset');
							_this.unbind('click');
							ux_theme_load_fonts();
						}else if(content == 'error'){
							_this.text('Failed,try again please.');
							setTimeout(function(){
								_this.button('reset');
							}, 10000);
						}
					});
				break;
				
				case 'import-demo-data':
					jQuery('#ux-theme-modal-body').html('<blockquote class="ux-theme-modal-notice">' + _this_notice + '</blockquote>');
					jQuery('#ux-theme-modal-title').text(_this.text());
					jQuery('#ux-theme-modal').modal('show');
					jQuery('#ux-theme-modal .modal-footer').show().find('button').each(function(){
						if(jQuery(this).is('.ux-theme-modal-agree') || jQuery(this).is('.btn-default')){
							jQuery(this).show();
						}else{
							jQuery(this).hide();
						}
					});
					
					_this_xml = jQuery('select[data-class=theme_meta_demo_site]').val();
					
					ux_theme_modal_agree({
						'action'            : 'ux_theme_import_ajax',
						'xml'               : _this_xml,
						'fetch_attachments' : 0,
						'_wpnonce'          : _this_wpnonce,
						'_wp_http_referer'  : _this_http_referer
					}, _this);
				break;
				
				case 'generate-thumbs':
					_this.button('loading');
					
					jQuery.post(ajaxurl, {
						'action':'ux_theme_option_generate_thumbs_ajax'
					}).done(function(content){
						if(content != 'error'){
							var _content = jQuery(content);
							
							_generate_content.html(_content);
							
							var _content_progress = _generate_content.find('#generate_thumbs_progress');
							var _content_progress_count = _generate_content.find('#generate_thumbs_progress_count');
							var _content_progress_thumbnails = _generate_content.find('.generate_thumbs_progress_thumbnails');
							var _content_progress_bar = _generate_content.find('.progress-bar');
							var _content_progress_i = 0;
							
							_content_progress_count = Number(_content_progress_count.val());
							
							_content_progress_thumbnails.each(function(index){
								jQuery.post(ajaxurl, {
									'action': 'ux_theme_option_process_generate_thumbs_ajax',
									'thumbnail_id': jQuery(this).val()
								}).done(function(process){
									if(process){
										_content_progress_i ++;
										_content_progress_bar.css({
											'width': (_content_progress_i / _content_progress_count) * 100 + '%'
										}).text(_content_progress_i + '/' + _content_progress_count);
									}
									if(_content_progress_i == _content_progress_count){
										setTimeout(function(){
											_this.button('reset');
										}, 10000);
									}
								});
							});
						}else{
							_generate_content.html('');
						}
					});
				break;
				
				default:
					window.location.href = _this_url;
				break;
			}
		});
    });
	
	//import demo data agree
	function ux_theme_modal_agree(data, _this){
		jQuery('.ux-theme-modal-agree').click(function(){
			jQuery('#ux-theme-modal').modal('hide');
			
			_this.button('loading');
			
			jQuery.post(ajaxurl, data).done(function(content){
				var wpbody_content = jQuery(content);
				
				if(wpbody_content.find('a[data-success]').length){
					_this.removeClass('btn-info').addClass('btn-success');
					_this.button('reset');
					_this.unbind('click');
					_this.text("Successfully imported!");
					ux_theme_process_demo_images();
				}else{
					_this.removeClass('btn-info').addClass('btn-danger'); 
					_this.text("Not successfully!");
					setTimeout(function(){
						_this.button('reset');
						_this.removeClass('btn-danger').addClass('btn-info');
						_this.text("Import Demo Data");
					}, 10000);
				}
			});
		});
	}
	
	//import demo data process images
	function ux_theme_process_demo_images(){
		jQuery.post(ajaxurl, {
			'action' : 'ux_theme_process_demo_images_ajax'
		});
	}
	
	//ux theme modal hidden event
	jQuery('#ux-theme-modal').on('hidden.bs.modal', function(){
		jQuery('#ux-theme-modal .modal-footer').find('button').each(function(){
            jQuery('#ux-theme-modal-body').html('');
			if(jQuery(this).is('.ux-theme-modal-agree')){
				jQuery(this).hide();
			}else{
				jQuery(this).show();
			}
        });
	});
	
	//theme load fonts
	function ux_theme_load_fonts(){
		jQuery.post(ajaxurl, {
			'action': 'ux_theme_option_font_ajax',
			'data': 'load-fonts'
		}).done(function(content){
			jQuery('.ux-theme-font-family').each(function(index, element){
				var _this = jQuery(this);
				_this.html(content);
				ux_theme_load_fonts_style();
			});
		});
	}
	
	//theme load fonts style
	function ux_theme_load_fonts_style(){
		jQuery('.ux-theme-font-family').each(function(index, element){
			var _this = jQuery(this);
			var _this_parents = _this.parents('.row');
			var _this_style = _this_parents.find('.ux-theme-font-style');
			
			_this.change(function(){
				jQuery.post(ajaxurl, {
					'action': 'ux_theme_option_font_ajax',
					'data': 'load-style',
					'font': _this.val()
				}).done(function(content){
					_this_style.html(content);
				});
			});
		});
		
		jQuery('.ux-theme-font-style').each(function(index, element){
            var _this = jQuery(this);
			var _this_parents = _this.parents('.theme-option-item');
			var _this_family = _this_parents.find('.ux-theme-font-family');
			
			if(_this_family.length > 0){
				if(_this_family.val() != '-1'){
					jQuery.post(ajaxurl, {
						'action': 'ux_theme_option_font_ajax',
						'data': 'load-style',
						'font': _this_family.val(),
						'selected': _this.data('value')
					}).done(function(content){
						_this.html(content);
					});
				}
			}
			
        });
	}
	ux_theme_load_fonts_style();
	
	//restore defaults
	jQuery('.restore_defaults').click(function(){
		var _this = jQuery(this);
		var _this_notice = _this.data('notice');
		
		if(confirm(_this_notice)){
			jQuery(this).text('Restoring...');
			jQuery.post(ajaxurl, {
				'action': 'ux_theme_option_restore'
			}).done(function(content){
				if(content == 'success'){
					window.location.href="admin.php?page=theme-option&message=restore"
				}
			});
		}
	});
	
	//ux theme image select
	jQuery('.ux-theme-image-select').each(function(index, element){
		var _this = jQuery(this);
		var _this_input = _this.find('[type=hidden]');
		var _this_name = _this.find('[name]').attr('data-class');
		var _this_control = jQuery('.theme-option-item [data-name=' + _this_name + ']');
		
		_this.delegate('li > a', 'click', function(){
			var _active_val = jQuery(this).attr('class');
			_this.find('li').removeClass('active');
			jQuery(this).parent('li').addClass('active');
			_this_input.val(_active_val);
			
			_this_control.each(function(){
                if(jQuery(this).data('value') == _active_val){
					jQuery(this).fadeIn();
				}else{
					jQuery(this).hide();
				}
            });
			
			return false;
		});
	});
	
	//theme load slider
	function ux_theme_load_slider(){
		jQuery('[name*=theme_meta_title_bar_slider_value]').each(function(index, element){
			var _this = jQuery(this);
			var _this_slider = _this.prev('[name*=theme_meta_title_bar_slider]');
			
			jQuery.post(ajaxurl, {
				'action': 'ux_theme_meta_slider_ajax',
				'data': 'load-slider',
				'slider': _this_slider.val(),
				'selected': _this.data('selected')
			}).done(function(content){
				_this.html(content);
			});
		});
	}
	ux_theme_load_slider();
	
	//theme slider change
	jQuery('[name*=theme_meta_title_bar_slider]').each(function(index, element){
        var _this = jQuery(this);
		
		_this.change(function(){
			var _this_select = _this.next('[name*=theme_meta_title_bar_slider_value]');
			_this_select.find('option:first').text('Loading...');
			jQuery.post(ajaxurl, {
				'action': 'ux_theme_meta_slider_ajax',
				'data': 'load-slider',
				'slider': _this.val(),
				'selected': _this_select.data('selected')
			}).done(function(content){
				_this_select.html(content);
			});
		});
    });
	
	//theme color select
	jQuery('.ux-theme-color').each(function(){
        var _this = jQuery(this);
		var _this_buttons = _this.find('button');
		var _this_input = _this.next('input:hidden');
		
		_this.delegate('button', 'click', function(){
			var _this_button = jQuery(this);
			var _this_button_val = _this_button.data('value');
			_this_buttons.find('span').hide();
			_this_button.find('span').fadeIn();
			_this_input.val(_this_button_val);
		});
		
		_this_buttons.each(function(){
            var _this_button = jQuery(this);
			var _this_button_val = _this_button.data('value');
			if(_this_button_val == _this_input.val()){
				_this_button.find('span').show();
			}
        });
    });
	
	//theme checkbox group
	jQuery('.ux-theme-checkbox-group').each(function(){
        var _this = jQuery(this);
		var _this_checkbox = _this.find('[type=checkbox]');
		
		_this_checkbox.iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%' // optional
		});
		
    });
	
	//theme gallery select images
	jQuery('.ux-theme-gallery-select-images').click(function(){
		var _this = jQuery(this);
		var _gallery_select = jQuery('.ux-theme-gallery-select');
		var _thumbnail_id, _thumbnail_image, _thumbnail_thumb;
		var _new_item = '';
		
		var frame = wp.media({
			title : 'Select Images',
			multiple : true,
			library : { type : 'image'},
			button : { text : 'Insert' }
		});
		
		frame.on('select',function() {
			
			attachments = frame.state().get('selection').toJSON();
			
			for(var i=0; i<attachments.length; i++){
				_thumbnail_id = attachments[i]['id'];
				_thumbnail_image = attachments[i]['url'];
				
				if(attachments[i].sizes.thumbnail){
					_thumbnail_thumb = attachments[i].sizes.thumbnail.url;
				}else{
					_thumbnail_thumb = attachments[i].sizes.full.url;
				}
				
				_new_item += '<li><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button><a href="#" class="thumbnail"><span class="border"></span><img src="' + _thumbnail_thumb + '" /></a><input type="hidden" name="ux_theme_meta[theme_meta_portfolio][]" value="' + _thumbnail_id + '" /></li>';
				
			}
			
			_gallery_select.find('.nav').append(_new_item);
			
			ux_theme_gallery_select();
		});
			
		frame.open();
	});
	
	//theme gallery select
	function ux_theme_gallery_select(){
		jQuery('.ux-theme-gallery-select .nav li').each(function(index){
			var _this = jQuery(this);
			var _this_img = _this.find('img');
			var _this_thumbnail = _this.find('.thumbnail');
			var _this_parent = _this.parent('.nav');
			var _this_parents = _this.parents('.ux-theme-gallery-select');
			
			var _this_num = Number(index + 1);
			var _this_width = Number(_this.width());
			var _this_height = _this_width * 0.65;
			var _this_img_width = Number(_this_img.width());
			var _this_img_height = Number(_this_img.height());
			var _this_parent_width = Number(_this_parent.width());
			
			/*_this.height(_this_height);
			if(_this_num % 4){
				_this.css({'margin-right': '2%'})
			}else{
				_this.css({'margin-right': 0})
			}
			
			if(_this_img_width > _this_width){
				_this_img.css({'left': - ((_this_img_width - _this_width) / 2)});
			}
			
			if(_this_img_height > _this_height){
				_this_img.css({'top': - ((_this_img_height - _this_height) / 2)});
			}*/
			
			_this.delegate('button', 'click', function(){
				_this.fadeOut(function(){
					_this.remove();
					ux_theme_gallery_select();
				});
			});
			
			_this_thumbnail.click(function(){return false});
			
			_this_parent.sortable({
				change: function(){
					ux_theme_gallery_select();
				},
				stop: function(){
					ux_theme_gallery_select();
				}
			});
		});
	}
	ux_theme_gallery_select();
	
	//theme post formats select function
	function ux_theme_post_formats_select(_this_key, event){
		jQuery('.ux-theme-meta-box').each(function(){
			var _this = jQuery(this);
			var _this_format = _this.data('format');
			var _this_children = _this.find('[data-format]');
			var _this_children_format;
			
			if(_this_format){
				if(_this_format == _this_key){
					_this.slideDown();
				}else{
					_this.slideUp();
				}
			}
			
			_this_children.each(function(){
                _this_children_format = jQuery(this).data('format');
				
				if(_this_children_format == _this_key){
					jQuery(this).fadeIn();
				}else{
					jQuery(this).fadeOut();
				}
				
				ux_theme_switch_control();
            });
			
			if(_this_key != 'gallery'){
				jQuery('.theme-option-item[data-super]').show();
			}
		});
	}
	
	//theme post formats select
	jQuery('#post-formats-select [type=radio]').each(function(index, element){
        var _this = jQuery(this);
		var _this_id = _this.attr('id');
		var _this_parents = _this.parents('#post-formats-select');
		var _this_key;
		
		_this_key = _this_id.replace('post-format-', '');
		if(_this.is(':checked')){
			ux_theme_post_formats_select(_this_key, 'no');
		}
		
		/*if(_this_id == 'post-format-gallery'){
			_this_parents.find('[for=post-format-gallery]').text('Portfolio');
		}*/
		
		_this.click(function(){
			ux_theme_post_formats_select(_this_key, 'click');
			ux_theme_gallery_select();
		});
    });
	
	//theme property
	var _property_item = jQuery('.property-item');
	if(_property_item.length){
		_property_item.each(function(){
            var _this = jQuery(this);
			var _this_parents = _this.parent();
			var _this_add = _this.find('.property-add');
			var _this_remove = _this.find('.property-remove');
			var _this_last, _this_clone;
			
			_this_add.click(function(){
				_this_last = _this_parents.find('.property-item:last');
				_this_clone = _this_last.clone();
				_this_last.after(_this_clone);
				_this_clone.find('.property-add').addClass('hidden');
				_this_clone.find('.property-remove').removeClass('hidden').click(function(){
					jQuery(this).parents('.property-item').remove();
				});
			});
			
			_this_remove.click(function(){
				_this.remove();
			});
        });
	}
	
	//ux theme list layout builder
	var _layout_builder = jQuery('.ux-theme-layout-builder');
	if(_layout_builder.length){
		_layout_builder.each(function(index, element){
			var _this = jQuery(this);
			var _this_click = _this.find('a');
			var _this_parents = _this.parent();
			var _this_add = _this.find('.layout-builder-add');
			var _this_remove = _this.find('.layout-builder-remove');
			
			_layout_builder_event('active', _this_click);
			_layout_builder_event('add', _this_add);
			_layout_builder_event('remove', _this_remove);
		});
		
		jQuery('form#post').bind('submit', function(){
			_layout_builder_field_val();
		});
	}
	
	//ux theme list layout builder field val
	function _layout_builder_field_val(){
		jQuery('.ux-theme-layout-builder').each(function(index){
            var _this = jQuery(this);
			var _this_input = _this.find('input');
			var _this_name = _this.data('thisname');
			
			_this_input.attr('name', 'ux_theme_meta['+_this_name+']['+index+']');
        });
	}
	
	//ux theme list layout builder event
	function _layout_builder_event(event, el){
		el.click(function(){
			var _this = jQuery(this);
			var _this_parent = _this.parents('.ux-theme-layout-builder');
			var _this_parents = _this_parent.parent();
			var _this_input = _this_parent.find('input');
			var _this_val = jQuery(this).attr('class');
			var _this_last, _this_clone, _this_click, _this_add, _this_remove;
			
			switch(event){
				case 'active':
					_this_parent.find('li').removeClass('active');
					_this.parent('li').addClass('active');
					_this_input.val(_this_val);
				break;
				
				case 'add':
					_this_last = jQuery('.ux-theme-layout-builder:last');
					_this_clone = _this_last.clone();
					_this_last.after(_this_clone);
					_this_click = _this_clone.find('a');
					_this_add = _this_clone.find('.layout-builder-add');
					_this_remove = _this_clone.find('.layout-builder-remove');
					_this_clone.find('.layout-builder-add').addClass('hidden');
					_this_clone.find('.layout-builder-remove').removeClass('hidden').click(function(){
						jQuery(this).parents('.ux-theme-layout-builder').remove();
					});
					
					_layout_builder_event('active', _this_click);
					_layout_builder_event('add', _this_add);
					_layout_builder_event('remove', _this_remove);
				break;
				
				case 'remove':
					_this_parent.remove();
				break;
			}
			
			return false;
		});
		
		
	}
	
	if(jQuery('#ux-option-interface .theme-option-item .row').length){
		jQuery('#ux-option-interface .theme-option-item .row').each(function(){
            var _select = jQuery(this).find('select');
			
			_select.change(function(){
				var _this = jQuery(this);
				var _this_name = _this.attr('data-class');
				var _this_control = jQuery('.theme-option-item [data-name=' + _this_name + ']');
				var _this_val = _this.val();
				
				_this_control.each(function(){
					var _control = jQuery(this);
					var _control_val = _control.attr('data-value');
					if(_control_val == _this_val){
						_control.show();
					}else{
						_control.hide();
					}
				});
				
				//ux_theme_switch_children(_this_name, _this_val);
			});
        });
	}
	
	//window resize
	jQuery(window).resize(function(){
		ux_theme_gallery_select();
	}); 
	
});

jQuery(window).load(function(){
	var adminmenuwrap = jQuery('#adminmenuwrap');
	var ux_theme_modal = jQuery('#ux-theme-modal');
	
	ux_theme_modal.css('margin-left', adminmenuwrap.width());
});
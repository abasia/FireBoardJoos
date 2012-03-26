var $j = jQuery.noConflict();
$j.fn.editInPlace = function(options) {
	var settings = {
		url: "",
		params: "",
		field_type: "text",
		select_options: "",
		textarea_cols:  "25",
		textarea_rows:  "10",
		bg_over: "#ffc",
		bg_out:  "transparent",
		saving_text:   "Ждите...",
		saving_image:  "",
		default_text:  "(Текст не введен!)",
		select_text: "Выберите значение",
		value_required: null,
		element_id:    "element_id",
		update_value:  "update_value",
		original_html: "original_html",
		save_button:   '<input type="submit" class="inplace_save" value="OK"/>',
		cancel_button: '<input type="submit" class="inplace_cancel" value="X"/>',
		callback: null,
		success: null,
		error: function(request){
			alert("Ошибка записи: " + request.responseText || 'неизвестная ошибка');
		}
	};
	if(options) {
		$j.extend(settings, options);
	}
	if(settings.saving_image != ""){
		var loading_image = new Image();
		loading_image.src = settings.saving_image;
	}
	String.prototype.trim = function() {
		return this.replace(/^\s+/, '')
							 .replace(/\s+$/, '');
	};
	String.prototype.escape_html = function() {
		return this.replace(/&/g, "&amp;")
							 .replace(/</g, "&lt;")
							 .replace(/>/g, "&gt;")
							 .replace(/"/g, "&quot;");
  };
	return this.each(function(){
		if($j(this).html() == "") $j(this).html(settings.default_text);
		var editing = false;
		var original_element = $j(this);
		var click_count = 0;
		$j(this)
		.mouseover(function(){
			$j(this).css("background", settings.bg_over);
		})
		.mouseout(function(){
			$j(this).css("background", settings.bg_out);
		})
		.click(function(){
			click_count++;
			if(!editing)
			{
				editing = true;
				var original_html = $j(this).html();
				var buttons_code  = settings.save_button + ' ' + settings.cancel_button;
				if (original_html == settings.default_text) $j(this).html('');
				if (settings.field_type == "textarea")
				{
					var use_field_type = '<textarea name="inplace_value" class="inplace_field" rows="' + settings.textarea_rows +
										 '" cols="' + settings.textarea_cols + '">' + $j(this).text().trim().escape_html() +
										 '</textarea>';
				}
				else if(settings.field_type == "text")
				{
					var use_field_type = '<input type="text" name="inplace_value" class="inplace_field" value="' +
											$j(this).text().trim().escape_html() + '" />';
				}
				else if(settings.field_type == "select")
				{
					var optionsArray = settings.select_options.split(',');
					var use_field_type = '<select name="inplace_value" class="inplace_field"><option value="">' + settings.select_text + '</option>';
						for(var i=0; i<optionsArray.length; i++){
							var optionsValuesArray = optionsArray[i].split(':');
							var use_value = optionsValuesArray[1] || optionsValuesArray[0];
							var selected = use_value == original_html ? 'selected="selected" ' : '';
							use_field_type += '<option '+selected+'value="'+use_value.trim().escape_html()+'">'+optionsValuesArray[0].trim().escape_html()+'</option>';
                        }
						use_field_type += '</select>';
				}
				$j(this).html('<form class="inplace_form" style="display: inline; margin: 0; padding: 0;">' + use_field_type + ' ' + buttons_code + '</form>');
			}
			if(click_count == 1)
			{
				original_element.children("form").children(".inplace_field").focus().select();
				$j(document).keyup(function(event){
				    if (event.keyCode == 27) {
				        editing = false;
						click_count = 0;
						original_element.css("background", settings.bg_out);
						original_element.html(original_html);
						return false;
				    }
				});
				original_element.children("form").children(".inplace_cancel").click(function(){
					editing = false;
					click_count = 0;
					original_element.css("background", settings.bg_out);
					original_element.html(original_html);
					return false;
				});
				original_element.children("form").children(".inplace_save").click(function(){
					original_element.css("background", settings.bg_out);
					var new_html = $j(this).parent().children(0).val();
					if(settings.saving_image != ""){
						var saving_message = '<img src="' + settings.saving_image + '" alt="Ждите..." />';
					} else {
						var saving_message = settings.saving_text;
					}
					original_element.html(saving_message);
					if(settings.params != ""){
						settings.params = "&" + settings.params;
					}
					if(settings.callback) {
						html = settings.callback(original_element.attr("id"), new_html, original_html, settings.params);
						editing = false;
						click_count = 0;
						if (html) {
							original_element.html(html || new_html);
						} else {
							alert("Ошибка сохранения: " + new_html);
							original_element.html(original_html);
						}
					} else if (settings.value_required && new_html == "") {
						editing = false;
						click_count = 0;
						original_element.html(original_html);
						alert("Введите значение!");
					} else {
						$j.ajax({
							url: settings.url,
							type: "POST",
							data: settings.update_value + '=' + new_html + '&' + settings.element_id + '=' + 
									original_element.attr("id") + settings.params + 
									'&' + settings.original_html + '=' + original_html,
							dataType: "html",
							complete: function(request){
								editing = false;
								click_count = 0;
							},
							success: function(html){
								var new_text = html || settings.default_text;
								original_element.html(new_text);
								if (settings.success) settings.success(html, original_element);
							},
							error: function(request) {
								original_element.html(original_html);
								if (settings.error) settings.error(request, original_element);
							}
						});
					}
					return false;
				});
			}
		});
	});
};
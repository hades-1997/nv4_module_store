/**
 * @Project NUKEVIET 4.x
 * @Author Thuong Mai So <hoangnt@nguyenvan.vn>
 * @Copyright (C) 2018 Thuong Mai So. All rights reserved
 * @License: Not free read more http://nukeviet.systems
 * @Createdate Fri, 10 Aug 2018 07:54:45 GMT
 */

 
 function get_alias(mod, id) {
	var title = strip_tags(document.getElementById('name').value);
	if (title != '') {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(), 'title=' + encodeURIComponent(title) + '&mod=' + mod + '&id=' + id, function(res) {
			if (res != "") {
				document.getElementById('alias').value = res;
			} else {
				document.getElementById('alias').value = '';
			}
		});
	}
	return false;
}

function formatRepo (repo) {
	console.log(repo);
	if (repo.loading) return repo.text;
	return repo.title;
}

function formatRepoSelection (repo) {
	return '';
}
function formatRepoSelection2 (repo) {
	return repo.title;
}
function warehouse_id_select2 (current) {
	if(current == null) current = 0;
	$("#warehouse_id").select2({
	        language: "vi",
	        ajax: {
		        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax',
	            dataType: 'json',
	            delay: 0,
	            data: function (params) {
	            	
                	return {
					  mod : "warehouse_list",
					  store_id : current
              		};
              	},
	            processResults: function (data, params) {
	                return {
	                    results: data
	                };
	            },
		        cache: true
	        },
	        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
	        minimumInputLength: 0,
	        templateResult: formatRepo, // omitted for brevity, see the source of this page
	        templateSelection: formatRepoSelection2 // omitted for brevity, see the source of this page
	    });
}
function warehouse_id_select2_new (current) {
	if(current == null) current = 0;
	$("#warehouse_id_new").select2({
	        language: "vi",
	        ajax: {
		        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax',
	            dataType: 'json',
	            delay: 0,
	            data: function (params) {
	            	
                	return {
					  mod : "warehouse_list",
					  store_id : current
              		};
              	},
	            processResults: function (data, params) {
	                return {
	                    results: data
	                };
	            },
		        cache: true
	        },
	        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
	        minimumInputLength: 0,
	        templateResult: formatRepo, // omitted for brevity, see the source of this page
	        templateSelection: formatRepoSelection2 // omitted for brevity, see the source of this page
	    });
}
function unit_id_select2 (current) {
	if(current == null) current = 0;
	$("#sale_unit").select2({
	        language: "vi",
	        ajax: {
		        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax',
	            dataType: 'json',
	            delay: 0,
	            data: function (params) {
	            	
                	return {
					  mod : "unit_list",
					  unit_id : current
              		};
              	},
	            processResults: function (data, params) {
	                return {
	                    results: data
	                };
	            },
		        cache: true
	        },
	        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
	        minimumInputLength: 0,
	        templateResult: formatRepo, // omitted for brevity, see the source of this page
	        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
	 });
	 $("#purchase_unit").select2({
	        language: "vi",
	        ajax: {
		        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax',
	            dataType: 'json',
	            delay: 0,
	            data: function (params) {
	            	
                	return {
					  mod : "unit_list",
					  unit_id : current
              		};
              	},
	            processResults: function (data, params) {
	                return {
	                    results: data
	                };
	            },
		        cache: true
	        },
	        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
	        minimumInputLength: 0,
	        templateResult: formatRepo, // omitted for brevity, see the source of this page
	        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
	    });
}
function add_product(current){
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax&nocache=' + new Date().getTime(),  'mod=products_items&id=' + current, function(res) {
		console.log(res);$('.ui-sortable').append(
			'<tr>' +
				'<td>' + res.title + '(' + res.code +')<input type="hidden" name="product_id[]" value="' + res.id +'"><input type="hidden" name="product_code[]" value="' + res.code +'"><input type="hidden" name="product_name[]" value="' + res.title +'"></td>' +
				'<td>' + '<input type="text" name="product_expried[]" value="">' +'</td>' +
				'<td>' + res.cost +
				' <input type="hidden" name="product_net_cost[]" value="' + res.cost  +'">' + 
				' <input type="hidden" name="product_unit_cost[]" value="' + res.cost  +'">' + 
				' <input type="hidden" name="product_real_unit_cost[]" value="' + res.cost  +'">' + 
				'</td>' +
				'<td><input type="text" name="product_base_quantity[]" value="' + res.quantity +'">' +
				'<input type="hidden" name="product_unit[]" value="' + res.purchase_unit +'">' +
				'</td>' +
				'<td><input type="hidden" name="product_discount[]" value="' + res.discount +'">' + res.discount +'</td>' +
				'<td><input type="hidden" name="product_tax_rate[]" value="' + res.tax_id +'">' +
					'<input type="hidden" name="product_tax[]" value="' + res.tax +'">' +
					'<input type="hidden" name="product_cost_tax[]" value="' + res.cost_tax +'">' +
					'(' + res.tax +'%) <br> ' + res.cost_tax +'</td>' +
				'<td><input type="hidden" name="product_total[]" value="' + res.total +'">' + res.total +'</td>' +
				'<td>' + '' +'</td>' +
			'</tr>'
		);	
	}); 
}


$(document).ready(function() {
    $("#products_id").select2({
        language: "vi",
        ajax: {
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                  return {
                      q: params.term, // search term
                      page: params.page,
					  mod: "products_list_material"
                  };
              },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
        cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatRepo, // omitted for brevity, see the source of this page
        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });
	$("#products_id").on('change', function () {
	   var current = $("#products_id").select2("val");
		add_product(current);
	 });
	$("#products_export_id").select2({
        language: "vi",
        ajax: {
        url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=ajax',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                  return {
                      q: params.term, // search term
                      page: params.page,
					  mod: "products_list"
                  };
              },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
        cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatRepo, // omitted for brevity, see the source of this page
        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });
	$("#products_export_id").on('change', function () {
	   var current = $("#products_export_id").select2("val");
		add_product(current);
	 });
	$("#select2-products_id-results .select2-results__option--highlighted").click(function() {
		var current = $("#products_id").select2("val");
		add_product(current);
	});
	$("#store_id").select2();
	var store_id = $("#store_session").val();
	var store_id_new = $("#store_session_new").val();
	warehouse_id_select2 (store_id);
	warehouse_id_select2_new (store_id_new);
    $("#store_id").on('change', function () {
		 var current = $("#store_id").select2("val");
		 $("#warehouse_id").val(null).trigger("change");
		 //warehouse_id_select2 (current);
		$.ajax({
    		type: "GET",
    		url: script_name + '?' + nv_name_variable + '=storehouse&' + nv_fc_variable + '=ajax&mod=set_session_store_id&session_store_id=' + current,
        	dataType: 'json',
        	data: function (params) {
                 return {
					 mod: 'set_session_store_id',
					 session_store_id:current
                 };
             },
            success: function (data, params) {
            	$("#store_session").val(data.session_store_id);
            	//warehouse_id_select2 (data.session_store_id);
            	console.log(data);
            	window.location.href = window.location.href;
            }
    	});
    	
	});
	$("#store_id_new").on('change', function () {
		 var current = $("#store_id_new").select2("val");
		 $("#warehouse_id_new").val(null).trigger("change");
		 warehouse_id_select2_new (current);
		
	 });
	  $("#formgetuid").submit(function() {
        var a = $(this).attr("action");
        b = $(this).serialize();
        a = a + "&" + b + "&submit";
        $("#formgetuid input, #formgetuid select").attr("disabled", "disabled");
        $.ajax({
            type : "GET",
            url : a,
            success : function(c) {
                $("#resultdata").html(c);
                $("#formgetuid input, #formgetuid select").removeAttr("disabled")
            }
        });
        return !1
    });
    var unit_id = $("#unit").val();
    console.log(unit_id);
    unit_id_select2 (unit_id);
});


!function(e){"use strict";function t(e,t){if(this.createTextRange){var a=this.createTextRange();a.collapse(!0),a.moveStart("character",e),a.moveEnd("character",t-e),a.select()}else this.setSelectionRange&&(this.focus(),this.setSelectionRange(e,t))}function a(e){var t=this.value.length;if(e="start"==e.toLowerCase()?"Start":"End",document.selection){var a,i,n,l=document.selection.createRange();return a=l.duplicate(),a.expand("textedit"),a.setEndPoint("EndToEnd",l),i=a.text.length-l.text.length,n=i+l.text.length,"Start"==e?i:n}return"undefined"!=typeof this["selection"+e]&&(t=this["selection"+e]),t}var i={codes:{46:127,188:44,109:45,190:46,191:47,192:96,220:92,222:39,221:93,219:91,173:45,187:61,186:59,189:45,110:46},shifts:{96:"~",49:"!",50:"@",51:"#",52:"$",53:"%",54:"^",55:"&",56:"*",57:"(",48:")",45:"_",61:"+",91:"{",93:"}",92:"|",59:":",39:'"',44:"<",46:">",47:"?"}};e.fn.number=function(n,l,s,r){r="undefined"==typeof r?",":r,s="undefined"==typeof s?".":s,l="undefined"==typeof l?0:l;var u="\\u"+("0000"+s.charCodeAt(0).toString(16)).slice(-4),h=new RegExp("[^"+u+"0-9]","g"),o=new RegExp(u,"g");return n===!0?this.is("input:text")?this.on({"keydown.format":function(n){var u=e(this),h=u.data("numFormat"),o=n.keyCode?n.keyCode:n.which,c="",v=a.apply(this,["start"]),d=a.apply(this,["end"]),p="",f=!1;if(i.codes.hasOwnProperty(o)&&(o=i.codes[o]),!n.shiftKey&&o>=65&&90>=o?o+=32:!n.shiftKey&&o>=69&&105>=o?o-=48:n.shiftKey&&i.shifts.hasOwnProperty(o)&&(c=i.shifts[o]),""==c&&(c=String.fromCharCode(o)),8!=o&&45!=o&&127!=o&&c!=s&&!c.match(/[0-9]/)){var g=n.keyCode?n.keyCode:n.which;if(46==g||8==g||127==g||9==g||27==g||13==g||(65==g||82==g||80==g||83==g||70==g||72==g||66==g||74==g||84==g||90==g||61==g||173==g||48==g)&&(n.ctrlKey||n.metaKey)===!0||(86==g||67==g||88==g)&&(n.ctrlKey||n.metaKey)===!0||g>=35&&39>=g||g>=112&&123>=g)return;return n.preventDefault(),!1}if(0==v&&d==this.value.length?8==o?(v=d=1,this.value="",h.init=l>0?-1:0,h.c=l>0?-(l+1):0,t.apply(this,[0,0])):c==s?(v=d=1,this.value="0"+s+new Array(l+1).join("0"),h.init=l>0?1:0,h.c=l>0?-(l+1):0):45==o?(v=d=2,this.value="-0"+s+new Array(l+1).join("0"),h.init=l>0?1:0,h.c=l>0?-(l+1):0,t.apply(this,[2,2])):(h.init=l>0?-1:0,h.c=l>0?-l:0):h.c=d-this.value.length,h.isPartialSelection=v==d?!1:!0,l>0&&c==s&&v==this.value.length-l-1)h.c++,h.init=Math.max(0,h.init),n.preventDefault(),f=this.value.length+h.c;else if(45!=o||0==v&&0!=this.value.indexOf("-"))if(c==s)h.init=Math.max(0,h.init),n.preventDefault();else if(l>0&&127==o&&v==this.value.length-l-1)n.preventDefault();else if(l>0&&8==o&&v==this.value.length-l)n.preventDefault(),h.c--,f=this.value.length+h.c;else if(l>0&&127==o&&v>this.value.length-l-1){if(""===this.value)return;"0"!=this.value.slice(v,v+1)&&(p=this.value.slice(0,v)+"0"+this.value.slice(v+1),u.val(p)),n.preventDefault(),f=this.value.length+h.c}else if(l>0&&8==o&&v>this.value.length-l){if(""===this.value)return;"0"!=this.value.slice(v-1,v)&&(p=this.value.slice(0,v-1)+"0"+this.value.slice(v),u.val(p)),n.preventDefault(),h.c--,f=this.value.length+h.c}else 127==o&&this.value.slice(v,v+1)==r?n.preventDefault():8==o&&this.value.slice(v-1,v)==r?(n.preventDefault(),h.c--,f=this.value.length+h.c):l>0&&v==d&&this.value.length>l+1&&v>this.value.length-l-1&&isFinite(+c)&&!n.metaKey&&!n.ctrlKey&&!n.altKey&&1===c.length&&(p=d===this.value.length?this.value.slice(0,v-1):this.value.slice(0,v)+this.value.slice(v+1),this.value=p,f=v);else n.preventDefault();f!==!1&&t.apply(this,[f,f]),u.data("numFormat",h)},"keyup.format":function(i){var n,s=e(this),r=s.data("numFormat"),u=i.keyCode?i.keyCode:i.which,h=a.apply(this,["start"]),o=a.apply(this,["end"]);0!==h||0!==o||189!==u&&109!==u||(s.val("-"+s.val()),h=1,r.c=1-this.value.length,r.init=1,s.data("numFormat",r),n=this.value.length+r.c,t.apply(this,[n,n])),""===this.value||(48>u||u>57)&&(96>u||u>105)&&8!==u&&46!==u&&110!==u||(s.val(s.val()),l>0&&(r.init<1?(h=this.value.length-l-(r.init<0?1:0),r.c=h-this.value.length,r.init=1,s.data("numFormat",r)):h>this.value.length-l&&8!=u&&(r.c++,s.data("numFormat",r))),46!=u||r.isPartialSelection||(r.c++,s.data("numFormat",r)),n=this.value.length+r.c,t.apply(this,[n,n]))},"paste.format":function(t){var a=e(this),i=t.originalEvent,n=null;return window.clipboardData&&window.clipboardData.getData?n=window.clipboardData.getData("Text"):i.clipboardData&&i.clipboardData.getData&&(n=i.clipboardData.getData("text/plain")),a.val(n),t.preventDefault(),!1}}).each(function(){var t=e(this).data("numFormat",{c:-(l+1),decimals:l,thousands_sep:r,dec_point:s,regex_dec_num:h,regex_dec:o,init:this.value.indexOf(".")?!0:!1});""!==this.value&&t.val(t.val())}):this.each(function(){var t=e(this),a=+t.text().replace(h,"").replace(o,".");t.number(isFinite(a)?+a:0,l,s,r)}):this.text(e.number.apply(window,arguments))};var n=null,l=null;e.isPlainObject(e.valHooks.text)?(e.isFunction(e.valHooks.text.get)&&(n=e.valHooks.text.get),e.isFunction(e.valHooks.text.set)&&(l=e.valHooks.text.set)):e.valHooks.text={},e.valHooks.text.get=function(t){var a,i=e(t),l=i.data("numFormat");return l?""===t.value?"":(a=+t.value.replace(l.regex_dec_num,"").replace(l.regex_dec,"."),(0===t.value.indexOf("-")?"-":"")+(isFinite(a)?a:0)):e.isFunction(n)?n(t):void 0},e.valHooks.text.set=function(t,a){var i=e(t),n=i.data("numFormat");if(n){var s=e.number(a,n.decimals,n.dec_point,n.thousands_sep);return e.isFunction(l)?l(t,s):t.value=s}return e.isFunction(l)?l(t,a):void 0},e.number=function(e,t,a,i){i="undefined"==typeof i?"1000"!==new Number(1e3).toLocaleString()?new Number(1e3).toLocaleString().charAt(1):"":i,a="undefined"==typeof a?new Number(.1).toLocaleString().charAt(1):a,t=isFinite(+t)?Math.abs(t):0;var n="\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4),l="\\u"+("0000"+i.charCodeAt(0).toString(16)).slice(-4);e=(e+"").replace(".",a).replace(new RegExp(l,"g"),"").replace(new RegExp(n,"g"),".").replace(new RegExp("[^0-9+-Ee.]","g"),"");var s=isFinite(+e)?+e:0,r="",u=function(e,t){return""+ +(Math.round((""+e).indexOf("e")>0?e:e+"e+"+t)+"e-"+t)};return r=(t?u(s,t):""+Math.round(s)).split("."),r[0].length>3&&(r[0]=r[0].replace(/\B(?=(?:\d{3})+(?!\d))/g,i)),(r[1]||"").length<t&&(r[1]=r[1]||"",r[1]+=new Array(t-r[1].length+1).join("0")),r.join(a)}}(jQuery);

function user_validForm(a) {
    $('[type="submit"] .fa', $(a)).toggleClass('hidden');
    $('[type="submit"]', $(a)).prop('disabled', true);
    $.ajax({
        type: $(a).prop("method"),
        cache: !1,
        url: $(a).prop("action"),
        data: $(a).serialize(),
        dataType: "json",
        success: function(b) {
            $('[type="submit"] .fa', $(a)).toggleClass('hidden');
            $('[type="submit"]', $(a)).prop('disabled', false);
            if( b.status == "error" ) {
                alert(b.mess);
                $("[name=\"" + b.input + "\"]", a).focus();
            } else {
                location_href = script_name + "?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable;
                if( b.admin_add == "yes" ) {
                    if (confirm( b.mess )) {
                        location_href = script_name + "?" + nv_name_variable + "=authors&" + nv_fc_variable + '=add&userid=' + b.username;
                    }
                }
                window.location.href = location_href;
            }
        }
    });
    return false
}
function nv_genpass() {
    $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=user_add&nocache=' + new Date().getTime(), 'nv_genpass=1', function(res) {
        $("input[name='password1']").val(res);
        $("input[name='password2']").val(res);
    });
    return;
}

$.toggleShowPassword = function (options) {
    var settings = $.extend({
        field: "#password",
        control: "#toggle_show_password"
    }, options);

    var control = $(settings.control);
    var field = $(settings.field);

    control.bind('click', function () {
        if (control.is(':checked')) {
            field.attr('type', 'text');
        } else {
            field.attr('type', 'password');
        }
    });
};

function nv_check_form(OForm) {
    var f_method = $("#f_method").val();
    var f_value = $("#f_value").val();
    if (f_method != '' && f_value != '') {
        OForm.submit();
    }
    return false;
}


$(document).ready(function() {
    // List user main
    $('#mainusersaction').click(function() {
        $(this).prop('disabled', true);
        nv_main_action($(this));
    });

    // Edit user
    $("#btn_upload").click(function() {
        nv_open_browse( nv_base_siteurl  + "index.php?" + nv_name_variable  + "=" + nv_module_name + "&" + nv_fc_variable  + "=avatar/opener", "NVImg", 650, 430, "resizable=no,scrollbars=1,toolbar=no,location=no,status=no");
        return false;
    });
    $('#current-photo-btn').click(function() {
        $('#current-photo').hide();
        $('#photo_delete').val('1');
        $('#change-photo').show();
    });
    $('#imageresource').click(function() {
        $('#current-photo-btn').click();
        $("#btn_upload").click();
    });

    if ($.fn.validate){
        $('#form_user').validate({
            rules : {
                username : {
                    minlength : 5
                }
            }
        });

    }
    if ($.fn.datepicker){
        $(".datepicker").datepicker({
            showOn : "both",
            dateFormat : "dd/mm/yy",
            changeMonth : true,
            changeYear : true,
            showOtherMonths : true,
            buttonImage : nv_base_siteurl + "assets/images/calendar.gif",
            buttonImageOnly : true,
            yearRange: "-90:+90"
        });
        $("#birthday").datepicker({
            showOn : "both",
            dateFormat : "dd/mm/yy",
            changeMonth : true,
            changeYear : true,
            showOtherMonths : true,
            buttonImage : nv_base_siteurl + "assets/images/calendar.gif",
            buttonImageOnly : true,
            yearRange: "-99:+0",
            beforeShow: function() {
                setTimeout(function(){
                    $('.ui-datepicker').css('z-index', 999999999);
                }, 0);
            }
        });
    }

    $('[name="group[]"]').change(function(){
        control_theme_groups()
    })
    $('[name="is_official"]').change(function(){
        control_theme_groups()
    })

    // Export user
    $("input[name=data_export]").click(function() {
        $("input[name=data_export]").attr("disabled", "disabled");
        $('#users').html('<center>' + export_note + '<br /><br /><img src="' + nv_base_siteurl + 'assets/images/load_bar.gif" alt="" /></center>');
        nv_data_export(1);
    });

    // Get userid
    $("#resultdata").delegate("thead a,.generatePage a", "click", function(e) {
        e.preventDefault()
        $("#resultdata").load($(this).attr("href"))
    });
    if ($.fn.datepicker){
        $("#last_loginfrom,#last_loginto,#regdatefrom,#regdateto").datepicker({
            showOn : "both",
            dateFormat : "dd.mm.yy",
            changeMonth : true,
            changeYear : true,
            showOtherMonths : true,
            buttonText : '',
            showButtonPanel : true,
            showOn : 'focus'
        });
    }
    $("#formgetuid").submit(function() {
        var a = $(this).attr("action");
        b = $(this).serialize();
        a = a + "&" + b + "&submit";
        $("#formgetuid input, #formgetuid select").attr("disabled", "disabled");
        $.ajax({
            type : "GET",
            url : a,
            success : function(c) {
                $("#resultdata").html(c);
                $("#formgetuid input, #formgetuid select").removeAttr("disabled")
            }
        });
        return !1
    });

    // User field
    $("input[name=field_type]").click(function() {
        var field_type = $("input[name='field_type']:checked").val();
        $("#textfields").hide();
        $("#numberfields").hide();
        $("#datefields").hide();
        $("#choicetypes").hide();
        $("#choiceitems").hide();
        $("#choicesql").hide();
        $("#editorfields").hide();
        if (field_type == 'textbox' || field_type == 'textarea' || field_type == 'editor') {
            if (field_type == 'textbox') {
                $("#li_alphanumeric").show();
                $("#li_email").show();
                $("#li_url").show();
            } else {
                $("#li_alphanumeric").hide();
                $("#li_email").hide();
                $("#li_url").hide();
                if (field_type == 'editor') {
                    $("#editorfields").show();
                }
            }
            $("#textfields").show();
        } else if (field_type == 'number') {
            $("#numberfields").show();
        } else if (field_type == 'date') {
            $("#datefields").show();
        } else {
            $("#choicetypes").show();
            $("#textfields").hide();
            $("#numberfields").hide();
            $("#datefields").hide();
            nv_users_check_choicetypes("select[name=choicetypes]");
        }
    });
    $("input[name=required],input[name=show_register]").click(function() {
        if ($("input[name='required']:checked").val() == 1) {
            $("input[name=show_register]").prop("checked", true);
        }
    });
    $("input[name=match_type]").click(function() {
        $("input[name=match_regex]").attr('disabled', 'disabled');
        $("input[name=match_callback]").attr('disabled', 'disabled');
        var match_type = $("input[name='match_type']:checked").val();
        var max_length = $("input[name=max_length]").val();
        if (match_type == 'number') {
            if (max_length == 255) {
                $("input[name=max_length]").val(11);
            }
        } else if (max_length == 11) {
            $("input[name=max_length]").val(255);
        }
        if (match_type == 'regex') {
            $("input[name=match_regex]").removeAttr("disabled");
        } else if (match_type == 'callback') {
            $("input[name=match_callback]").removeAttr("disabled");
        }
    });

    $("input[name=current_date]").click(function() {
        nv_load_current_date();
    });
    $("select[name=choicetypes]").change(function() {
        nv_users_check_choicetypes(this);
    });

    // Group
     $("[name='browse-image']").click(function(e) {
        e.preventDefault();
        var area = $(this).data('area'),
            path = $(this).data('path'),
            currentpath = $(this).data('currentpath'),
            type = "image"

        nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
    });
    $('[data-toggle="opendatepicker"]').click(function(e) {
        e.preventDefault();
        var wrp = $(this).parent().parent();
        wrp.find('[type="text"]').focus();
    });
});

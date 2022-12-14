function formValidation (el, rules, messages, submitHandler) {
	$(el).validate({
		errorElement	: 'span',
		errorClass		: 'help-block',
		focusInvalid	: true,
		rules			: rules,
		messages		: messages,
		highlight		: function(e){
			$(e).closest('.form-group').addClass('has-error')
		},
		success			: function(label){
			label.closest('.form-group').removeClass('has-error');
			label.remove();
		},
		submitHandler	: function(form){
			submitHandler(form);
		}
	});
}
function format_number(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? ',' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return x1 + x2;
}

function modal(type, args) {
  let e = 'global-modal'
  var el  = $('#' + e);

  if (type == 'close') {
    el.modal('hide');
  } else {
    $.post(
            args.url,
            args.ajaxParam, 
            function (data) {
                  el.find('.modal-title').html(args.title);
    el.find('.modal-body').html(data);
    el.find('.btnAction')
          .removeClass('btn-danger btn-primary btn-secondary btn-warning btn-blue btn-pink')
          .addClass(args.btnAction.cssClass)
          .html(args.btnAction.text);
    if(typeof args.btnAction.onPress !== 'undefined'){
      el.find('.btnAction').off().on('click', function(){
        args.btnAction.onPress();
      });
    }
    
    if(typeof args.doSomething !== 'undefined'){
      args.doSomething();
    }

    el.modal('show');
        }, "json"
        );
  }
}

function datePicker () {
		$('.date-picker').each(function () {
			$(this).datepicker({
		        format 				: 'd MM yyyy',
		        todayBtn 			: 'linked',
		        keyboardNavigation	: false,
		        forceParse			: false,
		        calendarWeeks		: true,
		        autoclose			: true
			}).on('changeDate', function(e){
				$(this).parent('.input-group').find('input[type="hidden"]').val(e.format('yyyy-mm-dd'))
				let merchantId = $('input[name="merchant_id"]').val()
				let branchId = $('input[name="branch_id"]').val()
				let date = e.format('yyyy-mm-dd')
				let name = $(this).attr('name')
				name = name.replace('date', '')
				var SITE_URL = '<?php echo SITE_URL?>';
				let element = `#bill_number${name}`
				$.post(
	        		"getBillNo",
	                {
	                    'merchant_id': merchantId,
	                    'branch_id' : branchId,
	                    'date': date,
	                }, function (data) {
	                	console.log(data)
	                  $(element).find('option').remove();
	                  for(var i=0;i<data.length;i++){
	                      $(element).append('<option value="'+data[i]['bill_no']+'">'+data[i]['bill_no']+'</option>');
	                  }
		        },
		      	);
			})
		})
	}

function dateColumnOrder () {
	jQuery.extend( jQuery.fn.dataTableExt.oSort, {
	    "date-uk-pre": function ( a ) {
	        if (a == null || a == "") {
	            return 0;
	        }
	        var ukDatea = a.split('/');
	        return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
	    },
	 
	    "date-uk-asc": function ( a, b ) {
	        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
	    },
	 
	    "date-uk-desc": function ( a, b ) {
	        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
	    }
	} );
};

 function actionConfirm() {
 	 BootstrapDialog.confirm('Do you really want to delete this record ?');
   	
 }

function dataTable(el, perPage = 10, addDefs = 0, isDateOrder = false) {
	if (isDateOrder) {
		dateColumnOrder()
	}

	var defaultDefs = [{
        targets: 'no-sort',
        orderable: false
	}];

	var finalDefs = typeof addDefs == 'object' ? defaultDefs.concat(addDefs) : defaultDefs;

	var table = $(el).DataTable({
		lengthChange: true,
		aaSorting: [],
		pageLength: perPage,
        fixedHeader: true,
        responsive: true,
        "sDom": 'rtip',
        columnDefs: finalDefs,
        order: []
	});

	$('.key-search').each(function () {
		$(this).on('keyup', function() {
            table.search(this.value).draw();
        });
	});

	$(el).closest('.table-responsive').prev().find('select')
		.val(table.page.len())
		.on('change', function(){
			console.log(this.value)
    		table.page.len(this.value).draw();
    	});
};

function formValidation(el, rules, messages, submitHandler){
	$(el).validate({
		errorElement	: 'span',
		errorClass		: 'help-block',
		focusInvalid	: true,
		rules			: rules,
		messages		: messages,
		highlight		: function(e){
			$(e).closest('.form-group').addClass('has-error')
		},
		success			: function(label){
			label.closest('.form-group').removeClass('has-error');
			label.remove();
		},
		submitHandler	: function(form){
			submitHandler(form);
		}
	});
};

function ajax(url, data) {
	var status = ''
	$.post({
        url: url,
        data: data,
        success: function(jsonData){      
			status = `${jsonData[11]}${jsonData[12]}${jsonData[13]}${jsonData[14]}`
			return status
    	},
    	error: function(json){      
        	
     	}
    });
}
function datePicker () {
$('.date-picker').each(function () {
	$(this).datepicker({
        format 				: 'd MM yyyy',
        todayBtn 			: 'linked',
        keyboardNavigation	: false,
        forceParse			: false,
        calendarWeeks		: true,
        autoclose			: true
	}).on('changeDate', function(e){
		$(this).parent('.input-group').find('input[type="hidden"]').val(e.format('yyyy-mm-dd'))
	})
})
}
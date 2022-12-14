$(document).ready(function() {
	$('.waiting').hide()
	$('#report_payment').dataTable()
	datePicker()

	$("#merchant_id").change(function(event){
	    $.post(
	        "/cms_bprd/report/branch",
	                {
	                    'merchant_id': $('#merchant_id').val(),
	                }, function (data) {
	                  
	                  $('#branch_id').find('option').remove();
	                  $('#branch_id').append('<option value="ALL">ALL</option>');
	                
	                  for(var i=0;i<data.length;i++){
	                      $('#branch_id').append('<option value="'+data[i]['branch_id']+'">'+data[i]['branch_name']+'</option>');
	                  }
	        }, "json"
	      );
	});
	
	$('#btnExportPaymentXlsx').click(function(e) {
		let merchantId = $('select[name="merchant_id"]').val()
		let branchId = $('select[name="branch_id"]').val()
		let year = $('select[name="year"]').val()
		let month = $('select[name="month"]').val()
		let invoiceNo = $('input[name="invoice_no"]').val()
		let element = $('#onnline_tranasction_list').find('tbody')
		let subanId 	= $('select[name="suban_id"]').val()

		if (merchantId = '') {
			toastr['warning']('silahkan Pilih Wajib Pajak !')
		}

		if (year == '') {
			toastr['warning']('Silahkan Pilih Tahun')
			return false
		}

		if (month == '') {
			toastr['warning']('Silahkan Pilih Bulan')
			return false
		}
		$('#message').html('Harap Tunggu..')
		$.post(
    		"/cms_bprd/ReportPayment/excel_export/xlsx",
            {
                'merchant_id'	: $('select[name="merchant_id"]').val(),
                'branch_id' 	: branchId,
                'year'			: year,
                'month'			: month,
                'invoice_no'	: invoiceNo,
                'suban_id'		: subanId
            }, function (data) {
	            $('#message').html(data.message)     
        },"json"
      	);
	})

	$('#btnExportPaymentCsv').click(function(e) {
		let merchantId = $('select[name="merchant_id"]').val()
		let branchId = $('select[name="branch_id"]').val()
		let year = $('select[name="year"]').val()
		let month = $('select[name="month"]').val()
		let invoiceNo = $('input[name="invoice_no"]').val()
		let element = $('#onnline_tranasction_list').find('tbody')
		let subanId 	= $('select[name="suban_id"]').val()
		
		if (merchantId = '') {
			toastr['warning']('Eilahkan Pilih Wajob Pajak !')
		}

		if (year == '') {
			toastr['warning']('ilahkan Pilih Tahun')
			return false
		}

		if (month == '') {
			toastr['warning']('Silahkan Pilih Bulan')
			return false
		}

		$.post(
    		"/cms_bprd/ReportPayment/excel_export/csv",
            {
                'merchant_id'	: merchantId,
                'branch_id' 	: branchId,
                'year'			: year,
                'month'			: month,
                'invoice_no'	: invoiceNo,
                'suban_id'		: subanId
            }, function (data) {
	                 
        },"json"
      	);
	})

	$('.print-report').click(function(e) {
		window.print()
	})

	$('.close-report').click(function(){
	    window.close();
	});

	$('#btnExportPaymentPdf').click(function(e){
		e.preventDefault()
    	let el = $(this)
    	let merchantId = $('select[name="merchant_id"]').val()
		let branchId = $('select[name="branch_id"]').val()
		let year = $('select[name="year"]').val()
		let month = $('select[name="month"]').val()
		let invoiceNo = $('input[name="invoice_no"]').val()
		let subanId 	= $('select[name="suban_id"]').val()

    	let url = `${el.attr('href')}/${month}/${year}/${merchantId}/${branchId}/${subanId}/${invoiceNo}`
   
      	window.open(url) 
	})

	function get_data() {
		let merchantId 	= $('select[name="merchant_id"]').val()
		let branchId 	= $('select[name="branch_id"]').val()
		let year 		= $('select[name="year"]').val()
		let month	 	= $('select[name="month"]').val()
		let invoiceNo 	= $('input[name="invoice_no"]').val()
		let element 	= $('#report_payment').find('tbody')
		let tr 			= $('#report_payment').find('tbody').find('tr')
		let subanId 	= $('select[name="suban_id"]').val()
		let ppn = 0
		let assessment = 0
		let paid = 0

		if (month == '') {
			toastr['warning']('Silahkan Pilih Bulan !')
			return false
		}

		if (merchantId == '') {
			toastr['warning']('Silahkan Pilih Wajib Pajak !')
			return false
		}
		console.log(merchantId, month)
		$('#report_payment').dataTable({
			processing	: true,
			serverSide	: true,
			ajax		: {
				'url'	: 'get_data',
				'type'	: 'POST',
				'data'	: {
					'merchant_id'	: merchantId,
	                'branch_id' 	: branchId,
	                'year'			: year,
	                'month'			: month,
	                'invoice_no'	: invoiceNo,
	                'suban_id'		: subanId
				},
				'dataType'	: 'json'
			},
			columnDefs	:[
				{

				}
			]
		})
	}

	$('#btnSubmitPayment').click(function(e) {
		$('#report_payment').dataTable().fnDestroy()
		get_data()
	})

})

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
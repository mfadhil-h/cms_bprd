$(document).ready(function() {
	$("#report_transaction").DataTable()
	datePicker()

	function validation() {
		let startDate = new Date($('input[name="start_date"]').val())
		let endDate = new Date($('input[name="end_date"]').val())
		
		let monthStart 	= startDate.getMonth()
		let monthhEnd 	= endDate.getMonth()

		let yearStart 	= startDate.getFullYear()
		let yearEnd 	= endDate.getFullYear()

		let res = 'true'
		if ((monthStart != monthhEnd  && yearStart != yearEnd) || (monthStart != monthhEnd  && yearStart == yearEnd) || (monthStart == monthhEnd  && yearStart != yearEnd)) {
			toastr['warning']('Silahkan pilih tanggal mulai dan tanggal akhir pada periode(bulan dan tahun) yang sama')
			res = 'false'
			return false
		}

		return res
	}
	
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
	
	$('#btnExportTransactionXlsx').click(function(e) {
		let res = validation()

		if (res != 'true' ) {
			return false
		}
		let merchantId = $('select[name="merchant_id"]').val()
		let branchId = $('select[name="branch_id"]').val()
		let startDate = $('input[name="start_date"]').val()
		let endDate = $('input[name="end_date"]').val()
		let billNo = $('input[name="bill_no"]').val()
		let subanId = $('select[name="suban_id"]').val()
		let element = $('#onnline_tranasction_list').find('tbody')
		if (startDate == '') {
			toastr['warning']('Start Date is required')
			return false
		}

		if (endDate == '') {
			toastr['warning']('Start Date is required')
			return false
		}

		if (new Date(startDate).getTime() > new Date(endDate).getTime()) {
			toastr['warning']['Start date can not greater than edn date']
		}
		$('#message').html('Harap Tunggu..')
		$.post(
    		"/cms_bprd/reportTransaction/excel_export/xlsx",
            {
                'merchant_id'	: merchantId,
                'branch_id' 	: branchId,
                'start_date'	: startDate,
                'end_date'		: endDate,
                'bill_no'		: billNo,
                'suban_id'		: subanId
            }, function (data) {
	        	$('#message').html(data.message)
        },"json"
      	);
	})

	$('#btnExportTransactionCsv').click(function(e) {
		let res = validation()

		if (res != 'true' ) {
			return false
		}

		let merchantId = $('select[name="merchant_id"]').val()
		let branchId = $('select[name="branch_id"]').val()
		let startDate = $('input[name="start_date"]').val()
		let endDate = $('input[name="end_date"]').val()
		let billNo = $('input[name="bill_no"]').val()
		let element = $('#onnline_tranasction_list').find('tbody')
		let subanId = $('select[name="suban_id"]').val()
		if (startDate == '') {
			toastr['warning']('Start Date is required')
			return false
		}

		if (endDate == '') {
			toastr['warning']('Start Date is required')
			return false
		}

		if (new Date(startDate).getTime() > new Date(endDate).getTime()) {
			toastr['warning']['Start date can not greater than edn date']
		}
		$('#message').html('Harap Tunggu..')
		$.post(
    		"/cms_bprd/reportTransaction/excel_export/csv",
            {
                'merchant_id'	: merchantId,
                'branch_id' 	: branchId,
                'start_date'	: startDate,
                'end_date'		: endDate,
                'bill_no'		: billNo,
                'suban_id'		: subanId
            }, function (data) {
	           $('#message').html(data.message)
        },"json"
      	);
	})

	$('.print-report').click(function(e) {
		window.print()
	})

	$('.close-report').click(function(){
	    window.close();
	});

	$('#btnTransactionPpdf').click(function(e){
		e.preventDefault()
		let res = validation()

		if (res != 'true' ) {
			return false
		}

    	let el = $(this)
    	let merchantId = $('select[name="merchant_id"]').val()
		let branchId = $('select[name="branch_id"]').val()
		let startDate = $('input[name="start_date"]').val()
		let endDate = $('input[name="end_date"]').val()
		let billNo = $('input[name="bill_no"]').val()
		if (bill_no = '') { bill_no = '-'}
		let subanId = $('select[name="suban_id"]').val()
		if (startDate == '') {
			toastr['warning']('Start Date is required')
			return false
		}

		if (endDate == '') {
			toastr['warning']('Start Date is required')
			return false
		}

		if (new Date(startDate).getTime() > new Date(endDate).getTime()) {
			toastr['warning']['Start date can not greater than edn date']
		}

    	let url = `${el.attr('href')}/${startDate}/${endDate}/${merchantId}/${branchId}/${subanId}/${billNo}`
   
      	window.open(url) 
	})

	function get_data() {
		let merchantId 	= $('select[name="merchant_id"]').val()
		let branchId 	= $('select[name="branch_id"]').val()
		let startDate 	= $('input[name="start_date"]').val()
		let endDate 	= $('input[name="end_date"]').val()
		let billNo 		= $('input[name="bill_no"]').val()
		let element 	= $('#report_transaction').find('tbody')
		let tr 			= $('#report_transaction').find('tbody').find('tr')
		let subanId 	= $('select[name="suban_id"]').val()
		let totalAmount = 0
		let service 	= 0
		let ppn 		= 0
		let totalTRx 	= 0

		if (startDate == '') {
			toastr['warning']('Start Date is required')
			return false
		}

		if (endDate == '') {
			toastr['warning']('Start Date is required')
			return false
		}

		if (new Date(startDate).getTime() > new Date(endDate).getTime()) {
			toastr['warning']['Start date can not greater than edn date']
		}

		$("#report_transaction").DataTable({
	        processing      : true,
	        serverSide      : true,
	        ajax: {
	            "url"	: "get_data",
	            "type"	: "POST",
	            "data"	: {
	            	"merchant_id"	: merchantId,
	                "branch_id" 	: branchId,
	                "start_date"	: startDate,
	                "end_date"		: endDate,
	                "bill_no"		: billNo,
	                'suban_id'		: subanId
	            },
	            "dataType" : "json"
	        },
	        
	        columnDefs: [
	            {
	               
		        }
	        ]

	    });
	}

	$('#btnSubmitTransaction').click(function(e) {
		$('#report_transaction').dataTable().fnDestroy()
		let res = validation()

		if (res != 'true' ) {
			return false
		}
		
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
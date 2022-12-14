$(document).ready(function() {
	$('.waiting').hide()
	//$('#onnline_tranasction_list').dataTable()
	datePicker()
	

	$('.print-report').click(function(e) {
		window.print()
	})

	$('.close-report').click(function(){
	    window.close();
	});

	$('#btnTransactionPpdf').click(function(e){
		let res = validation()

		if (res != 'true' ) {
			return false
		}
		e.preventDefault()
    	let el = $(this)
		let startDate = $('input[name="start_date"]').val()

		if (startDate == '') {
			toastr['warning']('Start Date is required')
			return false
		}

    	let url = `${el.attr('href')}/${startDate}`
   
      	window.open(url) 
	})

/*	$('#btnSubmitTransaction').click(function(e) {
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
		let tr = $('#onnline_tranasction_list').find('tbody').find('tr')
		let subanId = $('select[name="suban_id"]').val()
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

		$('#onnline_tranasction_list').dataTable().fnDestroy()
		
		$("#onnline_tranasction_list").DataTable({
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
	            	"suban_id"		: subanId
	            },
	            "dataType" : "json"
	        },
	        
	        columnDefs: [
	            {
	               
		        }
	        ]

	    });
	})*/

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
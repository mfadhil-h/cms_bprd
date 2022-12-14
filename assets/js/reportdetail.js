$(document).ready(function() {
	$('.waiting').hide()
	$('#report_detail').dataTable()
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
	
	$('#btnExportMemberXlsx').click(function(e) {
		let res = validation()

		if (res != 'true' ) {
			return false
		}
		let merchantId = $('select[name="merchant_id"]').val()
		let branchId = $('select[name="branch_id"]').val()
		let startDate = $('input[name="start_date"]').val()
		let endDate = $('input[name="end_date"]').val()
		let billNo = $('input[name="bill_no"]').val()
		let suban_id 	= $('select[name="suban_id"]').val()
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
			toastr['warning']('Start date can not greater than end date')
			return false
		}
		$('#message').html('Sedang generate data, Harap Tunggu...')
		$.post(
    		"/cms_bprd/ReportDetail/excel_export/xlsx",
            {
                'merchant_id'	: merchantId,
                'branch_id' 	: branchId,
                'start_date'	: startDate,
                'end_date'		: endDate,
                'bill_no'		: billNo,
                'suban_id'		: suban_id
            }, function (data) {
	        	$('#message').html(data.message)   
        },"json"
      	);
	})

	$('#btnExportMemberCsv').click(function(e) {
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
		let suban_id 	= $('select[name="suban_id"]').val()
		if (startDate == '') {
			toastr['warning']('Start Date is required')
			return false
		}

		if (endDate == '') {
			toastr['warning']('Start Date is required')
			return false
		}

		if (new Date(startDate).getTime() > new Date(endDate).getTime()) {
			toastr['warning']('Start date can not greater than edn date')
			return false
		}

		$('#message').html('Sedang generate data, Harap Tunggu...')
		$.post(
    		"/cms_bprd/ReportDetail/excel_export/csv",
            {
                'merchant_id'	: merchantId,
                'branch_id' 	: branchId,
                'start_date'	: startDate,
                'end_date'		: endDate,
                'bill_no'		: billNo,
                'suban_id'		: suban_id

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

	$('#btnExportMemberPdf').click(function(e){
		let res = validation()

		if (res != 'true' ) {
			return false
		}
		e.preventDefault()
    	let el = $(this)
    	let merchantId = $('select[name="merchant_id"]').val()
		let branchId = $('select[name="branch_id"]').val()
		let startDate = $('input[name="start_date"]').val()
		let endDate = $('input[name="end_date"]').val()
		let billNo = $('input[name="bill_no"]').val()
		let suban_id 	= $('select[name="suban_id"]').val()

		if (startDate == '') {
			toastr['warning']('Start Date is required')
			return false
		}

		if (endDate == '') {
			toastr['warning']('Start Date is required')
			return false
		}

		if (new Date(startDate).getTime() > new Date(endDate).getTime()) {
			toastr['warning']('Start date can not greater than edn date')
			return false
		}

    	let url = `${el.attr('href')}/${startDate}/${endDate}/${merchantId}/${branchId}/${suban_id}/${billNo}`
   
      	window.open(url) 
	})

	function get_data() {
		let merchantId 	= $('select[name="merchant_id"]').val()
		let branchId 	= $('select[name="branch_id"]').val()
		let startDate 	= $('input[name="start_date"]').val()
		let endDate 	= $('input[name="end_date"]').val()
		let billNo 		= $('input[name="bill_no"]').val()
		let suban_id 	= $('select[name="suban_id"]').val()
		let element 	= $('#report_detail').find('tbody')
		let tr 			= $('#report_detail').find('tbody').find('tr')

		let itemPrice 	= 0
		let itemAmount 	= 0
		let dateStart 	= parseFloat(new Date(startDate).getTime())
		let dateEnd 	= parseFloat(new Date(endDate).getTime())

		if (dateStart > dateEnd) {
			toastr['warning']('Start date can not greater than end date')
			$('.waiting').hide()
			return false
		}

		if (startDate == '') {
			toastr['warning']('Start Date is required')
			$('.waiting').hide()
			return false
		}

		if (endDate == '') {
			toastr['warning']('End Date is required')
			$('.waiting').hide()
			return false
		}
		
		$('#report_detail').dataTable().fnDestroy()

		$('#report_detail').dataTable({
			processing      : true,
	        serverSide      : true,
			ajax 			: {
				'url'		: 'get_data',
				'type'		: 'POST',
				'dataType'	: 'JSON',
				'data'	: {
					'merchant_id'	: merchantId,
	                'branch_id' 	: branchId,
	                'start_date'	: startDate,
	                'end_date'		: endDate,
	                'bill_no'		: billNo,
	                'suban_id'		: suban_id
				}
			},

			columnDefs		: {

			}
		})
	}

	$('#btnSubmitMember').click(function(e) {
		$('.waiting').show()
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
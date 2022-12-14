$(document).ready(function() {
	$('.waiting').hide()
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
	

	$('.print-report').click(function(e) {
		window.print()
	})

	$('.close-report').click(function(){
	    window.close();
	});


	function get_data() {

		let merchantId 	= $('select[name="merchant_id"]').val()
		let branchId 	= $('select[name="branch_id"]').val()
		let startDate 	= $('input[name="start_date"]').val()
		let endDate 	= $('input[name="end_date"]').val()
		let billNo 		= $('input[name="bill_no"]').val()
		let element 	= $('#report_data_monitoring').find('tbody')
		let tr 			= $('#report_data_monitoring').find('tbody').find('tr')
		let subanId 	= $('select[name="suban_id"]').val()
		let firstDay 	= new Date(startDate).getDate()
		let endDay		= new Date(endDate).getDate()
		let month 		= new Date(startDate).getMonth() + 1
		let dataEmpty = false
		let totalTransaction = 0
		let tdClass = ''
		let th = ''
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

		if ($('#empty_data').prop('checked') == true) {
			dataEmpty = true
		}

		for (let i = firstDay; i<=endDay; i++) {
			th += `<th>${i}</th>`
		}
		$('#report_data_monitoring').dataTable().fnDestroy()
		$('table').remove()
		$('.table-responsive').append(`
			<table id="report_data_monitoring" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
               	<thead>
	                <tr>
	                    <th>Wajib Pajak</th>
	                    <th>Outlet</th>
	                    ${th}
	                </tr>
	            </thead>    
            </table>`
        )

		let colDefs = '';
		let defsCols = [];
		

		for (let i = 2; i<=endDay+1; i++) {
			colDefs = '';
			colDefs = {
				targets : i,
				render 	: (data, type, row) => {
						return data	
				},
				createdCell: function (td, cellData, rowData, row, col) {
	               if (cellData == 0) {
	                   	$(td).addClass('danger');
	               } else {
	               		$(td).addClass('info');
	               }
	           }
			}

			defsCols.push(colDefs)

		}	

		$('#report_data_monitoring').dataTable({
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
	                'empty_data'	: dataEmpty,
	                'suban_id'		: subanId
				}
			},
			
			columnDefs: defsCols
		})
	}

	$('#btnSubmitTransaction').click(function(e) {
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
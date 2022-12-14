$(document).ready(function() {
	$('#table-live-branch').dataTable()

	get_branch()
	show_data()
	excel_export()
})

function excel_export() {
	$('#btnExportXlsx').click(function (event) {

		let year 		= $('select[name="year"]').val()
		let month 		= $('select[name="month"]').val()
		let merchant_id = $('select[name="merchant_id"]').val()
		let branch_id 	= $('select[name="branch_id"]').val()
		let suban_id 	= $('select[name="suban_id"]').val()

		let url = `${$(this).attr('href')}/${merchant_id}/${branch_id}/${year}/${month}/${suban_id}`
		window.location.href = url;
	})
}
function get_branch() {
	$("#merchant_id").change(function(event){
	    $.post(
	        "/cms_bprd/report/branch",
                {
                    'merchant_id': $('#merchant_id').val(),
                }, function (data) {
                  $('#branch_id').find('option').remove();
                  $('#branch_id').append('<option value="ALL">--Semua Outlet--</option>');

                  for(var i=0;i<data.length;i++){
                      $('#branch_id').append('<option value="'+data[i]['branch_id']+'">'+data[i]['branch_name']+'</option>');
                  }
	        }, "json"
	    );
	});

	$('#tax').keypress(function(event) {
	    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
	    	event.preventDefault();
	    }
	});
}

function show_data() {
	$('#btn_get_data').click(function (event) {

		let year 		= $('select[name="year"]').val()
		let month 		= $('select[name="month"]').val()
		let merchant_id = $('select[name="merchant_id"]').val()
		let branch_id 	= $('select[name="branch_id"]').val()
		let suban_id 	= $('select[name="suban_id"]').val()
		
		if (year == '') {
			toastr['warning']('Pilih tahun untuk menanmpilkan data')
			return false
		}

		if (month == '') {
			toastr['warning']('Pilih bulan untuk menanmpilkan data')
			return false
		}

		$('#table-live-branch').dataTable().fnDestroy()
		$('#table-live-branch').dataTable({
			processing      : true,
	        serverSide      : true,
			ajax 			: {
				'url'		: 'get_data',
				'type'		: 'POST',
				'dataType'	: 'JSON',
				'data'	: {
					'merchant_id'	: merchant_id,
	                'branch_id' 	: branch_id,
	                'month'			: month,
	                'year'			: year,
	                'suban_id'		: suban_id
				}
			},
			
			columnDefs	:[
				{
				}
			],
		})
	})
}
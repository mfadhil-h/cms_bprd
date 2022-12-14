$(document).ready(function () {
	$('#report_sspd_sptpd').dataTable()
	
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
	
	$('.sptpd-control').click(function(e) {
		e.preventDefault()
		let el = $(this)
		window.open(el.attr('href'), '_blank') 
	})

	$('#btn-view').click(function(e){

		let month = $('select[name="month"]').val()
		let year = $('select[name="year"]').val()
		let merchantId = $('select[name="merchant_id"]').val()
		let branchId = $('select[name="branch_id"]').val()

		if (year == '') {
			toastr['warning']('Silahkan pilih tahun untuk menampilkan data')
			return false
		} else if (month == '') {
			toastr['warning']('Silahkan pilih bulan untuk menampilkan data')
			return false
		}
		$('#report_sspd_sptpd').dataTable().fnDestroy()
		$("#report_sspd_sptpd").DataTable({
	        processing      : true,
	        serverSide      : true,
	        ajax: {
	            "url"	: "/cms_bprd/reportSspdSptpd/get_data",
	            "type"	: "POST",
	            "data"	: {
	            	"merchant_id"	: merchantId,
	                "branch_id" 	: branchId,
	                "year"			: year,
	                "month"			: month
	            },
	            "dataType" : "json"
	        },

	        columns: [
		       	{ data : '0' },
	            { data : '1' },
	            { data : '2' },
	            { data : '3' },
	            { data : '4' },
	            { data : '5',orderable: false, searchable: false, className: 'text-center' }
	        ],
	        
	        columnDefs: [
	            {
	               
		        }
	        ]

	    });
	})
})

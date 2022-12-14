$(document).ready(function () {
	$('#table-tax-report').DataTable()


	 $('#table-tax-report tbody').on('click', '.taxreport-control', function(e) {
        e.preventDefault()

        $.post(
  	        "isosptpd",
            {
	          'pa_id'			: $(this).attr('data-pa-id'),
            }, function (data) {
  	             if (! data.res) {
  	             	toastr['warning'](data.message)
  	             	return false
  	             
  	             } else {
  	             	toastr['success'](data.message)
  	             }
  	        }, "json"
  	    );
     
    })

	$('#btn-view').click(function(e){
		let year 		= $('select[name="year"]').val()
    let month 		= $('select[name="month"]').val()
    let merchantId 	= $('select[name="merchant_id"]').val()
    let branchId 	= $('select[name="branch_id"]').val() 
		

    if (year == '') {
      toastr['warning']('Silahkan pilih tahun untuk menampilkan data !')
      return false
    } else if (month == '') {
      toastr['warning']('Silahkan pilih bulan untuk menampilkan data !')
      return false
    } else if (merchantId == '') {
      toastr['warning']('Silahkan pilih Wajib Pajak untuk menampilkan data !')
      return false
    } else if (branchId == '') {
      toastr['warning']('Silahkan pilih otlet untuk menampilkan data !')
      return false
    }

		$('#table-tax-report').dataTable().fnDestroy()

		$("#table-tax-report").DataTable({
	        processing      : true,
	        serverSide      : true,
	        ajax: {
	            "url"	: "getreporttax",
	            "type"	: "POST",
	            "data"	: {
	            	"merchant_id"	: merchantId,
		            "branch_id" 	: branchId,
		            "year"			: year,
		            "month"			: month
	            },
	            "dataType" : "json"
	        },
	        
          columns : [
            { data : '0' },
            { data : '1' },
            { data : '2' },
            { data : '3' },
            { data : '4' },
            { data : '5', className: 'text-right'},
            { data : '6',orderable: false, searchable: false, className: 'text-center' }
          ],

	        columnDefs: [
	            {
	               
		        }
	        ]

	    });
	})

	$('#year').change(function(){
      var monthname=["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
    	var month = new Date().getMonth() + 1;
    	
      $('#month').empty();
    	$('#month').append('<option value="">--Pilih--</option>');
   		if($('#year').val() == (new Date().getFullYear())){
	    	for(var i=1;i<=month;i++){
	        	$('#month').append('<option value="'+i+'">'+monthname[i-1]+'</option>');
	        }
    	} else if($('#year').val() == 'ALL') {
        	$('#month').empty();
			$('#month').append('<option value="">--Pilih--</option>');
		} else {
        	for(var i=1;i<13;i++){
        		$('#month').append('<option value="'+i+'">'+monthname[i-1]+'</option>');
        	}
      	}
    })

    $("#merchant_id").change(function(event){
  	    $.post(
  	        "/cms_bprd/report/branch",
  	                {
  	                    'merchant_id': $('#merchant_id').val(),
  	                }, function (data) {
  	                  $('#branch_id').find('option').remove();
  	                  $('#branch_id').append('<option value="">--Pilih--</option>');
  	                
  	                  for(var i=0;i<data.length;i++){
  	                      $('#branch_id').append('<option value="'+data[i]['branch_id']+'">'+data[i]['branch_name']+'</option>');
  	                  }
  	        }, "json"
  	    );
    });

})

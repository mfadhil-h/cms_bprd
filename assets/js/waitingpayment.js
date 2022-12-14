$(document).ready(function() {
  $('.waiting').hide()
  $('#table-waiting-payment').dataTable()
  show_detail()

  function show_detail() {
    $('.show-control').click(function(e) {
      e.preventDefault()
      let orderId = $(this).parent().find('a').attr('class').replace('show-control ext-light mr-3 font-16 ', '')
      let args = {
        title       : 'Detil Menunggu Pembayaran',
        url         : 'show_detail_waiting_payment',
        ajaxParam   : {'order_id' : orderId},
        btnAction   : {
                    cssClass    : 'btn-primary action-btn',
                    text        : 'OK',
                    onPress       : function(e) {
                      modal('close')
                    }
                },
        doSomething    : function(e) {
                          $('#table-waiting-payment-detail').dataTable()
                          
                          let modalDialog = $('#global-modal .modal-dialog')

                          modalDialog.addClass('modal-lg')
                          $('#global-modal').on('hidden.bs.modal', function(e) {
                              modalDialog.removeClass('modal-lg')
                          })

                        
                      }
      }
      modal('open', args)
    })
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

    $('#year').change(function(){
      	var monthname=["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
    	 var month = new Date().getMonth() + 1;
      $('#month').empty();
      $('#month').append('<option value="ALL">ALL</option>');
    	if($('#year').val() == (new Date().getFullYear())){
	    	for(var i=0;i<month;i++){
	        	$('#month').append('<option value="'+i+'">'+monthname[i]+'</option>');
	        }
    	} else if($('#year').val() == 'ALL') {
         $('#month').empty();
        $('#month').append('<option value="ALL">ALL</option>');
      } else {
        	for(var i=1;i<13;i++){
        		$('#month').append('<option value="'+i+'">'+monthname[i-1]+'</option>');
        	}
      	}
    });

    $('#btn-view').click(function() {
      let year        = $('select[name="year"]').val()
      let month       = $('select[name="month"]').val()
      let merchantId = $('select[name="merchant_id"]').val()
      let branchId   = $('select[name="branch_id"]').val()
      let element     = $('#table-waiting-payment').find('tbody')
      $('.waiting').show()
      $('.waiting').html('Please Wait...')
      $.post(
        "waitingpayment",
            {
                'merchant_id' : merchantId,
                'branch_id'   : branchId,
                'year'        : year,
                'month'       : month,
            }, function (data) {
              $('#table-waiting-payment').DataTable().clear().destroy();
              if (data.length == 0) {
                $('#table-waiting-payment').dataTable().fnDestroy()
                dataTable('#table-waiting-payment')
                $("#table-waiting-payment").empty()
                $('.waiting').html('Data is empty')
              } else {
                for(var i=0;i<data.length;i++){

                  tax = data[i]['total_ppn']
                  tax = tax.replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                      $(element).append(`
                      <tr>
                        <td>${data[i]['year']}</td>
                        <td>${data[i]['month']}</td>
                        <td class="text-right">${tax}</td>
                        <td class="text-right">${data[i]['va_number']}</td>
                        <td class="text-center">
                            <a order-id="'.$row["order_id"].'" class="show-control ext-light mr-3 font-16 ${data[i]['order_id']}" data-toggle="tooltip" title="Show Detail">
                            <i class="fa fa-eye"></i></a></td>
                      </tr>`);
                }
              }
                $('#table-waiting-payment').dataTable().fnDestroy()
                $('#table-waiting-payment').dataTable()
                $('.waiting').hide()
                show_detail()     
        },"json"
        );

    })
})

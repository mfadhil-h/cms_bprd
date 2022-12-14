$(document).ready(function() {
  $('.waiting').hide()
	$('.hide-btn').hide()
  $('#summary_report_table').dataTable()

	$("#merchant_id_summary").change(function(event){
	    let merchantId = $('#merchant_id_summary').val()

	    if (merchantId == '') {
	      $('.hide-btn').hide()
	    } else {
	      $('.hide-btn').show() 
	    }
	    $.post(
	        "/cms_bprd/report/branch",
	                {
	                    'merchant_id': $('#merchant_id_summary').val(),
	                }, function (data) {
	                  
	                  $('#branch_id_summary').find('option').remove();

	                  for(var i=0;i<data.length;i++){
	                      $('#branch_id_summary').append('<option value="'+data[i]['branch_id']+'">'+data[i]['branch_name']+'</option>');
	                  }
	        }, "json"
	    );
  	});
	
	 $("#branch_id_summary").change(function(event){
    	$('.hide-btn').show()
  	});

	$('#btnSubmitSummary').click(function (event) {
    $('#summary_report_table').dataTable().fnDestroy()
		let merchantId 	= $('select[name="merchant_id_summary"]').val()
		let branchId 	= $('select[name="branch_id_summary"]').val()
		let year 		= $('select[name="year"]').val()
		let month 		= $('select[name="month"]').val()
		let tax = 0
    $('#summary_report_table').dataTable({
      processing  : true,
      serverSide  : true,
      ajax    : {
        'url' : 'data_search',
        'type'  : 'POST',
        'data'  : {
          'year'        : $('#year').val(),
          'month'       : $('#month').val(),
          'merchant_id' : $('#merchant_id_summary').val(),
          'branch_id'   : $('#branch_id_summary').val(),
          'suban_id'    : $('select[name="suban_id"]').val()
        },
        'dataType'  : 'json'
      },
      columnDefs  :[
        {
          targets : 3,
          rander :(data, type, row) => {
            console.log(data)
          }
        }
      ]
    })

        $.post(
            "getData",
            {
              'year'        : $('#year').val(),
              'month'       : $('#month').val(),
              'merchant_id' : $('#merchant_id_summary').val(),
              'branch_id'   : $('#branch_id_summary').val(),
              'suban_id'    : $('select[name="suban_id"]').val()
            }, function (data) {
              let html = `<div class="row data-ppn">
                          <div class="col-lg-12">
                              <div class="box box-default">
                                  <div class="box-body">
                                      <div class="col-sm-12">
                                          <div class="form-group col-sm-12">
                                              <span class="col-sm-4"><strong>Total Transaksi Bulan ${data['month']} tahun ${data['year']} : </strong></span>
                                              <span class="col-sm-3"><strong>: ${data['totalTransaction']}</strong></span>
                                              <span class="col-sm-5"><strong></strong></span>
                                          </div>
                                          <div class="form-group col-sm-12">
                                              <span class="col-sm-4"><strong>Total PPN Bulan ${data['month']} tahun ${data['year']} : </strong></span>
                                              <span class="col-sm-3"><strong>: ${data['totalTax']}</strong></span>
                                              <span class="col-sm-5"><strong></strong></span>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>`
              $('.data-ppn').remove()
              $('.selector').after(html)
            }, "json"
        );
    });
    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
    $("#btnExportSummaryCsv").click(function (event) {
          $('#message').html("Harap tunggu, server sedang menggenerate file report!");

        $.post(
                "excel/csv",
                {
                	'year'        : $('#year').val(),
                	'month'       : $('#month').val(),
                	'merchant_id' : $('#merchant_id_summary').val(),
                	'branch_id'   : $('#branch_id_summary').val(),
                  'suban_id'    : $('select[name="suban_id"]').val(),
                	'type'        :'csv'
                }, function (data) {
            	$('#message').html(data.message);
        }, "json"
        );

     });

     $("#btnExportSummaryXlsx").click(function (event) {
          $('#message').html("Harap tunggu, server sedang menggenerate file report!");

        $.post(
                "excel/xlsx",
                {
                	'year'        : $('#year').val(),
                	'month'       : $('#month').val(),
                	'merchant_id' : $('#merchant_id_summary').val(),
                	'branch_id'   : $('#branch_id_summary').val(),
                  'suban_id'    : $('select[name="suban_id"]').val(),
                	'type'        :'csv'
                }, function (data) {
            	$('#message').html(data.message);
        }, "json"
        );

    });

    $('#btnSummaryPpdf').click(function(e) {
        e.preventDefault()
        let el = $(this)
        let merchantId = $('select[name="merchant_id_summary"]').val()
        let branchId = $('select[name="branch_id_summary"]').val()
        let year = $('select[name="year"]').val()
        let month = $('select[name="month"]').val()
        let suban_id    = $('select[name="suban_id"]').val()

        if (year == '') {
          toastr['warning']('Year is required')
          return false
        }

        if (month == '') {
          toastr['warning']('Month is required')
          return false
        }

        let url = `${el.attr('href')}/${month}/${year}/${merchantId}/${branchId}/${suban_id}`
   
        window.open(url) 
    });

    $('.print-report').click(function(e) {
      window.print()
    })

    $('.close-report').click(function(){
        window.close();
    });
})

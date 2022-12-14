
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo assets_site;?>adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo assets_site;?>adminlte/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo assets_site;?>adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo assets_site;?>adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo assets_site;?>adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo assets_site;?>adminlte/plugins/fastclick/fastclick.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo assets_site;?>adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo assets_site;?>adminlte/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo assets_site;?>adminlte/dist/js/demo.js"></script>
<!-- page script -->
<script type="text/javascript">
  function getReportTransaction(){
    $('#example').DataTable({
            "scrollX": true,
            "ordering": true,
            "bDestroy": true,
            "serverSide": true,
            "bFilter": false,
            "bLengthChange": true,
            "processing": true,
            "order": [[ 5, "desc" ]],
            "ajax": {
                "url": "<?php echo base_url('report/transaction_data_search') ?>",
                "method" : "POST",
                "data": {
                    'start_date': $('#start_date').val(),
                    'end_date': $('#end_date').val(),
                    'bill_no': $('#bill_no').val(),
                    'merchant_id': $('#merchant_id').val(),
                    'branch_id': $('#branch_id').val(),
                    'search_acc': $('#search_acc').val(),
                    'merchantname': $('#merchantname').val(),
                    'wallet': $('#wallet').val(),
                    'merchant_owner': $('#merchant_owner').val(),
                    'biller_owner': $('#biller_owner').val(),
                    'payment_status': $('#payment_status').val(),
                    'biller_status': $('#biller_status').val(),
                    'itemtype': $('#itemtype').val(),
                    'guid': $('#guid').val(),
                    'hide_rawdata': $('#hide_rawdata').prop('checked')
                }
            }
        });
  }
  $(document).ready(function() {
    $('.hide-btn').hide()
    var rawdata = $('#hide_rawdata').val();
    var d = new Date();
    var m = d.getMonth() + 1;
    var y = d.getFullYear();
    // $("#year").val(y);
    // $("#month").val(m);

    var url = window.location.href;
    if(url.includes("report/transaction")){
      getReportTransaction();
      setInterval(function(){
        if($('#auto_refresh').is(":checked")){
          getReportTransaction();
        }
    },15000);
    }

    //Date picker
    $('#start_date').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy',
      todayHighlight: true,
        defaultDate: new Date()
    });

    //Date picker
    $('#end_date').datepicker({
        defaultDate: new Date(),
      autoclose: true,
      format: 'dd-mm-yyyy',
      todayHighlight: true
    });

    $('#btnSubmitTransaction').click(function(event) {
      getReportTransaction()
    })

    $('#btnTransactionPpdf').click(function(event) {
      $('#frmReportTransaction').submit()
    })
      $("#btnExportTransactionCsv").click(function (event) {
          $('#message').html("Harap tunggu, server sedang menggenerate file report!");

          $.post(
              "<?php echo base_url('report/transaction_report_xlsx/csv') ?>",
              {
                  'start_date': $('#start_date').val(),
                  'end_date': $('#end_date').val(),
                  'bill_no': $('#bill_no').val(),
                  'merchant_id': $('#merchant_id').val(),
                  'branch_id': $('#branch_id').val(),
                  'search_acc': $('#search_acc').val(),
                  'search_mtrx': $('#search_mtrx').val(),
                  'merchantname': $('#merchantname').val(),
                  'biller': $('#biller').val(),
                  'wallet': $('#wallet').val(),
                  'merchant_owner': $('#merchant_owner').val(),
                  'biller_owner': $('#biller_owner').val(),
                  'payment_status': $('#payment_status').val(),
                  'biller_status': $('#biller_status').val(),
                  'itemtype': $('#itemtype').val(),
                  'start_data': $('#start_data').val(),
                  'number_of_data': $('#number_of_data').val(),
                  'guid': $('#guid').val(),
                  'hide_rawdata': $('#hide_rawdata').prop('checked')
              }, function (data) {
                  $('#message').html(data.message);
              }, "json"
          );

      });

    function splitDate (date) {
      let year  = date.substring(6, 10)
      let month = date.substring(3, 5)
      let day  = date.substring(0, 2)

      let fullDate = `${year}-${month}-${day}`
      return fullDate
    };

    $('#start_date').on("change", function (e) {
        let startDate = $('#start_date').val()
        $('#end_date').data("datepicker").setDate(startDate);
    });

    $('#end_date').on('change', function(e) {
        let startDate = new Date(splitDate($('#start_date').val()))
        let endDate   = new Date(splitDate($('#end_date').val()))
        if (endDate < startDate) {
            $('#end_date').data("datepicker").setDate($('#start_date').val());
        }
    })

    $("#btnExportTransactionXlsx").click(function (event) {
        $('#message').html("Harap tunggu, server sedang menggenerate file report!");

        $.post(
                "<?php echo base_url('report/transaction_report_xlsx/xlsx') ?>",
                {
                    'start_date': $('#start_date').val(),
                    'end_date': $('#end_date').val(),
                    'bill_no': $('#bill_no').val(),
                    'merchant_id': $('#merchant_id').val(),
                    'branch_id': $('#branch_id').val(),
                    'search_acc': $('#search_acc').val(),
                    'search_mtrx': $('#search_mtrx').val(),
                    'merchantname': $('#merchantname').val(),
                    'biller': $('#biller').val(),
                    'wallet': $('#wallet').val(),
                    'merchant_owner': $('#merchant_owner').val(),
                    'biller_owner': $('#biller_owner').val(),
                    'payment_status': $('#payment_status').val(),
                    'biller_status': $('#biller_status').val(),
                    'itemtype': $('#itemtype').val(),
                    'start_data': $('#start_data').val(),
                    'number_of_data': $('#number_of_data').val(),
                    'guid': $('#guid').val(),
                    'hide_rawdata': $('#hide_rawdata').prop('checked'),
                    'type':'xlsx'
                }, function (data) {
            $('#message').html(data.message);
        }, "json"
                );

    });

        $('#btnSubmitSummary').click(function (event) {
          $('#summary_report_table').DataTable({
              "scrollX": true,
              "ordering": true,
              "bDestroy": true,
              "serverSide": true,
              "bFilter": false,
              "bLengthChange": true,
              "processing": true,
              "ajax": {
                  "url": "<?php echo base_url('ReportSummary/data_search') ?>",
                  "method" : "POST",
                  "data": {
                      'year': $('#year').val(),
                      'month': $('#month').val(),
                      'merchant_id': $('#merchant_id_summary').val(),
                      'branch_id': $('#branch_id_summary').val()
                  }
              }
          });

          $.post(
            "<?php echo base_url('ReportSummary/getData') ?>",
            {
              'year'        : $('#year').val(),
              'month'       : $('#month').val(),
              'merchant_id' : $('#merchant_id_summary').val(),
              'branch_id'   : $('#branch_id_summary').val()
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

        $("#btnExportSummaryXlsx").click(function (event) {
          $('#message').html("Harap tunggu, server sedang menggenerate file report!");

          $.post(
                  "<?php echo base_url('ReportSummary/excel/xlsx') ?>",
                  {
                      'year'        : $('#year').val(),
                      'month'       : $('#month').val(),
                      'merchant_id' : $('#merchant_id_summary').val(),
                      'branch_id'   : $('#branch_id_summary').val(),
                      'type'        :'xlsx'
                  }, function (data) {
              $('#message').html(data.message);
          }, "json"
                  );

      });

      $("#btnExportSummaryCsv").click(function (event) {
          $('#message').html("Harap tunggu, server sedang menggenerate file report!");

          $.post(
                  "<?php echo base_url('ReportSummary/excel/xlsx') ?>",
                  {
                      'year'        : $('#year').val(),
                      'month'       : $('#month').val(),
                      'merchant_id' : $('#merchant_id_summary').val(),
                      'branch_id'   : $('#branch_id_summary').val(),
                      'type'        :'csv'
                  }, function (data) {
              $('#message').html(data.message);
          }, "json"
                  );

      });

      $('#btnSummaryPpdf').click(function(event) {
        $('#summary_report').submit()
      });

      $("#btnSubmitMember").click(function (event) {
          $('#membertable').DataTable({
              "scrollX": true,
              "ordering": true,
              "bDestroy": true,
              "serverSide": true,
              "bFilter": false,
              "bLengthChange": true,
              "processing": true,
              // "order": [[ 5, "desc" ]],
              "ajax": {
                  "url": "<?php echo base_url('report/detail_data_search') ?>",
                  "method" : "POST",
                  "data": {
                      'start_date': $('#start_date').val(),
                      'end_date': $('#end_date').val(),
                      'bill_no': $('#bill_no').val(),
                      'merchant_id': $('#merchant_id').val(),
                      'branch_id': $('#branch_id').val(),
                      'guid': $('#guid').val(),
                      'hide_rawdata': $('#hide_rawdata').prop('checked')
                  }
              }
          });
      });
      
      $('#btnExportMemberPdf').click(function(event) {
        $('#frmReportDetail').submit()
      });

      $("#btnExportMemberCsv").click(function (event) {
          $('#message').html("Harap tunggu, server sedang menggenerate file report!");

          $.post(
              "<?php echo base_url('report/detail_report_xlsx/csv') ?>",
              {
                  'start_date': $('#start_date').val(),
                  'end_date': $('#end_date').val(),
                  'bill_no': $('#bill_no').val(),
                  'merchant_id': $('#merchant_id').val(),
                  'branch_id': $('#branch_id').val(),
                  'search_acc': $('#search_acc').val(),
                  'start_data': $('#start_data').val(),
                  'number_of_data': $('#number_of_data').val(),
                  'guid': $('#guid').val(),
                  'hide_rawdata': $('#hide_rawdata').prop('checked')
              }, function (data) {
                  $('#message').html(data.message);
              }, "json"
          );

      });

  $("#btnExportMemberXlsx").click(function (event) {
        $('#message').html("Harap tunggu, server sedang menggenerate file report!");

        $.post(
                "<?php echo base_url('report/detail_report_xlsx/xlsx') ?>",
                {
                    'start_date': $('#start_date').val(),
                    'end_date': $('#end_date').val(),
                    'bill_no': $('#bill_no').val(),
                    'start_data': $('#start_data').val(),
                    'number_of_data': $('#number_of_data').val(),
                    'guid': $('#guid').val(),
                    'hide_rawdata': $('#hide_rawdata').prop('checked'),
                    'type':'xlsx'
                }, function (data) {
            $('#message').html(data.message);
        }, "json"
                );

    });

  $("#merchant_id_summary").change(function(event){
    let merchantId = $('#merchant_id_summary').val()

    if (merchantId == '') {
      $('.hide-btn').hide()
    } else {
      $('.hide-btn').show() 
    }
    $.post(
        "<?php echo base_url('report/branch') ?>",
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
    console.log('l')
    $('.hide-btn').show()
  });

  $("#merchant_id").change(function(event){
    $.post(
        "<?php echo base_url('report/branch') ?>",
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

      $("#btnSubmitPayment").click(function (event) {
        $('#example').DataTable({
            "scrollX": true,
            "ordering": true,
            "bDestroy": true,
            "serverSide": true,
            "bFilter": false,
            "bLengthChange": true,
            "processing": true,
            "order": [[ 5, "desc" ]],
            "ajax": {
                "url": "<?php echo base_url('report/payment_data_search') ?>",
                "method" : "POST",
                "data": {
                    'year': $('#year').val(),
                    'month': $('#month').val(),
                    'invoice_no': $('#invoice_no').val(),
                    'merchant_id': $('#merchant_id').val(),
                    'branch_id': $('#branch_id').val(),
                    'search_acc': $('#search_acc').val(),
                    'merchantname': $('#merchantname').val(),
                    'wallet': $('#wallet').val(),
                    'merchant_owner': $('#merchant_owner').val(),
                    'biller_owner': $('#biller_owner').val(),
                    'payment_status': $('#payment_status').val(),
                    'biller_status': $('#biller_status').val(),
                    'itemtype': $('#itemtype').val(),
                    'guid': $('#guid').val(),
                    'hide_rawdata': $('#hide_rawdata').prop('checked')
                }
            }
        });
    });
      $("#btnExportPaymentCsv").click(function (event) {
          $('#message').html("Harap tunggu, server sedang menggenerate file report!");

          $.post(
              "<?php echo base_url('report/payment_report_xlsx/csv') ?>",
              {
                  'year': $('#year').val(),
                  'month': $('#month').val(),
                  'bill_no': $('#bill_no').val(),
                  'merchant_id': $('#merchant_id').val(),
                  'branch_id': $('#branch_id').val(),
                  'search_acc': $('#search_acc').val(),
                  'search_mtrx': $('#search_mtrx').val(),
                  'merchantname': $('#merchantname').val(),
                  'biller': $('#biller').val(),
                  'wallet': $('#wallet').val(),
                  'merchant_owner': $('#merchant_owner').val(),
                  'biller_owner': $('#biller_owner').val(),
                  'payment_status': $('#payment_status').val(),
                  'biller_status': $('#biller_status').val(),
                  'itemtype': $('#itemtype').val(),
                  'start_data': $('#start_data').val(),
                  'number_of_data': $('#number_of_data').val(),
                  'guid': $('#guid').val(),
                  'hide_rawdata': $('#hide_rawdata').prop('checked')
              }, function (data) {
                  $('#message').html(data.message);
              }, "json"
          );

      });

    $('#btnExportPaymentPdf').click(function(event) {
      $('#frmReportPayment').submit()
    });

    $("#btnExportPaymentXlsx").click(function (event) {
        $('#message').html("Harap tunggu, server sedang menggenerate file report!");

        $.post(
                "<?php echo base_url('report/payment_report_xlsx/xlsx') ?>",
                {
                    'year': $('#year').val(),
                    'month': $('#month').val(),
                    'bill_no': $('#bill_no').val(),
                    'merchant_id': $('#merchant_id').val(),
                    'branch_id': $('#branch_id').val(),
                    'search_acc': $('#search_acc').val(),
                    'search_mtrx': $('#search_mtrx').val(),
                    'merchantname': $('#merchantname').val(),
                    'biller': $('#biller').val(),
                    'wallet': $('#wallet').val(),
                    'merchant_owner': $('#merchant_owner').val(),
                    'biller_owner': $('#biller_owner').val(),
                    'payment_status': $('#payment_status').val(),
                    'biller_status': $('#biller_status').val(),
                    'itemtype': $('#itemtype').val(),
                    'start_data': $('#start_data').val(),
                    'number_of_data': $('#number_of_data').val(),
                    'guid': $('#guid').val(),
                    'hide_rawdata': $('#hide_rawdata').prop('checked'),
                    'type':'xlsx'
                }, function (data) {
            $('#message').html(data.message);
        }, "json"
                );

    });

    $("#btnSubmitMonitoring").click(function (event) {
        $('#example').DataTable({
            "scrollX": true,
            "ordering": true,
            "bDestroy": true,
            "serverSide": true,
            "bFilter": false,
            "bLengthChange": true,
            "processing": true,
            "order": [[ 2, "asc" ]],
            "pageLength": 50,
            "ajax": {
                "url": "<?php echo base_url('report/monitoring_data_search') ?>",
                "method" : "POST",
                "data": {
                    'merchant_id': $('#merchant_id').val(),
                    'branch_id': $('#branch_id').val(),
                    'start_date': $('#start_date').val(),
                    'end_date': $('#end_date').val(),
                    'empty_only':$('#empty_data').is(":checked")
                }
            },
            "createdRow": function( row, data, dataIndex){
                if( data[2] ==  0){
                    $(row).addClass('zeroTransaction');
                }
            }
        });
    });
 });
</script>

</body>
</html>

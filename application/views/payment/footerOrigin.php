
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
<!-- SweetAlert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- page script -->
<script src="<?php echo assets_site;?>plugins/jQuery/jquery.numeric.min.js"></script>

<script type="text/javascript">
    var id;
function getmdr(obj) {
    //id=obj.id;
    document.getElementById("pgid").value=obj.id;
    document.getElementById("total_bayar").value=obj.value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    document.getElementById("mdr").value=(parseInt(obj.value) - parseInt((document.getElementById("jumlah").value).replace(/\./g, '')));
    // var total = parseInt(document.getElementById("total").value);
    // var tagihan = parseInt(document.getElementById("tagihan").value);
    // var bayar = 0;

    // if(document.getElementById("bayar").value==null || document.getElementById("bayar").value==""){
    //   bayar=0;
    // }else{
    //   bayar = parseInt(document.getElementById("bayar").value);
    // }
    // document.getElementById("total_bayar").value=((total - tagihan) + bayar);
 }
var t1="2";
var t2="2";
var t3="2";
var t4="2";
 
function success() {
    if(document.getElementById('tax').value==""){
     document.getElementById('tax').value = document.getElementById('tagihan').value;
    }

    var ele = document.getElementsByName('paymentgateway'); 
              
    for(i = 0; i < ele.length; i++) { 
      if(ele[i].checked){
        if(ele[i].value=='bni'){
           document.getElementById("detailform").action = "<?php echo site_url('payment2/checkout');?>";
        }else{
           document.getElementById("detailform").action = "<?php echo site_url('payment/checkout');?>";  
        }
      }   
    } 
    
    document.getElementById("detailform").submit();
}

function pay() {
  if(document.getElementById('total_bayar').value==""){
    swal({icon: "warning", title: "Mohon memilih payment gateway!",closeOnClickOutside: false});
  }else{
    document.getElementById("checkoutform").submit();
  }
}

  $(document).ready(function() {
    var rawdata = $('#hide_rawdata').val();

    // $('#example').DataTable( {
    //     "processing": true,
    //     "serverSide": true,
    //     "ajax": "<?php echo base_url('report/transaction_data');?>",
    //     "scrollX":true
    // } );

    var month = new Date().getMonth() + 1;
    var monthname=["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
    for(var i=1;i<month;i++){
      $('#month').append('<option value="'+i+'">'+monthname[i-1]+'</option>');
    }
    $('#month').val(month-1);
    $('#year').change(function(){
      $('#month').empty();
      if($('#year').val() == (new Date().getFullYear())){
        for(var i=0;i<month;i++){
          $('#month').append('<option value="'+i+'">'+monthname[i]+'</option>');
        }
      }else{
        for(var i=1;i<13;i++){
          $('#month').append('<option value="'+i+'">'+monthname[i-1]+'</option>');
        }
      }
    });

    //Date picker
    $('#start_date').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy',
      todayHighlight: true,
      defaultDate: new Date()
    });

    $('#end_date').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy',
      todayHighlight: true,
      defaultDate: new Date()
    });

    $('#example').on('click', 'a.editor_edit', function (e) {
        e.preventDefault();
        var table = $('#example').DataTable();
        var data = table.row( $(this).parents('tr') ).data();
        window.location.href = 'http://103.108.126.174/cms_bprd/payment/checkout?amount=' + data[3];
    } );

    $('#bnihistory').DataTable({
                "scrollX": true,
                "ordering": true,
                "bDestroy": true,
                "serverSide": true,
                "bFilter": false,
                "bLengthChange": true,
                "processing": true,
                "ajax": {
                    "url": "<?php echo base_url('payment2/bni_history') ?>",
                    "method" : "POST",
                    "data": {
                        'guid': $('#guid').val(),
                        'hide_rawdata': $('#hide_rawdata').prop('checked')
                    },
                } 
            });
    
    $("#btnUpdate").click(function (event) {
      if ( $('#customer_name').is('[readonly="readonly"]') ) {
        $("#customer_name").removeAttr("readonly");
        $("#customer_email").removeAttr("readonly");
        $("#customer_phone").removeAttr("readonly");

        $(this).val('Update');
      }else{
        $('#frmUpdate').submit();
      }
    });

    $("#btnCancel").click(function (event) {
      if ( $('#customer_name').is('[readonly="readonly"]') ) {
          window.location.href = "<?php echo base_url('payment2/checkbilling')?>";
      }else{
        $("#customer_name").attr('readonly', true);
        $("#customer_email").attr('readonly', true);
        $("#customer_phone").attr('readonly', true);

        $("#customer_name").val($("#customer_name_ori").val());
        $("#customer_email").val($("#customer_email_ori").val());
        $("#customer_phone").val($("#customer_phone_ori").val());
        
        $("#btnUpdate").val("Edit");
      }
    });

    $("#btnSubmitTransaction").click(function (event) {
        $('#example').DataTable({
            "scrollX": true,
            "ordering": true,
            "bDestroy": true,
            "serverSide": true,
            "bFilter": false,
            "bLengthChange": true,
            "processing": true,
            "order": [[ 2, "desc" ]],
            "ajax": {
                "url": "<?php echo base_url('payment/payment_data_search') ?>",
                "method" : "POST",
                "data": {
                    // 'start_date': $('#start_date').val(),
                    // 'end_date': $('#end_date').val(),
                    'year': $('#year').val(),
                    'month': $('#month').val(),
                    'merchant_id': $('#merchant_id').val(),
                    'branch_id': $('#branch_id').val(),
                    'hide_rawdata': $('#hide_rawdata').prop('checked')
                }
            }
            // ,columns: [
            // { data: "0" },
            // { data: "1" },
            // { data: "2" },
            // { data: "3" },
            // {
            //     data: null,
            //     className: "center",
            //     defaultContent: '<a href="" class="editor_edit">Pay</a>'
            // }
            // ]
        });
    });

    $("#btnPay").click(function (event) {
        $.post(
              "<?php echo base_url('payment/PaidChecker') ?>",
              {
                  // 'start_date': $('#start_date').val(),
                  // 'end_date': $('#end_date').val(),
                  'year': $('#year').val(),
                  'month': $('#month').val(),
                  'merchant_id': $('#merchant_id').val(),
                  'branch_id': $('#branch_id').val()
              }, function (data) {
                  var x = data['status'];
                  if(x.trim() === 'true'){
                    swal({icon: "error", title: "Transaksi dengan periode yang anda pilih sudah terbayar",closeOnClickOutside: false});
                    //alert('Transaction within the date range has already paid')
                  }else{
                    $('#frmReport').attr("action", "payment/detail");
                    $('#frmReport').submit();
                  }
              }, "json"
        );
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

  $('#tax').keypress(function(event) {
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }
  });

  $('#tax').keyup(function(event) {
            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40){

            }else{
              // format number
              $(this).val(function(index, value) {
                return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                ;
              });
              if($(this).val() == $('#tagihan').val()){
                $("#note").val('');
                $("#note").attr("disabled","disabled");
              }else{
                $("#note").removeAttr("disabled");
                
              }
            }           
  });

  $("#bayar").keyup(function(){
      var tagihan = parseInt(document.getElementById("tagihan").value);
      var total = parseInt(document.getElementById("total").value);
      var bayar = parseInt($(this).val());

      if($(this).val()==null || $(this).val()==""){
        if(document.getElementById("total").value==null || document.getElementById("total").value==""){
          document.getElementById("total_bayar").value="";
        }else{
          document.getElementById("total_bayar").value=(total - tagihan);
        }
      }else{
        if(document.getElementById("total").value==null || document.getElementById("total").value==""){
          document.getElementById("total_bayar").value=(bayar);
        }else{
          document.getElementById("total_bayar").value=((total - tagihan) + bayar);
        }
        
      }
       
  });

  $("#btn-sptpd").click(function (e) {
    e.preventDefault()
    let el = $(this)
    console.log(el.attr('href'))
    window.location.href = el.attr('href');
  });
 });
</script>

</body>
</html>

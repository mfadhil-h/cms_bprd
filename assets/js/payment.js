var id;
function getmdr(obj) {

    document.getElementById("pgid").value=obj.id;
    document.getElementById("total_bayar").value=obj.value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    document.getElementById("mdr").value=(parseInt(obj.value) - parseInt((document.getElementById("jumlah").value).replace(/\./g, '')));

}
var t1="2";
var t2="2";
var t3="2";
var t4="2";

function success() {
    if($('#tax').value=="" ){
      $('#tax').value = document.getElementById('tagihan').val();
    }

    if ($('#tax').val() == 0 ) {
      toastr['warning']('Total pajak yang dibayarkan harus lebih dari 0')
      return false
    }


    var ele = document.getElementsByName('paymentgateway');
    let checked = $('.check')
    let taxAdjustment = $('.tax-adjustment')
    let detailBranch = []
    let detailTax = []
    let taxValue = 0
    let branchId = ''

    taxAdjustment.each(function() {
      taxValue = $(this).val()
      taxValue = taxValue.replace(/[^a-zA-Z0-9 ]/g, "")
      branchId = $(this).attr('data-banch')
      if (($(this).attr('disabled') == 'disabled')) {
        detailTax.push(taxValue)
        detailBranch.push(branchId)
      }
    })

    $('input[name="detail_tax"]').val(detailTax)
    $('input[name="detail_branch"]').val(detailBranch)

    for(i = 0; i < ele.length; i++) {
      if(ele[i].checked){
        if(ele[i].value=='bni'){
           document.getElementById("detailform").action =  $('#btnKlaim').attr('href');
        }else{
           document.getElementById("detailform").action = "payment/checkout";
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
    $('#example').dataTable()
    var rawdata = $('#hide_rawdata').val();

    var month = new Date().getMonth() + 1;
    var monthname=["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
    for(var i=1;i<month;i++){
      $('#month').append('<option value="'+i+'">'+monthname[i-1]+'</option>');
    }
    $('#month').val(month-1);
    $('#year').change(function(){
      $('#month').empty();
      if($('#year').val() == (new Date().getFullYear())){
        for(var i=1;i<=month;i++){
          $('#month').append('<option value="'+i+'">'+monthname[i-1]+'</option>');
        }
      }else{
        for(var i=1;i<13;i++){
          $('#month').append('<option value="'+i+'">'+monthname[i-1]+'</option>');
        }
      }
    });

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
              "url": "/cms_bprd/payment2/bni_history",
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
            window.location.href = "/cms_bprd/payment2/checkbilling";
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
          let merchantId = $('select[name="merchant_id"]').val()
          let branchId = $('select[name="branch_id"]').val()
          let year = $('select[name="year"]').val()
          let month = $('select[name="month"]').val()
          let element = $('#example').find('tbody')
          let tax = 0

          if ($('#year').val() == '') {
            toastr['warning']('Tahun is required')
            return false
          }
          if (merchantId == '') {
            toastr['warning']('Merchant is required')
            return false
          }

          if (branchId == '') {
            toastr['warning']('Pilh Branch Untuk menampilkan data')
            return false
          }

          $.post(
            "/cms_bprd/payment/get_data_payment",
            {
                'merchant_id' : merchantId,
                'branch_id'   : branchId,
                'year'      : year,
                'month'    : month
            }, function (data) {
              $('#example').DataTable().clear().destroy();
                if (data.length == 0) {
                  $('#example').dataTable().fnDestroy()
                  $('#example').dataTable()
                } else {
                    for(var i=0;i<data.length;i++) {
                      tax   = data[i]['tax'].replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                      $(element).append( `<tr>
                                        <td>${data[i]['merchant_name']}</td>
                                        <td>${data[i]['branch_name']}</td>
                                        <td>${data[i]['bill_date']}</td>
                                        <td>${tax}</td>
                                        </tr>`);
                    }
                    $('#example').dataTable().fnDestroy()
                    $('#example').dataTable()
                  }
        },"json"
        );
      });

      $("#btnPay").click(function (event) {
          let merchantId = $('select[name="merchant_id"]').val()
          let branchId = $('select[name="branch_id"]').val()

          if ($('#year').val() == '') {
            toastr['warning']('Tahun is required')
            return false
          }
          if (merchantId == '') {
            toastr['warning']('Merchant is required')
            return false
          }

          if (branchId == '') {
            toastr['warning']('Pilih Branch Untuk melanjutkan pembayaran')
            return false
          }

          $.post(
                "payment/PaidChecker",
                {
                    'year': $('#year').val(),
                    'month': $('#month').val(),
                    'merchant_id': $('#merchant_id').val(),
                    'branch_id': $('#branch_id').val()
                }, function (data) {
                    var x = data['status'];
                    if(x.trim() === 'true'){
                      toastr['warning']('Periode Transaksi yang dipilih sudah terbayrakan')
                      return false
                    }else{
                      $('#frmReport').attr("action", "payment/detail");
                      $('#frmReport').submit();
                    }
                }, "json"
          );
      });

    	$("#merchant_id").change(function(event){
  	    $.post(
  	        "report/branch",
  	                {
  	                    'merchant_id': $('#merchant_id').val(),
  	                }, function (data) {
  	                  $('#branch_id').find('option').remove();
  	                  $('#branch_id').append('<option value="">--Pilih Otlet--</option>');

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
              if(event.which >= 37 && event.which <= 40){

              }else{
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

    $('input[name="tax_adjustment"]').keypress(function(event) {
      if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
      }
    });

    $('input[name="tax_adjustment"]').keyup(function(event) {
        if(event.which >= 37 && event.which <= 40){

        }else{
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

    $('#check_all').click(function(e) {
      let taxAdjustment = $('.tax-adjustment')
      let totalTaxValue = 0
      if (this.checked) {

        taxAdjustment.each(function() {
          taxValue = $(this).val()
          taxValue = taxValue.replace(/[^a-zA-Z0-9 ]/g, "")
          totalTaxValue = parseFloat(taxValue) + parseFloat(totalTaxValue)
        })

        $('#tax').val(totalTaxValue)
        totalTaxValue = totalTaxValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        $('#tax_total').val(totalTaxValue)

        $('.check').prop('checked', true)
        $('.btn_sptpd').prop('disabled', false)
        $('input[name="tax_adjustment"]').prop('disabled', true)
      } else {
        $('.check').prop('checked', false)
        $('.btn_sptpd').prop('disabled', true)
        $('input[name="tax_adjustment"]').prop('disabled', false)
        $('#tax').val(0)
        $('#tax_total').val(0)
      }
    })

    $('.check').click(function (e) {
      let el    = $(this)
      let tax   = el.closest('tr').find('input[type="text"]').val()
      let total = $('#tax_total').val()

      tax = tax.replace(/[^a-zA-Z0-9 ]/g, "")
      total = total.replace(/[^a-zA-Z0-9 ]/g, "")

      if (this.checked) {
        el.closest('tr').find('input[type="text"]').prop('disabled', true)
        el.closest('td').next().find('input[type="button"]').prop('disabled' , false)

        total = parseFloat(total) + parseFloat(tax)

        $('#tax').val(total)
        total = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        $('#tax_total').val(total)
      } else {
        el.closest('tr').find('input[type="text"]').prop('disabled', false)
        el.closest('td').next().find('input[type="button"]').prop('disabled' , true)

        total = total - tax
        if (total < 0) {
          total = 0
        }

        $('#tax').val(total)
        total = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        $('#tax_total').val(total)
      }

    })

    $('.btn_sptpd').click(function(e) {
      e.preventDefault()
      let el = $(this)
      window.open(el.attr('href'))
    })

    $('.btn_sptpd_payment').click(function(e) {
      e.preventDefault()
      let el = $(this)
      window.open(el.attr('href'))
    })

    $('.btn_note').click(function(e) {
        e.preventDefault()
        let el = $(this)
        window.open(el.attr('href'))
    })

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
      	} else {
	        if(document.getElementById("total").value==null || document.getElementById("total").value==""){
	          document.getElementById("total_bayar").value=(bayar);
	        }else{
	          document.getElementById("total_bayar").value=((total - tagihan) + bayar);
	        }
      	}

  	});
});

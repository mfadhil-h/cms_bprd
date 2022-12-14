<script type="text/javascript">
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;
}

function RupiahFormat (objek) { 
 separator = "."; 
 a = objek.value; 
 b = a.replace(/[^\d]/g,""); 
 c = ""; 
 panjang = b.length; 
 j = 0; for (i = panjang; i > 0; i--) { 
 j = j + 1; if (((j % 3) == 1) && (j != 1)) { 
 c = b.substr(i-1,1) + separator + c; } else { 
 c = b.substr(i-1,1) + c; } } objek.value = c; 
} 

</script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>-->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-12">
            <div class="box box-default">
                <div class="box-body">
                <?php echo $output; ?>
                </div>
            </div>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

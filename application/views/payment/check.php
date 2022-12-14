  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cek Tagihan
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Cek Tagihan</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-12">
          <!-- ./box -->
            <div class="box box-default">
                <div class="box-body">
                 <form action = "<?php echo site_url('/payment2/inquirybilling');?>" method="POST" id="checkoutform" enctype="multipart/form-data">
                            <div class="tab-content panel-body">
                      <div class="tab-pane fade in active" id="basic-tab1">
                      <div class="form-group has-feedback">
                      <label>Billing ID :</label>
                      <input type="text" class="form-control" name="trx_id" id="trx_id">
                      </div>
                    <input type="submit" name="btnInquiry" id="btnInquiry" value="Inquiry" class="btn btn-primary">
                                </div>
                            </div>
               </form>
                </div>
                <!-- ./box-body -->
            </div>
            <!-- ./box -->
        </div>
        <!-- ./col-lg-12 -->
      </div>

            <div class="row">
        <div class="col-lg-12">
          <div class="box box-info">
            <!-- <div class="box-header with-border">
              <h3 class="box-title">List Staff</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" type="button" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" type="button" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
            </div> -->
        <div class="box-body">
          <div class="row">
            <div class="col-lg-12">
            <table id="bnihistory" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                  <thead>
                      <tr>
                                    <th>Nomor VA</th>
                                    <th>Billing Id</th>
                                    <th>Nama</th>
                                    <th>No Telepon</th>
                                    <th>Email</th>
                                    <th>Nomor Invoice</th>
                                    <th>Tanggal Pembuatan</th>
                                </tr>
                            </thead>
              </table>
            </div>
          </div>
        </div>
          </div>
          <!-- ./box -->
        </div>
        <!-- ./col-lg-12 -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
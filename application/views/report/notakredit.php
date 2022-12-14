<div class="content-wrapper" style="min-height:941px">
    <section class="content-header">
        <h1>
            Nota Kredit
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Laporan</a></li>
            <li class="active">Nota Kredit</li>
        </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-lg-12">
            <!-- ./box -->
            <div class="box box-default">
                <div class="box-body">
                    <form name="frmReportTransaction" id="frmReportTransaction" class="form-horizontal" action="<?php echo base_url("notakredit/load_data") ?>" method="post" enctype="multipart/form-data">
                        <div class="col-sm-12">
                            <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="start_date">Tanggal Nota :</label>
                                    <div class="col-sm-8">
                                       <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control date-picker data-date" name="date_start" id="date_start" autocomplete="off">
                                            <input type="hidden" name="start_date" id="start_date">
                                        </div>
                                    </div>
                                </div>
							<div class="form-group col-sm-3"><button type="submit" name="btnTransactionPpdf" id="btnTransactionPpdf" class="btn btn-danger">Tampilkan Nota</button></div>	
                        </div>
						
                        <br />
                        </form>
                        <br />
						
                                                
                        <br />
                        <br />
                        <span id="message" style="background-color: lime;"></span>
                </div>
            </div>
        </div>
        </div>
    </section>
</div>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Data Monitoring
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Laporan</a></li>
        <li class="active">Data Monitoring</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-lg-12">
            <div class="box box-default">
                <div class="box-body">
                    <form name="form-data-monitoring" id="form-data-monitoring" class="form-horizontal" action="<?php echo base_url('report/transaction_report_pdf') ?>" method="post">
                        <div class="col-sm-12">
                            <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="start_date">Tanggal Mulai :</label>
                                    <div class="col-sm-8">
                                       <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control date-picker data-date" name="date_start" id="date_start" autocomplete="off">
                                            <input type="hidden" name="start_date" id="start_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="end_date">Tanggal Akhir :</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control date-picker data-date" name="date_end" id="date_end" autocomplete="off">
                                            <input type="hidden" name="end_date" id="end_date">
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <?php if ($_SESSION['level']<5): ?>
                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="merchant_id">Wajib Pajak :</label>
                                    <div class="col-sm-8">
                                        <select name="merchant_id" id="merchant_id" class="select form-control">
                                        <?php if ($_SESSION['level']<4): ?>
                                            <option value="ALL">ALL</option>
                                        <?php endif ?>
                                            <?php for ($i=0;$i<count($merchants);$i++): ?>
                                                <option value=<?php echo $merchants[$i]['merchant_id'] ?> ><?php echo $merchants[$i]['merchant_name'] ?></option>
                                            <?php endfor ?>
                                       
                                        </select>
                                    </div>                                
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="branch_id">Outlet :</label>
                                    <div class="col-sm-8">
                                        <select name="branch_id" id="branch_id" class="select form-control">
                                            <option value="ALL">ALL</option>
                                            <?php if ($_SESSION['level']==4): ?>
                                                <?php for ($i=0;$i<count($branch);$i++): ?>
                                                    <option value=<?php echo $branch[$i]['branch_id'] ?> ><?php echo $branch[$i]['branch_name'] ?></option>
                                                <?php endfor ?> 
                                            <?php endif ?>
                                        </select>
                                    </div>                                
                                </div>
                                <?php if ($_SESSION['level'] != 3): ?>
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label" for="suban_id">Suku Badan Pajak:</label>
                                        <div class="col-sm-8">
                                            <select name="suban_id" id="suban_id" class="select form-control">
                                                <option value="ALL">ALL</option>
                                                <?php foreach ($subans as $rowSuban): ?>
                                                    <option value="<?php echo $rowSuban->suban_id ?>"><?php echo $rowSuban->suban_name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>                                
                                    </div>
                                <?php endif ?>
                            </div>
                        <?php else: ?>
                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="branch_id">Outlet :</label>
                                    <div class="col-sm-8">
                                        <select name="branch_id" id="branch_id" class="select form-control">
                                        <?php if ($_SESSION['level']==5): ?>
                                            <option value="ALL">ALL</option>
                                        <?php endif ?>
                                            <?php for ($i=0;$i<count($branch);$i++): ?>
                                                <option value=<?php echo $branch[$i]['branch_id'] ?>><?php echo $branch[$i]['branch_name'] ?></option>
                                            <?php endfor ?>
                                        </select>
                                    </div>                                
                                </div>
                                <?php if ($_SESSION['level'] != 3): ?>
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label" for="suban_id">Suku Badan Pajak:</label>
                                        <div class="col-sm-8">
                                            <select name="suban_id" id="suban_id" class="select form-control">
                                                <option value="ALL">ALL</option>
                                                <?php foreach ($subans as $rowSuban): ?>
                                                    <option value="<?php echo $rowSuban->suban_id ?>"><?php echo $rowSuban->suban_name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>                                
                                    </div>
                                <?php endif ?>
                            </div>
                        <?php endif ?>
                        <br />
                       
                        </form>
                        <br />
                        <input type="submit" name="btnSubmitTransaction" id="btnSubmitTransaction" value="Tampilkan Data" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <br />
                        <br />
                </div>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body table-responsive">
                </div>
            </div>
        </div>
      </div>
    </section>
</div>
<div class="content-wrapper">

    <section class="content-header">
      <h1>
        Add Branch
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('branch/index') ?>"><i class="fa fa-home"></i>Branch</a></li>
        <li class="active">Add Branch</li>
      </ol>
    </section>
    <section class="content">
        <div class="row selector">
            <div class="col-lg-12">
                <div class="box box-default">
                    <div class="box-body">
                        <form name="branch_form" id="branch_form" class="form-horizontal" action="<?php echo base_url('branch/store') ?>" method="post">
                            <div class="col-sm-12">
                                <div class="col-sm-6">
                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label" for="year">Branch Name :</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="branch_name" id="branch_name">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label" for="year">Merchant :</label>
                                        <div class="col-sm-8">
                                            <select name="merchant_id" id="merchant_id" class="select form-control">
                                            <?php
                                                foreach ($merchants as $val => $rowMerchant) {

                                                    echo '<option value ="'.$rowMerchant['merchant_id'].'">'.$rowMerchant['merchant_name'].'</option>';   
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label" for="year">Branch Type :</label>
                                        <div class="col-sm-8">
                                            <select name="bt_id" id="bt_id" class="select form-control">
                                            <?php
                                                foreach ($branchsType as $val => $rowBt) {

                                                    echo '<option value ="'.$rowBt['bt_id'].'">'.$rowBt['bt_desc'].'</option>';   
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label" for="year">Kecamatan :</label>
                                        <div class="col-sm-8">
                                            <select name="kec_id" id="kec_id" class="select form-control">
                                            <?php
                                                foreach ($kecamatans as $val => $rowKec) {

                                                    echo '<option value ="'.$rowKec['kec_id'].'">'.$rowKec['kec_name'].'</option>';   
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label" for="year">Location :</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="location" id="location">
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-sm-6">
                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label" for="year">NPWP :</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="npwp" id="npwp">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label" for="year">NOPD :</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="nopd" id="nopd">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label" for="year">PIC :</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="pic" id="pic">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label" for="year">Pos Code :</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="pos_code" id="pos_code">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label" for="year">No Telepon :</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="no_tlp" id="no_tlp">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label" for="year">email :</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="email" id="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label class="col-sm-8 control-label" for=""></label>
                                    <div class="col-sm-2">
                                       <button type="submit" name="btn-submit" btn-type="create" id="btn-submit" class="col-sm-12 btn btn-primary">Save</button>
                                    </div>
                                    <div class="col-sm-2">
                                       <button type="cancel" href="<?php echo base_url("branch/index") ?>" name="btn-cancel" id="btn-cancel" class="col-sm-12 btn btn-default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
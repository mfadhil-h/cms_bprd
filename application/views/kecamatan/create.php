<div class="content-wrapper">

	<section class="content-header">
      <h1>
        Add Kecamatan
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('kecamatan/index') ?>"><i class="fa fa-home"></i>Kecamatan</a></li>
        <li class="active">Add Kecamatan</li>
      </ol>
    </section>
    <section class="content">
    	<div class="row selector">
    		<div class="col-lg-12">
    			<div class="box box-default">
    				<div class="box-body">
    					<form name="kecamatan_form" id="kecamatan_form" class="form-horizontal" action="<?php echo base_url('kecamatan/store') ?>" method="post">
    						<div class="col-sm-12">
    							<div class="form-group col-sm-12">
    								<label class="col-sm-4 control-label" for="year">Nama Kecamatan*:</label>
                                	<div class="col-sm-8">
    									<input type="text" class="form-control" name="kec_name" id="kec_name">
    								</div>
    							</div>
    							<div class="form-group col-sm-12">
    								<label class="col-sm-4 control-label" for="suban_id">Suku Badan Pajak *:</label>
                                    <div class="col-sm-8">
                                        <select name="suban_id" id="suban_id" class="select form-control">
                                            <?php
                                                foreach ($subans as $val => $rowSuban) {

                                                    echo '<option value ="'.$rowSuban['suban_id'].'">'.$rowSuban['suban_name'].'</option>';   
                                                }
                                            ?>
                                            
                                        </select>
                                    </div>
    							</div>
    							<div class="form-group col-sm-12">
                                    <label class="col-sm-8 control-label" for=""></label>
                                    <div class="col-sm-2">
                                       <button type="submit" name="btn-submit" btn-type='create' id="btn-submit" class="col-sm-12 btn btn-primary">Simpan</button>
                                    </div>
                                    <div class="col-sm-2">
                                       <button type="cancel" href="<?php echo base_url("kecamatan/index") ?>" name="btn-cancel" id="btn-cancel" class="col-sm-12 btn btn-default">Batal</button>
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
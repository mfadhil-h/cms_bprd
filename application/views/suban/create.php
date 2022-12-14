<div class="content-wrapper">

	<section class="content-header">
      <h1>
        Add Suku Badan Pajak 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('suban/index') ?>"><i class="fa fa-home"></i>Suku Badan Pajak </a></li>
        <li class="active">Add Suku Badan Pajak </li>
      </ol>
    </section>

    <section class="content">
    	<div class="row selector">
    		<div class="col-lg-12">
    			<div class="box box-default">
    				<div class="box-body">
    					<form name="suban_form" id="suban_form" class="form-horizontal" action="<?php echo base_url('suban/store') ?>" method="post">
    						<div class="col-sm-12">
    							<div class="form-group col-sm-12">
    								<label class="col-sm-4 control-label" for="year">Suban Name* :</label>
                                	<div class="col-sm-8">
    									<input type="text" class="form-control" name="suban_name" id="suban_name">
    								</div>
    							</div>
    							<div class="form-group col-sm-12">
                                    <label class="col-sm-8 control-label" for=""></label>
                                    <div class="col-sm-2">
                                       <button type="submit" name="btn-submit" btn-type="create" id="btn-submit" class="col-sm-12 btn btn-primary">Save</button>
                                    </div>
                                    <div class="col-sm-2">
                                       <button type="cancel" href="<?php echo base_url("suban/index") ?>" name="btn-cancel" id="btn-cancel" class="col-sm-12 btn btn-default">Cancel</button>
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
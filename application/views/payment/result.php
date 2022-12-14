<div class="content-wrapper">
	<section class="content-header">
    	<h1>
    		Pembayaran Pajak
     	</h1>
    	<ol class="breadcrumb">
    		<li><a href="#"><i class="fa fa-home"></i> Pembayaran Pajak</a></li>
    	</ol>
    </section>
    <section class="content">
    	<div class="row">
    		<div class="col-lg-12">
            	<div class="box box-default">
                	<div class="box-body">
                		<form action = "<?php echo site_url('/');?>" method="POST" id="checkoutform" enctype="multipart/form-data">
                            <div class="tab-content panel-body">
                      			<div class="tab-pane fade in active" id="basic-tab1">
                    				<?php if($status=='000'): ?>
	                   					<div class="form-group has-feedback">
		                       				<label>VA Number :</label>
		                      				<input type="text" class="form-control" name="pname" id="pname" readonly="readonly" value="<?php echo $virtual_account;?>">
	                                    </div>
					                    <div class="form-group has-feedback">
						                    <label>Billing ID :</label>
						                    <input type="text" class="form-control" name="jumlah" id="jumlah" readonly="readonly" value="<?php echo $trx_id;?>">
					                    </div>
                                        <div class="form-group has-feedback">
                                            <label>Kode Bayar :</label>
                                            <input type="text" class="form-control" name="kode_bayar" id="kode_bayar" readonly="readonly" value="<?php echo $kode_bayar;?>">
                                        </div>
					                    <div class="form-group has-feedback">
					                    	<label>Billing Amount :</label>
					                    	<input type="text" class="form-control" name="total_bayar" id="total_bayar" readonly="readonly" value="<?php echo 'IDR '.number_format($trx_amount,0,',','.');?>">
					                    </div>
                    				<?php else: ?>
				                      	<div class="form-group has-feedback">
					                    	<label>Status :</label>
					                     	<input type="text" class="form-control" name="status" id="status" readonly="readonly" value="<?php echo $message;?>">
				                      	</div>
                    				<?php endif; ?>
                    					<input type="submit" name="btnHome" id="btnHome" value="Menu Awal" class="btn btn-primary">
                                </div>
                            </div>
               			</form>
                	</div>
            	</div>
        	</div>
    	</div>
    </section>
</div>
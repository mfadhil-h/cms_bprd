<div class="content-wrapper">
	<section class="content-header">
		<h1>
        	Detil
    	</h1>
      	<ol class="breadcrumb">
        	<li><a href="#"><i class="fa fa-home"></i> Laporan</a></li>
        	<li class="active">Detil</li>
      	</ol>
	</section>
	<section class="content">
    	<div class="row">
        	<div class="col-lg-12">
            	<div class="box box-default">
                	<div class="box-body">
                		<form name="frmReportDetail" id="frmReportDetail" class="form-horizontal" action="#" method="post">
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
                                    		<?php if ($_SESSION['level'] < 4): ?>
                                    			<option value="ALL">ALL</option>
                                    		<?php endif ?>
                                    		<?php for ($i=0;$i<count($merchants);$i++): ?>
                                    			<option value="<?php echo $merchants[$i]["merchant_id"]?>" ><?php echo $merchants[$i]["merchant_name"] ?></option>
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
                                    				<option value="<?php  echo $branch[$i]["branch_id"]?>" ><?php echo $branch[$i]["branch_name"]?></option>
                                    			<?php endfor ?>
                                        	<?php endif ?>
                                        </select>
                                    </div>                                
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 control-label" for="bill_no">No Bill:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="bill_no" id="bill_no" size="50">
                                    </div>                                
                                </div>
                                <?php if ($_SESSION['level'] !=3 ): ?>
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label" for="suban_id">Suku Badan Pajak: </label>
                                        <div class="col-sm-8">
                                            <select name="suban_id" id="suban_id" class="select form-control">
                                                <option value="ALL">ALL</option>
                                                <?php foreach ($subans as $rowSuban): ?>
                                                    <option value="<?php echo $rowSuban->suban_id ?>" > <?php echo $rowSuban->suban_name ?> </option>
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
	                                    <?php if ($_SESSION['level'] == 5): ?>
	                                    	<option value="ALL">ALL</option>
	                                    <?php endif ?>
	                                	<?php for ($i=0;$i<count($branch);$i++): ?>
	                        				<option value="<?php echo $branch[$i]["branch_id"] ?>" ><?php echo $branch[$i]["branch_name"]?></option>
	                        			<?php endfor ?>
	                                    </select>
	                                </div>                                
	                            </div>
	                            <div class="form-group col-sm-6">
	                                <label class="col-sm-4 control-label" for="bill_no">No Bill :</label>
	                                <div class="col-sm-8">
	                                    <input class="form-control" type="text" name="bill_no" id="bill_no" size="50">
	                                </div>                                
	                            </div>
                                <?php if ($_SESSION['level'] !=3 ): ?>
                                    <div class="form-group col-sm-6">
                                        <label class="col-sm-4 control-label" for="suban_id">Suku Badan Pajak: </label>
                                        <div class="col-sm-8">
                                            <select name="suban_id" id="suban_id" class="select form-control">
                                                <option value="ALL">ALL</option>
                                                <?php foreach ($subans as $rowSuban): ?>
                                                    <option value="<?php echo $rowSuban->suban_id ?>" > <?php echo $rowSuban->suban_name ?> </option>
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
                        <input type="submit" name="btnSubmitMember" id="btnSubmitMember" value="Tampilkan Data" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" name="btnExportMemberCsv" id="btnExportMemberCsv" value="Export Data (.CSV)" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" name="btnExportMemberXlsx" id="btnExportMemberXlsx" value="Export Data (.XLSX)" class="btn btn-success"> &nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="submit" href="<?php echo base_url('ReportDetail/print_report') ?>" name="btnExportMemberPdf" id="btnExportMemberPdf" class="btn btn-danger">Export Data(.PDF)</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        
                        <br />
                        <br />
                        <span id="message" style="background-color: lime;"></span>
                	</div>
           		</div>
        	</div>
      	</div>
      	<div class="row">
        	<div class="col-lg-12">
          		<div class="box box-info">
        			<div class="box-body">
          				<div class="row">
            				<div class="col-lg-12">
            					<table id="report_detail" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
			                  		<thead>
			                    		<tr>
			                        		<th>Wajib Pajak</th>
				                        	<th>Outlet</th>
				                       		<th>No Bill</th>
					                        <th>Tanggal</th>
					      					<th>Nama Item</th>
					                        <th>Jenis Item</th>
					                        <th>Harga Item</th>
					                        <th>Kuantitas</th>
					                        <th>Harga Item</th>
				                    	</tr>
			                  		</thead>
			            		</table>
           					</div>
          				</div>
        			</div>
    			</div>
       		 </div>
      	</div>
    </section>
</div>
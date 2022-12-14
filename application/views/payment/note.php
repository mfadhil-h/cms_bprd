<div class="content-wrapper">

	<section class="content-header">
      <h1>
        Add Self Asesstment / Note
      </h1>
      <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-home"></i>Self Asesstment / Note</a></li>
        <li class="active">Add Self Asesstment / Note</li>
      </ol>
    </section>
    <section class="content">
    	<div class="row selector">
    		<div class="col-lg-12">
    			<div class="box box-default">
    				<div class="box-body">
                        
    					<form name="note_form" id="note_form" class="form-horizontal" action="<?php echo base_url('note/store') ?>" method="post">
                            <input type="text" name="merchant_id" id="merchant_id" value=<?php echo $merchant_id;  ?>>
                        <input type="text" name="branch_id" id="branch_id" value=<?php echo $branch_id;  ?>>
                        <input type="text" name="year" id="year" value=<?php echo $year;  ?>>
                        <input type="text" name="month" id="month" value=<?php echo $month;  ?>></td>
    						<div class="col-sm-12">
                                <table id="note-list" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Bill Number</th>
                                            <th>Nilai Pajak</th>
                                            <th>Keterangan</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <?php if ($type =='create') { ?>
                                        <tbody>
                                        
                                        </tbody>
                                    <?php } else { ?>
                                        <tbody>
                                            <?php foreach ($data_note as $index => $row) { ?>
                                            <tr>
                                                <td><div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" class="form-control date-picker data-date" name="<?php echo 'date_'.$index ?>" id="<?php echo 'date_'.$index ?>" autocomplete="off" value ="<?php echo date('d F Y', strtotime($row['date_transaction'])) ?>">
                                                    <input type="hidden" name="<?php echo 'date_transaction_'.$index ?>" id="<?php echo 'date_transaction_'.$index ?>" value="<?php echo $row['date_transaction'] ?>">
                                                </div></td>
                                                <td>
                                                    <input type="text" class="form-control" name="<?php echo 'bill_number_'.$index ?>" id="<?php echo 'bill_number_'.$index ?>" value="<?php echo $row['bill_number'] ?>">
                                                </td>
                                                <td><input type="text" class="form-control tax text-right" name="<?php echo 'adjustment_value_'.$index ?>" id="<?php echo 'adjustment_value_'.$index ?>" value="<?php echo $row['adjustment_value'] ?>">
                                                    <input type="hidden" name="<?php echo 'merchant_id_'.$index ?>" id="<?php echo 'merchant_id_'.$index ?>" value="<?php echo $row['merchant_id'] ?>">
                                                    <input type="hidden" name="<?php echo 'branch_id_'.$index ?>" id="<?php echo 'branch_id_'.$index ?>"  value="<?php echo $row['branch_id'] ?>">
                                                    <input type="hidden" name="<?php echo 'year_'.$index ?>" id="<?php echo 'year_'.$index ?>" value="<?php echo $row['year'] ?>">
                                                    <input type="hidden"name="<?php echo 'month_'.$index ?>" id="<?php echo 'month_'.$index ?>" value="<?php echo $row['month'] ?>">
                                                    <input type="hidden"name="<?php echo 'id_'.$index ?>" id="<?php echo 'id_'.$index ?>" value="<?php echo $row['id'] ?>">
                                                    <input type="hidden" name="count" id="count" value="">
                                                    <input type="hidden" name="<?php echo 'id_'.$index ?>" value="<?php echo $row['id'] ?>">
                                                </td>
                                                <td><textarea  name="<?php echo 'note_'.$index ?>" class="form-control"  id="<?php echo 'note_'.$index ?>" class="col-sm-12"> <?php echo $row['note']; ?></textarea></td>
                                                <td data-note-id="<?php echo $row['id'] ?>"></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    <?php } ?>
                                </table>
    						</div>
                            <input type="hidden" name="type" value="<?php echo $type ?>">
                            <div class="ibox col-sm-12">
                                <div class="ibox-footer text-md-right">
                                    <a class="btn btn-sm btn-success default btn-add-axisting-data">Add Existing Data</a>
                                    <a class="btn btn-sm btn-warning default btn-add">Add Others Data</a>
                                    <button class="btn btn-sm btn-primary btn-submit mr-2" type="submit">Save</button>
                                    <a class="btn btn-sm btn-danger default" href="">Cancel</a>
                                </div>
                            </div>
    					</form>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>
</div>
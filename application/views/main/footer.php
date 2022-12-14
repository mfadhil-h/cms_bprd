<div>
	<script src="<?php echo assets_site;?>adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
	<script src="<?php echo assets_site;?>plugins/jQueryUI/jquery-ui.min.js"></script>
	<script>
	    $.widget.bridge('uibutton', $.ui.button);
	</script>
	<script src="<?php echo assets_site;?>adminlte/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo assets_site;?>adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo assets_site;?>adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo assets_site;?>adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>

	<link rel="stylesheet" href="<?php echo assets_site;?>adminlte/plugins/daterangepicker/daterangepicker.css"></link>
	<link rel="stylesheet" href="<?php echo assets_site;?>adminlte/plugins/datepicker/datepicker3.css"></link>

	<script src="<?php echo assets_site;?>adminlte/plugins/daterangepicker/moment.min.js"></script>
	<script src="<?php echo assets_site;?>adminlte/plugins/daterangepicker/daterangepicker.js"></script>

	<script src="<?php echo assets_site;?>adminlte/plugins/fastclick/fastclick.js"></script>
	<script src="<?php echo assets_site;?>adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="<?php echo assets_site;?>adminlte/dist/js/app.min.js"></script>

	<script src="<?php echo assets_site;?>adminlte/plugins/chartjs/Chart.js"></script>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	
	<script src="<?php echo assets_site;?>adminlte/dist/js/demo.js"></script>
	<script src="<?php echo assets_site;?>adminlte/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="<?php echo assets_site;?>adminlte/plugins/toastr/toastr.min.js"></script>
	<script src="<?php echo assets_site;?>adminlte/plugins/toastr-master/build/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo assets_site;?>adminlte/plugins/toastr-master/build/toastr.css">
	<link rel="stylesheet" href="<?php echo assets_site.'css/'.$class.'.css';?>"></link>
	<link rel="stylesheet" href="<?php echo assets_site;?>css/libs.css"></link>

	<link rel="stylesheet" type="text/css" href="<?php echo assets_site;?>adminlte/plugins/themify-icons/assets/themify-icons.css">
	<link rel="stylesheet" type="text/css" href="<?php echo assets_site;?>adminlte/plugins/line-awesome/css/line-awesome.min.css">

	<script src="<?php echo assets_site;?>js/libs.js"></script>
	<script src="<?php echo assets_site;?>jasonday-printthis/printThis.js"></script>
	<script src="<?php echo assets_site.'js/'.$class.'.js';?>"></script>

<div class="modal fade" id="global-modal" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title strong"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btnAction">OK</button>
                <button type="button" class="btn btn-secondary default" data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="global-child-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btnAction">OK</button>
                <button type="button" class="btn btn-secondary default" data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>
</div>
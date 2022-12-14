</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner" style="float:right;"> 2018 &copy; Surya Abadi Isolasi
        <!-- <a target="_blank" href="http://keenthemes.com">Keenthemes</a> &nbsp;|&nbsp;
        <a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Purchase Metronic!</a>-->
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!-- END FOOTER -->
</div>
<!-- BEGIN QUICK NAV -->
<div class="quick-nav-overlay"></div>
<!-- END QUICK NAV -->

<!-- BEGIN CORE PLUGINS -->
<script src="<?= base_url('assets/global/plugins/jquery.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/global/plugins/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/global/plugins/js.cookie.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') ?>"
        type="text/javascript"></script>
<script src="<?= base_url('assets/global/plugins/jquery.blockui.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') ?>"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<script src="<?= base_url('assets/global/plugins/jquery-ui/jquery-ui.min.js') ?>" type="text/javascript"></script>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?= base_url('assets/global/scripts/datatable.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/global/plugins/datatables/datatables.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') ?>"
        type="text/javascript"></script>
<script src="<?= base_url('assets/global/plugins/moment.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"
        type="text/javascript"></script>
<script src="<?= base_url('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') ?>"
        type="text/javascript"></script>


<script src="<?= base_url('assets/global/scripts/app.min.js') ?>" type="text/javascript"></script>

<script src="<?= base_url('assets/pages/scripts/table-datatables-buttons.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/global/plugins/select2/js/select2.full.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/pages/scripts/components-select2.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/pages/scripts/components-bootstrap-select.min.js') ?>"
        type="text/javascript"></script>
<script src="<?= base_url('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') ?>"
        type="text/javascript"></script>


<script src="<?= base_url('assets/pages/scripts/components-date-time-pickers.min.js') ?>"
        type="text/javascript"></script>
<script src="<?= base_url('assets/pages/scripts/ui-modals.min.js') ?>" type="text/javascript"></script>


<script src="<?= base_url('assets/layouts/layout/scripts/layout.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/layouts/layout/scripts/demo.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/layouts/global/scripts/quick-sidebar.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/layouts/global/scripts/quick-nav.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/global/default.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/global/loadingoverlay.js') ?>" type="text/javascript"></script>
<!--export excel basic table-->
<script src="<?= base_url('assets/apps/scripts/table-export/js/Blob.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/apps/scripts/table-export/js/xlsx.core.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/apps/scripts/table-export/js/FileSaver.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/apps/scripts/table-export/js/tableexport.js') ?>" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script>
    $('.dropdown-menu a.removefromcart').click(function (e) {
        e.stopPropagation();
    });

    jQuery(document).ready(function () {
        /*Session Group
         //alert("asdasdas");*/
        $("#group_name_sel").change(function () {

            var group_sel = $('#group_name_sel').val();
            $.ajax({
                type: 'GET',
                data: {group_sel: group_sel},
                url: '<?=base_url('change_session_group')?>',
                success: function (data) {
                    location.href = '<?=base_url('Home')?>';
                }
            });

        });
    });

</script>
</body>

</html>

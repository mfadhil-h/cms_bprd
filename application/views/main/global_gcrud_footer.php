
</div>
<!-- ./wrapper -->

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo assets_site;?>plugins/jQueryUI/jquery-ui.min.js"></script>
<?php foreach($js_files as $file): ?>
<script src="<?php echo str_replace('index.php/', '', $file); ?>"></script>
<?php endforeach; ?>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  //$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo assets_site;?>bootstrap/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo assets_site;?>adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo assets_site;?>adminlte/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo assets_site;?>adminlte/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo assets_site;?>adminlte/dist/js/pages/dashboard.js"></script>

</body>
</html>
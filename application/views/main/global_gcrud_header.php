<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo CMS_FULL_NAME;?> | Data Table</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo assets_site;?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo assets_site;?>adminlte/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo assets_site;?>adminlte/dist/css/skins/_all-skins.min.css">

  <!-- jQuery 2.2.3 -->
  <script src="<?php echo assets_site;?>adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.1/js/bootstrap-dialog.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <script type="text/javascript">
  $(function() {
    // $("#field-branch_id").prop( "disabled", true );
    $("#field-merchant_id").change(function (){
        $("#field-branch_id").find('option').remove();
        $.getJSON('<?php echo site_url('user/load_branch'); ?>/' + $(this).val(), function(data) {
          if(data==''){
            $("#field-branch_id").children().remove().end();
            $("#field-branch_id").attr('disabled', true);
            $("#field-branch_id").find('option').remove();
            $("#field-branch_id").append('<option value=""></option>');
            $("#field-branch_id").trigger("chosen:updated");
          }else{
            $("#field-branch_id").append('<option value=""></option>');
            $.each(data, function(key, val) {
              $("#field-branch_id").append($('<option></option>').val(val.value).html(val.property));
            });
            $("#field-branch_id").removeAttr('disabled');
            $("#field-branch_id").trigger("chosen:updated");
          }
          $("#field-branch_id").trigger("chosen:updated");
       });
    });
  });
</script>

  <?php
  foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo str_replace('index.php/','',$file); ?>" />
  <?php endforeach; ?>
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<div class="wrapper">

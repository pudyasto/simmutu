<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $template['title']; ?></title>
    <meta name="description" content="Sistem Manajemen Mutu Rumah Sakit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf" id="<?= $this->security->get_csrf_token_name(); ?>" 
          content="<?= $this->security->get_csrf_hash(); ?>">        
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.png'); ?>" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?= base_url('assets/adminbsb/plugins/bootstrap/css/bootstrap.css'); ?>" rel="stylesheet">
    <!-- Jquery Core Js -->
    <script src="<?= base_url('assets/adminbsb/plugins/jquery/jquery.min.js'); ?>"></script>
    <!-- Bootstrap Core Js -->
    <script src="<?= base_url('assets/adminbsb/plugins/bootstrap/js/bootstrap.js'); ?>"></script>
    
<body class="hold-transition skin-red sidebar-mini">
    <?php echo $template['body'];?>
<script type="text/javascript">
window.print();
</script>
<!-- ./wrapper -->
</body>
</html>

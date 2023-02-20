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

        <!-- Waves Effect Css -->
        <link href="<?= base_url('assets/adminbsb/plugins/node-waves/waves.css'); ?>" rel="stylesheet" />

        <link href="<?= base_url('assets/adminbsb/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet" />
        <link href="<?= base_url('assets/adminbsb/plugins/bootstrap-select/css/bootstrap-select.css'); ?>" rel="stylesheet" />
        <!-- Sweet Alert -->
        <link href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.css'); ?>"rel="stylesheet" >
        <!-- Chosen -->
        <link href="<?= base_url('assets/plugins/chosen/bootstrap-chosen.css'); ?>" rel="stylesheet">

        <!-- Animation Css -->
        <link href="<?= base_url('assets/adminbsb/plugins/animate-css/animate.css'); ?>" rel="stylesheet" />

        <!-- Morris Chart Css -->
        <link href="<?= base_url('assets/adminbsb/plugins/morrisjs/morris.css'); ?>" rel="stylesheet" />
        
        <!-- Datatable -->
        <link href="<?= base_url('assets/plugins/datatables/datatables.min.css'); ?>" rel="stylesheet" />

        <!-- Custom Css -->
        <link href="<?= base_url('assets/adminbsb/css/style.css'); ?>" rel="stylesheet">

        <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
        <link href="<?= base_url('assets/adminbsb/css/themes/all-themes.css'); ?>" rel="stylesheet" />
        <link href="<?= base_url('assets/custom/css/my.css'); ?>" rel="stylesheet" />

        <!-- Jquery Core Js -->
        <script src="<?= base_url('assets/adminbsb/plugins/jquery/jquery.min.js'); ?>"></script>

    </head>
    <body class="theme-red">
        <?php
            $class_name = $this->uri->segment(1);
            $menu_app = $this->rbac->menu_app($class_name);
//            var_dump($menu_app);
//            exit;
        ?>
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Silahkan Tunggu ...</p>
            </div>
        </div>
        <!-- #END# Page Loader -->
        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>
        <!-- #END# Overlay For Sidebars -->

        <!-- Top Bar -->
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" href="<?= site_url(); ?>"><?= $this->apps->title; ?></a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Notifications -->
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                                <i class="material-icons">notifications</i>
                                <span class="label-count">7</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">NOTIFICATIONS</li>
                                <li class="body">
                                    <ul class="menu">
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-light-green">
                                                    <i class="material-icons">person_add</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4>12 new members joined</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> 14 mins ago
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-cyan">
                                                    <i class="material-icons">add_shopping_cart</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4>4 sales made</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> 22 mins ago
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-red">
                                                    <i class="material-icons">delete_forever</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4><b>Nancy Doe</b> deleted account</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> 3 hours ago
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-orange">
                                                    <i class="material-icons">mode_edit</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4><b>Nancy</b> changed name</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> 2 hours ago
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-blue-grey">
                                                    <i class="material-icons">comment</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4><b>John</b> commented your post</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> 4 hours ago
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-light-green">
                                                    <i class="material-icons">cached</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4><b>John</b> updated status</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> 3 hours ago
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="icon-circle bg-purple">
                                                    <i class="material-icons">settings</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4>Settings updated</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> Yesterday
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="javascript:void(0);">View All Notifications</a>
                                </li>
                            </ul>
                        </li>
                        <!-- #END# Notifications -->
                        <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- #Top Bar -->
        <section>
            <!-- Left Sidebar -->
            <aside id="leftsidebar" class="sidebar">
                <!-- User Info -->
                <div class="user-info">
                    <div class="image">
                        <img src="<?= base_url('assets/img/user-green.png'); ?>" width="48" height="48" alt="User" />
                    </div>
                    <div class="info-container">
                        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $this->session->userdata('name'); ?></div>
                        <div class="email"><?= $this->session->userdata('email'); ?></div>
                        <div class="btn-group user-helper-dropdown">
                            <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="javascript:void(0);" class="btn-logout"><i class="material-icons">input</i>Sign Out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- #User Info -->

                <!-- Menu -->
                <div class="menu">
                    <ul class="list">
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="<?=($class_name==="main" || $class_name==="") ? "active" : "";?>">
                            <a href="<?= site_url(); ?>">
                                <i class="material-icons">home</i>
                                <span>Home</span>
                            </a>
                        </li>

                        <?php
                        $main_page_name = "";
                        $page_name = "";
                        $page_desc = "";
                        if (is_array($menu_app)) {
                            foreach ($menu_app['menus'] as $mn) {
                                if (!empty($mn['menu_name']) && $mn['link'] == "#") {
                                    if ($mn['sub']['submenu']) {
                                        ?>
                                        <li class="<?php echo $mn['active']; ?>">
                                            <a href="#" class="menu-toggle">
                                                <i class="material-icons"><?php echo $mn['icon']; ?></i>
                                                <span><?php echo $mn['menu_name']; ?></span>
                                            </a>
                                            <ul class="ml-menu">
                                                    <?php
                                                    foreach ($mn['sub']['submenu'] as $submn) {
                                                        if ($submn) {
                                                            if ($submn['sub_active']) {
                                                                $page_name = $submn['menu_name'];
                                                                $page_desc = $submn['description'];
                                                            }
                                                            ?>  
                                                            <li class="<?= $submn['sub_active']; ?>">
                                                                <a href="<?= site_url($submn['link']); ?>" title="<?= $submn['description']; ?>"><?= $submn['menu_name']; ?></a>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>   
                                            </ul>
                                        </li>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <li class="<?=$mn['active'];?>">
                                        <a href="<?php echo site_url($mn['link']); ?>" title="<?php echo $mn['description']; ?>">
                                            <i class="material-icons"><?php echo $mn['icon']; ?></i>
                                            <span><?php echo $mn['menu_name']; ?></span>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                        }
                        if (!$page_name || $class_name == "debug") {
                            $main_page_name = "Home";
                            $page_name = "Kesalahan";
                            $page_desc = "Halaman tidak ditemukan / Akses ditolak";
                        }
                        ?> 
                        <li class="header">AKUN</li>
                        <li>
                            <a href="javascript:void(0);">
                                <i class="material-icons col-light-blue">donut_large</i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="btn-logout">
                                <i class="material-icons col-red">donut_large</i>
                                <span>Log Out</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- #Menu -->
                <!-- Footer -->
                <div class="legal">
                    <div class="copyright">
                        &copy; 2018 <a href="javascript:void(0);"><?= $this->apps->copyright; ?></a>
                    </div>
                    <div class="version">
                        <b>Version: </b> <?= $this->apps->ver; ?>
                    </div>
                </div>
                <!-- #Footer -->
            </aside>
            <!-- #END# Left Sidebar -->
            <!-- Right Sidebar -->
            <aside id="rightsidebar" class="right-sidebar">
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="skins">
                        <ul class="demo-choose-skin">
                            <li data-theme="red">
                                <div class="red"></div>
                                <span>Red</span>
                            </li>
                            <li data-theme="pink">
                                <div class="pink"></div>
                                <span>Pink</span>
                            </li>
                            <li data-theme="purple">
                                <div class="purple"></div>
                                <span>Purple</span>
                            </li>
                            <li data-theme="deep-purple">
                                <div class="deep-purple"></div>
                                <span>Deep Purple</span>
                            </li>
                            <li data-theme="indigo">
                                <div class="indigo"></div>
                                <span>Indigo</span>
                            </li>
                            <li data-theme="blue">
                                <div class="blue"></div>
                                <span>Blue</span>
                            </li>
                            <li data-theme="light-blue">
                                <div class="light-blue"></div>
                                <span>Light Blue</span>
                            </li>
                            <li data-theme="cyan">
                                <div class="cyan"></div>
                                <span>Cyan</span>
                            </li>
                            <li data-theme="teal">
                                <div class="teal"></div>
                                <span>Teal</span>
                            </li>
                            <li data-theme="green">
                                <div class="green"></div>
                                <span>Green</span>
                            </li>
                            <li data-theme="light-green">
                                <div class="light-green"></div>
                                <span>Light Green</span>
                            </li>
                            <li data-theme="lime">
                                <div class="lime"></div>
                                <span>Lime</span>
                            </li>
                            <li data-theme="yellow">
                                <div class="yellow"></div>
                                <span>Yellow</span>
                            </li>
                            <li data-theme="amber">
                                <div class="amber"></div>
                                <span>Amber</span>
                            </li>
                            <li data-theme="orange">
                                <div class="orange"></div>
                                <span>Orange</span>
                            </li>
                            <li data-theme="deep-orange">
                                <div class="deep-orange"></div>
                                <span>Deep Orange</span>
                            </li>
                            <li data-theme="brown">
                                <div class="brown"></div>
                                <span>Brown</span>
                            </li>
                            <li data-theme="grey">
                                <div class="grey"></div>
                                <span>Grey</span>
                            </li>
                            <li data-theme="blue-grey">
                                <div class="blue-grey"></div>
                                <span>Blue Grey</span>
                            </li>
                            <li data-theme="black">
                                <div class="black"></div>
                                <span>Black</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </aside>
            <!-- #END# Right Sidebar -->
        </section>

        <section class="content">
            <div class="container-fluid animated fadeIn">
                <?php echo $template['body']; ?>
            </div>
        </section>
        
        
        <!-- Form Modal -->
        <div class="modal fade" id="form-modal" role="dialog" data-backdrop="static" aria-labelledby="form-modal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="form-modal-title" style="font-size: 18px;"></h4>
                    </div>
                    <div class="modal-body">
                        <div id="form-modal-content"></div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function base_url(param = ""){
                var base_url = '<?=base_url();?>' + "/" + param;
                return base_url;
            }
        </script>        
        <!-- Bootstrap Core Js -->
        <script src="<?= base_url('assets/adminbsb/plugins/bootstrap/js/bootstrap.js'); ?>"></script>

        <!-- Select Plugin Js -->
        <script src="<?= base_url('assets/adminbsb/plugins/bootstrap-select/js/bootstrap-select.js'); ?>"></script>

        <!-- Slimscroll Plugin Js -->
        <script src="<?= base_url('assets/adminbsb/plugins/jquery-slimscroll/jquery.slimscroll.js'); ?>"></script>

        <!-- Waves Effect Plugin Js -->
        <script src="<?= base_url('assets/adminbsb/plugins/node-waves/waves.js'); ?>"></script>

        <script src="<?= base_url('assets/adminbsb/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>

        <!-- Jquery CountTo Plugin Js -->
        <script src="<?= base_url('assets/adminbsb/plugins/jquery-countto/jquery.countTo.js'); ?>"></script>
        
        <!-- Datatable -->
        <script src="<?= base_url('assets/plugins/datatables/datatables.min.js'); ?>"></script>

        <script src="<?= base_url('assets/plugins/numeral/numeral.min.js'); ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.all.js'); ?>"></script> 
        <script src="<?= base_url('assets/plugins/chosen/chosen.jquery.js'); ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/plugins/moment/moment-with-locales.js'); ?>" type="text/javascript"></script>

        <!-- Custom Js -->
        <script src="<?= base_url('assets/adminbsb/js/admin.js'); ?>"></script>
        <script src="<?= base_url('assets/adminbsb/js/demo.js?v='.rand(1,10)); ?>"></script>
        <script src="<?= base_url('assets/custom/js/my.js'); ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/custom/js/main.js'); ?>" type="text/javascript"></script>
    </body>

</html>

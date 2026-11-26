<!DOCTYPE html>
<html>
<head>
 <meta charset='utf-8'>
 <meta http-equiv='X-UA-Compatible' content='IE=edge'>
 <title>Persediaan</title>
 <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
 <link href='<?= $url ?>/dist/img/favicon.png?v=<?= $versi ?>' rel='icon'>
 <link rel='stylesheet' href='<?= $url_asset ?>/bower_components/bootstrap/dist/css/bootstrap.min.css?v=<?= $versi ?>'>
 <link rel='stylesheet' href='<?= $url_asset ?>/bower_components/font-awesome/css/font-awesome.min.css?v=<?= $versi ?>'>
 <link rel='stylesheet' href='<?= $url_asset ?>/bower_components/Ionicons/css/ionicons.min.css?v=<?= $versi ?>'>
 <link rel='stylesheet' href='<?= $url_asset ?>/bower_components/timepicker/bootstrap-timepicker.min.css?v=<?= $versi ?>'>
 <link rel='stylesheet' href='<?= $url ?>/dist/css/AdminLTE.min.css?v=<?= $versi ?>'>
 <link rel='stylesheet' href='<?= $url ?>/dist/css/skins/_all-skins.min.css?v=<?= $versi ?>'>
 <link rel='stylesheet' href='<?= $url_asset ?>/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css?v=<?= $versi ?>'>
 <link rel='stylesheet' href='<?= $url_asset ?>/bower_components/bootstrap-daterangepicker/daterangepicker.css?v=<?= $versi ?>'>
 <link rel='stylesheet' href='<?= $url_asset ?>/bower_components/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css?v=<?= $versi ?>'>
 <link rel='stylesheet' href='<?= $url ?>/dist/css/googlefonts.css?v=<?= $versi ?>'>
 <link rel='stylesheet' href='<?= $url_asset ?>/bower_components/select2/dist/css/select2.min.css?v=<?= $versi ?>'>
 <link rel='stylesheet' href='<?= $url ?>/style/style-modal.css?v=<?= $versi ?>'>
 <link rel='stylesheet' href='<?= $url ?>/style/style-loading.css?v=<?= $versi ?>'>
 <style>
  .select2-container
   { min-width: 100% !important;
   }
  .select2-container--default .select2-selection--single
   { height : 35px;
     padding-top : 5.5px;
     padding-left : 2px;
     padding-right : 1px;
   }
  .datepicker, input[type='text']
   { border-radius : 0px;
     padding-left : 10px;
     padding-right : 10px;
   }
  [class^='select2']
   { border-radius : 0px !important;
   }
  .btn
   { border-radius : 0px;
   }
  .responsiveku { overflow-y:hidden; overflow-x:auto; clip-rect:(0px, 10px, 400px, 0px); }
  .sidebar-menu a
   { cursor : pointer;
   }
  .user-panel > .image
   { text-align:center;
   }
  .user-panel > .image > img
   { max-width : 150px;
     width : 100%;
   }
  .skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side
   { background : black;
   }
  .skin-blue .main-header .navbar
   { text-align : center;
     box-shadow : 0px 1px 5px black;
     background-color : #1875d2;
   }
  .skin-blue .main-header .navbar .sidebar-toggle:hover
   { background-color : #064381;
   }
  .skin-blue .main-header li.user-header
   { background-color : #1875d2;
   }
  .skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side
   { z-index : 1031;
   }
  .sidebar
   { margin-top : -50px;
   }
  .treeview-menu > li.active
   { background-color : white;
     border-radius : 10px;
     margin-right : 10px;
     margin-left : 3px;
   }
  .treeview-menu > li.active a i, .treeview-menu > li.active a span
   { color : black;
   }
  .skin-blue .sidebar-menu > li.alone.active > a
   { background-color : white;
     border-radius : 10px;
     margin-right : 10px;
     margin-left : 7px;
   }
  .skin-blue .sidebar-menu > li.alone.active > a i, .skin-blue .sidebar-menu > li.alone.active > a span
   { color : black;
   }
  .skin-blue .sidebar-menu > li.alone.active > a
   { border-left : 0px;
   }
  .modal-backdrop.in
   { display : none;
   }
  .skin-blue .sidebar-menu > li.active > a
   { background-color : white;
     color : black;
     border-radius : 10px;
     font-weight : bold;
     margin : 5px;
   }
  .select2-container--default .select2-selection--multiple .select2-selection__choice
   { color : black;
   }
  .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td
   { vertical-align : middle;
   }
  input::-webkit-outer-spin-button, input::-webkit-inner-spin-button
   { -webkit-appearance: none;
     margin : 0;
   }
  input[type=number]
   { -moz-appearance:textfield; /* Firefox */
   }
  .tab-container
   { width : 100%;
   }
  .tab-buttons
   { display : flex;
     flex-wrap : wrap;
     border-bottom : 2px solid #ddd;
   }
  .tab-button
   { padding : 10px 20px;
     cursor : pointer;
     border : none;
     background : none;
     font-size : 14px;
     outline : none;
     transition : 0.3s;
   }
  .tab-button.active
   { border-bottom : 2px solid #007aff;
     font-weight : bold;
     color : #007aff;
   }
  .tab-content
   { display : none;
     padding : 15px 0;
   }
  .tab-content.active
   { display : block;
   }
  .group-hover
   { transition: background-color 0.3s ease;
     cursor : pointer;
   }
  .group-hover:hover
   { background-color : #e2effb;
   }
  .input-disable
   { min-height : 34px; border:1px solid silver;
   }
  .input-disable > div
   { padding : 6px 10px 6px 10px;
   }
 </style>
</head>
<body class='hold-transition skin-blue sidebar-mini' style='overflow-y:auto;'>
 <form autocomplete='off'>
  <div class='wrapper'>
   <header class='main-header'>
    <nav class='navbar navbar-static-top'>
     <a href='#' class='sidebar-toggle' data-toggle='push-menu' role='button'>
      <span class='sr-only'>Toggle navigation</span>
     </a>
     <label style='font-size:30px; color:white; padding-top:2px;' id='label-nama-perusahaan'></label>
     <div class='navbar-custom-menu'>
      <ul class='nav navbar-nav'>
       <li class='dropdown notifications-menu'>
        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
         <i class='fa fa-bell-o'></i>
         <span class='label label-warning' id='jumlah-pemberitahuan'></span>
        </a>
        <ul class='dropdown-menu' style='user-select:none; cursor:pointer;'>
         <li class='header' id='judul-pemberitahuan'>Tidak ada pemberitahuan</li>
         <li>
          <ul class='menu' id='list-pemberitahuan'></ul>
         </li>
        </ul>
       </li>
       <li class='dropdown user user-menu'>
        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
         <img src='<?= $url ?>/dist/img/admin.png?v=<?= $versi ?>' class='user-image' alt='User Image'>
         <span class='hidden-xs'><?= $_SESSION['username'] ?></span>
        </a>
        <ul class='dropdown-menu'>
         <li class='user-header'>
          <img src='<?= $url ?>/dist/img/admin.png?v=<?= $versi ?>' class='img-circle' alt='User Image'>
          <p>User</p>
         </li>
         <li class='user-body'>
          <center id='label-jabatan'>Meet</center>
         </li>
         <li class='user-footer'>
          <div class='pull-left'>
           <a class='btn btn-default btn-flat' data-toggle='modal' data-target='#modalUbahPassword'>Ubah Password</a>
          </div>
          <div class='pull-right'>
           <a href='logout' class='btn btn-default btn-flat'>Sign out</a>
          </div>
         </li>
        </ul>
       </li>
       <li>
        <a href='#' data-toggle='control-sidebar'>
         <i class='fa fa-gears'></i>
        </a>
       </li>
      </ul>
      </div>
    </nav>
   </header>
   <aside class='main-sidebar'>
    <section class='sidebar'>
     <div class='user-panel'>
      <div class='image'>
       <img id='user-image' alt='User Image' style='margin-top:25px;' src='<?= $url ?>/dist/img/logo.png?v=<?= $versi ?>'>
      </div>
     </div>
     <ul class='sidebar-menu' id='menu-utama' data-widget='tree'></ul>
    </section>
   </aside>
   <div class='content-wrapper'>
    <div class='loader'></div>
    <div class='loader-block'></div>

    <script src='<?= $url_asset ?>/bower_components/jquery.min.js?v=<?= $versi ?>'></script>
    <script src='<?= $url_asset ?>/bower_components/jquery-ui/jquery-ui.min.js?v=<?= $versi ?>'></script>
    <script src='<?= $url_asset ?>/bower_components/bootstrap/dist/js/bootstrap.min.js?v=<?= $versi ?>'></script>
    <script src='<?= $url_asset ?>/bower_components/raphael/raphael.min.js?v=<?= $versi ?>'></script>
    <script src='<?= $url_asset ?>/bower_components/morris.js/morris.min.js?v=<?= $versi ?>'></script>
    <script src='<?= $url_asset ?>/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js?v=<?= $versi ?>'></script>
    <script src='<?= $url_asset ?>/bower_components/jquery-knob/dist/jquery.knob.min.js?v=<?= $versi ?>'></script>
    <script src='<?= $url_asset ?>/bower_components/moment/min/moment.min.js?v=<?= $versi ?>'></script>
    <script src='<?= $url_asset ?>/bower_components/bootstrap-daterangepicker/daterangepicker.js?v=<?= $versi ?>'></script>
    <script src='<?= $url_asset ?>/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js?v=<?= $versi ?>'></script>
    <script src='<?= $url_asset ?>/bower_components/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js?v=<?= $versi ?>'></script>
    <script src='<?= $url_asset ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js?v=<?= $versi ?>'></script>
    <script src='<?= $url_asset ?>/bower_components/fastclick/lib/fastclick.js?v=<?= $versi ?>'></script>
    <script src='<?= $url ?>/dist/js/adminlte.min.js?v=<?= $versi ?>'></script>
    <script src='<?= $url ?>/dist/js/demo.js?v=<?= $versi ?>'></script>
    <script src='<?= $url_asset ?>/bower_components/select2/dist/js/select2.full.min.js?v=<?= $versi ?>'></script>
    <script src='<?= $url_asset ?>/bower_components/timepicker/bootstrap-timepicker.min.js?v=<?= $versi ?>' type='text/javascript'></script>
    <script src='<?= $url ?>/dist/js/js-function.js?v=<?= $versi ?>' type='text/javascript'></script>
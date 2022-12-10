<?php 

session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo '<meta http-equiv="refresh" content="0; url=index.php">';

}else{
error_reporting(0);
include 'config/conn.php';
include 'lib/function.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SPK || DB TRANS</title>

    <!-- Bootstrap -->
    <link href="plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="plugins/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="plugins/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="plugins/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="plugins/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>

    <!-- Datatables -->
    <link href="plugins/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="plugins/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="plugins/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="plugins/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="plugins/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/datepicker.css" >
   <style>
    .datepicker{z-index:1151;}
      </style>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="./" class="site_title"><i class="fa fa-paw"></i> <span>SPK || DB TRANS</span></a>
            </div>

<!--             <div class="clearfix"></div>
            <br /> -->

            <?php include 'component/menu.php';?>
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Hallo, <?php echo $_SESSION['namalengkap'];?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Keluar</a></li>
                  </ul>
                </li>

               
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <?php include 'main.php';?>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Copyright © 2023 DB TRANS.All rights reserved.
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="plugins/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="plugins/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="plugins/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="plugins/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="plugins/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="plugins/Flot/jquery.flot.js"></script>
    <script src="plugins/Flot/jquery.flot.pie.js"></script>
    <script src="plugins/Flot/jquery.flot.time.js"></script>
    <script src="plugins/Flot/jquery.flot.stack.js"></script>
    <script src="plugins/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="plugins/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="plugins/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="plugins/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="plugins/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="plugins/jqvmap/dist/jquery.vmap.js"></script>
    <script src="plugins/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="plugins/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="plugins/moment/min/moment.min.js"></script>

    

    <!-- Datatables -->
    <script src="plugins/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="plugins/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="plugins/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="plugins/jszip/dist/jszip.min.js"></script>
    <script src="plugins/pdfmake/build/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/build/vfs_fonts.js"></script>



   <script src="plugins/bootstrap3-typeahead.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
   

   

<script src="js/bootstrap-datepicker.js" ></script>
<script src="js/bootstrap-modal.js"></script>
<script src="js/bootstrap-transition.js"></script>

    <script src="js/pendukung.js"></script>
    
	
  </body>
</html>

<?php }?>


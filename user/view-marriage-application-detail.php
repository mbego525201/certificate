<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['obcsuid'] == 0)) {
  header('location:logout.php');
} else {



?>
  <!doctype html>
  <html class="no-js" lang="en">

  <head>

    <title>Manage Application Form | Online Birth Certificate System</title>

    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i,800" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- adminpro icon CSS
		============================================ -->
    <link rel="stylesheet" href="css/adminpro-custon-icon.css">
    <!-- meanmenu icon CSS
		============================================ -->
    <link rel="stylesheet" href="css/meanmenu.min.css">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="css/data-table/bootstrap-table.css">
    <link rel="stylesheet" href="css/data-table/bootstrap-editable.css">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="css/normalize.css">
    <!-- charts CSS
		============================================ -->
    <link rel="stylesheet" href="css/c3.min.css">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="style.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- modernizr JS
		============================================ -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
  </head>

  <body class="materialdesign">

    <div class="wrapper-pro">
      <?php include_once('includes/sidebar.php'); ?>
      <?php include_once('includes/header.php'); ?>

      <!-- Breadcome start-->
      <div class="breadcome-area mg-b-30 small-dn">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="breadcome-list shadow-reset">
                <div class="row">

                  <div class="col-lg-12">
                    <ul class="breadcome-menu">
                      <li><a href="dashboard.php">Home</a> <span class="bread-slash">/</span>
                      </li>
                      <li><span class="bread-blod">Application Form</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Breadcome End-->

      <!-- Static Table Start -->
      <div class="data-table-area mg-b-15">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="sparkline13-list shadow-reset">
                <div class="sparkline13-hd">
                  <div class="main-sparkline13-hd">
                    <h1>View <span class="table-project-n">Detail of</span> Application</h1>
                    <div class="sparkline13-outline-icon">
                      <span class="sparkline13-collapse-link"><i class="fa fa-chevron-up"></i></span>
                      <span><i class="fa fa-wrench"></i></span>
                      <span class="sparkline13-collapse-close"><i class="fa fa-times"></i></span>
                    </div>
                  </div>
                </div>
                <div class="sparkline13-graph">
                  <div class="datatable-dashv1-list custom-datatable-overright">

                    <?php
                    $vid = $_GET['viewid'];

                    $sql = "SELECT tblmarriageregistration.*,tbluser.FirstName,tbluser.LastName,tbluser.MobileNumber,tbluser.Address from  tblregistration join  tbluser on tblregistration.UserID=tbluser.ID where tblregistration.ID=:vid";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':vid', $vid, PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    $cnt = 1;
                    if ($query->rowCount() > 0) {
                      foreach ($results as $row) {               ?>


                        <table class="table table-hover table-bordered mg-b-0" border="1">
                          <thead class="bg-info">
                            <tr>
                              <th>Certificate Number:</th>
                              <th><?php echo $row->RegistrationNumber; ?></th>

                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Issue Date:</td>
                              <td><?php echo $row->UpdationDate; ?></td>
                            </tr>
                          </tbody>
                        </table>

                        <table class="table table-hover table-bordered table-primary mg-b-0" style="margin-top:1%" border="1">
                          <thead>
                            <tr>

                              <th colspan="3">1. Husband Details</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th>Name</th>
                              <td>Mr. <?php echo $row->HusbandName; ?></td>
                              <td rowspan="4" style="text-align:center;"><img src="images/<?php echo $row->HusImage; ?>" width="250" height="200"><br />
                                Photo of Groom
                              </td>
                            </tr>
                            <tr>
                              <th>Resident at:</th>
                              <td><?php echo $row->HusbandAdd; ?>,<?php echo $row->HusbandZipcode; ?>,<?php echo $row->HusbandState; ?></td>
                            </tr>

                            <tr>
                              <th>Date of Birth:</th>
                              <td><?php echo $row->Husbanddob; ?></td>
                            </tr>

                            <tr>
                              <th>ID Number:</th>
                              <td><?php echo $row->HusbandIDNO; ?></td>
                            </tr>

                          </tbody>
                        </table>


                        <table class="table table-hover table-bordered table-purple mg-b-0" style="margin-top:1%" border="1">
                          <thead>
                            <tr>
                              <th colspan="3">2 WIFE DETAILS</th>
                            </tr>
                          </thead>
                          <tbody>

                            <tr>
                              <th>Name</th>
                              <td>Mrs.<?php echo $row->WifeName; ?></td>
                              <td rowspan="4" style="text-align:center;"><img src="images/<?php echo $row->WifeImage; ?>" width="250" height="200"> <br />
                                Photo of Bride</td>
                            </tr>
                            <tr>
                              <th>Resident at:</th>
                              <td> <?php echo $row->WifeAdd; ?>,<?php echo $row->WifeZipcode; ?>,<?php echo $row->WifeState; ?></td>
                            </tr>
                            <tr>
                              <th>Date of Birth:</th>
                              <td> <?php echo $row->Wifedob; ?></td>
                            </tr>

                            <tr>
                              <th>ID Number:</th>
                              <td> <?php echo $row->WifeIDNO; ?></td>
                            </tr>


                          </tbody>
                        </table>
                        <p style="margin-top:1%; font-size:16px;">Having been Solemnized at XYZ(State) on <?php echo $row->DateofMarriage; ?> according to the custom praticed by parties duly witness by:</p>
                        <table class="table table-hover table-bordered mg-b-0" border="1" width="100%">
                          <thead class="bg-danger">
                            <tr>
                              <th>#</th>
                              <th>Witness Name</th>
                              <th>Witness Address</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th>1.</th>
                              <td><?php echo $row->WitnessNamefirst; ?></td>
                              <td><?php echo $row->WitnessAddressFirst; ?></td>
                            </tr>

                            <tr>
                              <th>2.</th>
                              <td><?php echo $row->WitnessNamesec; ?></td>
                              <td><?php echo $row->WitnessAddresssec; ?></td>
                            </tr>

                            <tr>
                              <th>3.</th>
                              <td><?php echo $row->WitnessAddressthird; ?></td>
                              <td><?php echo $row->WitnessAddressthird; ?></td>
                            </tr>


                          </tbody>
                        </table>


                        <p style="margin-top:1%; font-size:16px;">Has been duly registred on <?php echo $row->UpdationDate; ?> at the office of maariage officer.</p>
                        <p style="color#000; font-weight:bold">Name of Groom: <?php echo $row->HusbandName; ?></p>
                        <p style="color#000; font-weight:bold">Name of Bride: <?php echo $row->WifeName; ?></p>
                    <?php }
                    } ?>
                    <form>
                      <p style="text-align: center;color: blue"><input type="button" value="print" class="btn btn-primary" onclick="PrintDiv();" /></p>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Static Table End -->
    </div>
    </div>
    <?php include_once('includes/footer.php'); ?>

    <!-- jquery
		============================================ -->
    <script src="js/vendor/jquery-1.11.3.min.js"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="js/bootstrap.min.js"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src="js/jquery.meanmenu.js"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- sticky JS
		============================================ -->
    <script src="js/jquery.sticky.js"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src="js/jquery.scrollUp.min.js"></script>
    <!-- counterup JS
		============================================ -->
    <script src="js/counterup/jquery.counterup.min.js"></script>
    <script src="js/counterup/waypoints.min.js"></script>
    <!-- peity JS
		============================================ -->
    <script src="js/peity/jquery.peity.min.js"></script>
    <script src="js/peity/peity-active.js"></script>
    <!-- sparkline JS
		============================================ -->
    <script src="js/sparkline/jquery.sparkline.min.js"></script>
    <script src="js/sparkline/sparkline-active.js"></script>
    <!-- data table JS
		============================================ -->
    <script src="js/data-table/bootstrap-table.js"></script>
    <script src="js/data-table/tableExport.js"></script>
    <script src="js/data-table/data-table-active.js"></script>
    <script src="js/data-table/bootstrap-table-editable.js"></script>
    <script src="js/data-table/bootstrap-editable.js"></script>
    <script src="js/data-table/bootstrap-table-resizable.js"></script>
    <script src="js/data-table/colResizable-1.5.source.js"></script>
    <script src="js/data-table/bootstrap-table-export.js"></script>
    <!-- main JS
		============================================ -->
    <script src="js/main.js"></script>


  </body>

  </html><?php }  ?>
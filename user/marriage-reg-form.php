<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['obcsuid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {

        $uid = $_SESSION['obcsuid'];
        $regnumber = mt_rand(100000000, 999999999);
        $dom = $_POST['dom'];
        $nofhusband = $_POST['nofhusband'];
        $hreligion = $_POST['hreligion'];
        $hdob = $_POST['hdob'];
        $hsbmarriage = $_POST['hsbmarriage'];
        $haddress = $_POST['haddress'];
        $hzipcode = $_POST['hzipcode'];
        $hstate = $_POST['hstate'];
        $hidno = $_POST['hidno'];
        $nofwife = $_POST['nofwife'];
        $wreligion = $_POST['wreligion'];
        $wdob = $_POST['wdob'];
        $wsbmarriage = $_POST['wsbmarriage'];
        $waddress = $_POST['waddress'];
        $wzipcode = $_POST['wzipcode'];
        $wstate = $_POST['wstate'];
        $widno = $_POST['widno'];
        $witnessnamef = $_POST['witnessnamef'];
        $waddressfirst = $_POST['waddressfirst'];
        $witnessnames = $_POST['witnessnames'];
        $waddresssec = $_POST['waddresssec'];
        $witnessnamet = $_POST['witnessnamet'];
        $waddressthird = $_POST['waddressthird'];
        //husband image
        $himg = $_FILES["husimage"]["name"];
        $extension1 = pathinfo($himg, PATHINFO_EXTENSION);
        //wife image
        $wimg = $_FILES["wifeimage"]["name"];
        $extension2 = pathinfo($wimg, PATHINFO_EXTENSION);
        // allowed extensions
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        // Validation for allowed extensions .in_array() function searches an array for a specific value.
        if (!in_array( strtolower($extension1), $allowed_extensions)) {
            echo "<script>alert('Husband image has Invalid format. Only jpg / jpeg/ png /gif format allowed $himg');</script>";
        }
        if (!in_array( strtolower($extension2), $allowed_extensions)) {
            echo "<script>alert('Wife image has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            //rename images
            $husimg = md5($himg) . time(). '.'. $extension1;
            $wifeimg = md5($wimg) . time(). '.'.  $extension2;
            move_uploaded_file($_FILES["husimage"]["tmp_name"], "images/" . $husimg);
            move_uploaded_file($_FILES["wifeimage"]["tmp_name"], "images/" . $wifeimg);
            
            $ret = "select HusbandIDNO,WifeIDNO from tblmarriageregistration where HusbandIDNO=:hidno || WifeIDNO=:widno";
            $query = $dbh->prepare($ret);
            $query->bindParam(':hidno', $hidno, PDO::PARAM_STR);
            $query->bindParam(':widno', $widno, PDO::PARAM_STR);

            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            
            if ($query->rowCount() == 0) {


                $sql = "insert into tblmarriageregistration(RegistrationNumber,UserID,DateofMarriage,HusbandName,HusImage,HusbandReligion,Husbanddob,HusbandSBM,HusbandAdd,HusbandZipcode,HusbandState,HusbandIDNO,WifeName,WifeImage,WifeReligion,Wifedob,WifeSBM,WifeAdd,WifeZipcode,WifeState,WifeIDNO,WitnessNamefirst,WitnessAddressFirst,WitnessNamesec,WitnessAddresssec,WitnessNamethird,WitnessAddressthird) values(:regnumber,:uid,:dom,:nofhusband,:husimg,:hreligion,:hdob,:hsbmarriage,:haddress,:hzipcode,:hstate,:hidno,:nofwife,:wifeimg,:wreligion,:wdob,:wsbmarriage,:waddress,:wzipcode,:wstate,:widno,:witnessnamef,:waddressfirst,:witnessnames,:waddresssec,:witnessnamet,:waddressthird)";
                
                $qry = $dbh->prepare($sql);

                $qry->bindParam(':regnumber', $regnumber, PDO::PARAM_STR);
               
                $qry->bindParam(':uid', $uid, PDO::PARAM_INT);
                $qry->bindParam(':dom', $dom, PDO::PARAM_STR);
                $qry->bindParam(':nofhusband', $nofhusband, PDO::PARAM_STR);
                $qry->bindParam(':husimg', $husimg, PDO::PARAM_STR);
                
                $qry->bindParam(':hreligion', $hreligion, PDO::PARAM_STR);
                $qry->bindParam(':hdob', $hdob, PDO::PARAM_STR);
                $qry->bindParam(':hsbmarriage', $hsbmarriage, PDO::PARAM_STR);
                $qry->bindParam(':haddress', $haddress, PDO::PARAM_STR);
                $qry->bindParam(':hzipcode', $hzipcode, PDO::PARAM_INT);
                $qry->bindParam(':hstate', $hstate, PDO::PARAM_STR);
                $qry->bindParam(':hidno', $hidno, PDO::PARAM_STR);
                $qry->bindParam(':nofwife', $nofwife, PDO::PARAM_STR);
                $qry->bindParam(':wifeimg', $wifeimg, PDO::PARAM_STR);
                $qry->bindParam(':wreligion', $wreligion, PDO::PARAM_STR);
                $qry->bindParam(':wdob', $wdob, PDO::PARAM_STR);
                $qry->bindParam(':wsbmarriage', $wsbmarriage, PDO::PARAM_STR);
                $qry->bindParam(':waddress', $waddress, PDO::PARAM_STR);
                $qry->bindParam(':wzipcode', $wzipcode, PDO::PARAM_INT);
                $qry->bindParam(':wstate', $wstate, PDO::PARAM_STR);
                $qry->bindParam(':widno', $widno, PDO::PARAM_STR);
                $qry->bindParam(':witnessnamef', $witnessnamef, PDO::PARAM_STR);
                $qry->bindParam(':waddressfirst', $waddressfirst, PDO::PARAM_STR);
                $qry->bindParam(':witnessnames', $witnessnames, PDO::PARAM_STR);
                $qry->bindParam(':waddresssec', $waddresssec, PDO::PARAM_STR);
                $qry->bindParam(':witnessnamet', $witnessnamet, PDO::PARAM_STR);
                $qry->bindParam(':waddressthird', $waddressthird, PDO::PARAM_STR);
                
                try {
                    $qry->execute();
                    echo '<script>alert("Registration form has been filled successfully.")</script>';
                } catch (\Throwable $th) {
                    echo $th;
                }
                // if($qry->execute()){
                //     echo '<script>alert("Registration form has been filled successfully.")</script>';
                // }
                // else{
                //     echo '<script>alert("Registration form failed")</script>';
                // }
                // $LastInsertId = $dbh->lastInsertId();
                // if ($LastInsertId > 0) {

                //     echo '<script>alert("Registration form has been filled successfully.")</script>';
                // } else {
                //     echo '<script>alert("Something Went Wrong. Please try again")</script>';
                // }
            } else {

                echo "<script>alert('IF Number is  already exist. Please try again');</script>";
            }
        }
    }
?>
    <!doctype html>
    <html class="no-js" lang="en">

    <head>

        <title>Birth Certificate Form | Online Birth Certificate System</title>

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
        <!-- modals CSS
		============================================ -->
        <link rel="stylesheet" href="css/modals.css">
        <!-- normalize CSS
		============================================ -->
        <link rel="stylesheet" href="css/normalize.css">
        <!-- forms CSS
		============================================ -->
        <link rel="stylesheet" href="css/form/all-type-forms.css">
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
                                            <li><span class="bread-blod">Marriage Registration Form</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Basic Form Start -->
            <div class="basic-form-area mg-b-15">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sparkline12-list shadow-reset mg-t-30">
                                <div class="sparkline12-hd">
                                    <div class="main-sparkline12-hd">
                                        <h1>Application Form</h1>
                                        <div class="sparkline12-outline-icon">
                                            <span class="sparkline12-collapse-link"><i class="fa fa-chevron-up"></i></span>
                                            <span><i class="fa fa-wrench"></i></span>
                                            <span class="sparkline12-collapse-close"><i class="fa fa-times"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sparkline12-graph">
                                    <div class="basic-login-form-ad">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="all-form-element-inner">

                                                    <form method="post" method="post" enctype="multipart/form-data">
                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Date of Marriage</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="date" class="form-control" name="dom" value="" required="true" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- wd-200 -->
                                                        <h3 class="card-body-title" style="padding-top: 20px;color: red">1 Husband Details</h3>
                                                        <hr />
                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Name of Husband: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="text" name="nofhusband" value="" class="form-control" required='true'>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Photo: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="file" name="husimage" value="" class="form-control" required='true' accept=".jpg, .jpeg, .png, .gif">
                                                                </div>
                                                            </div><!-- row mb-1 -->
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Religion: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="text" name="hreligion" value="" class="form-control" required='true'>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Date of Birth: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="date" class="form-control " placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" id="hdob" name="hdob">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Marital Status Before Marriage: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <select type="text" name="hsbmarriage" value="" class="form-control" required='true'>
                                                                        <option value="">Select Status</option>
                                                                        <option value="Bachelor">Bachelor</option>
                                                                        <option value="Married">Married</option>
                                                                        <option value="Divorsee">Divorsee</option>
                                                                        <option value="Widower">Widower</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Address: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <textarea type="file" name="haddress" value="" required="true" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Zipcode: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="text" name="hzipcode" value="" class="form-control" required='true' maxlength="6">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">State: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="text" name="hstate" value="" class="form-control" required='true'>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Enter ID Number: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="text" name="hidno" value="" required="true" class="form-control" maxlength="12">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h3 class="card-body-title" style="padding-top: 20px;color: red">2 Wife Details</h3>
                                                        <hr />
                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Name of Wife: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="text" name="nofwife" value="" class="form-control" required='true'>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Photo: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="file" name="wifeimage" value="" class="form-control" required='true' accept=".jpg, .jpeg, .png, .gif">
                                                                </div>
                                                            </div><!-- row -->
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Religion: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="text" name="wreligion" value="" class="form-control" required='true'>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Date of Birth: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="date" class="form-control " placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" id="wdob" name="wdob">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Marital Status Before Marriage: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <select type="text" name="wsbmarriage" value="" class="form-control" required='true'>
                                                                        <option value="">Select Status</option>
                                                                        <option value="Bachelor">Bachelor</option>
                                                                        <option value="Married">Married</option>
                                                                        <option value="Divorsee">Divorsee</option>
                                                                        <option value="Widower">Widower</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Address: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <textarea type="text" name="waddress" value="" required="true" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Zipcode: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="text" name="wzipcode" value="" class="form-control" required='true' maxlength="6">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">State: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="text" name="wstate" value="" class="form-control" required='true'>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Enter ID Number: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="text" name="widno" value="" required="true" class="form-control" maxlength="12">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h3 class="card-body-title" style="padding-top: 20px;color: red">3 Witness Details</h3>
                                                        <hr />
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Full Name of Witness: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="text" name="witnessnamef" value="" class="form-control" required='true'>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Address: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <textarea type="text" name="waddressfirst" value="" required="true" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr />
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Full Name of Witness: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="text" name="witnessnames" value="" class="form-control" required='true'>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Address: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <textarea type="text" name="waddresssec" value="" required="true" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr />
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Full Name of Witness: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <input type="text" name="witnessnamet" value="" class="form-control" required='true'>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group-inner">
                                                            <div class="row mb-1 mg-t-20">
                                                                <div class="col-lg-3">
                                                                    <label class="login2 pull-right pull-right-pro">Address: <span class="tx-danger">*</span></label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                    <textarea type="text" name="waddressthird" value="" required="true" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-layout-footer mg-t-30">
                                                            <p style="text-align: center;"><button class="btn btn-info mg-r-5" name="submit" id="submit">ADD</button></p>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Basic Form End-->

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
        <!-- modal JS
		============================================ -->
        <script src="js/modal-active.js"></script>
        <!-- icheck JS
		============================================ -->
        <script src="js/icheck/icheck.min.js"></script>
        <script src="js/icheck/icheck-active.js"></script>
        <!-- main JS
		============================================ -->
        <script src="js/main.js"></script>
    </body>

    </html><?php }  ?>
<?php
    ob_start();
    session_start();
    //เช็คว่ามีการเข้าสู่ระบบหรือยัง
    if(isset($_SESSION["id_username"])){
        $id_username = $_SESSION["id_username"];
    }
    else if(isset($_COOKIE["id_username"])){
        $id_username = $_COOKIE["id_username"];
    }
    if(isset($id_username)){
        $data_user = array();
        include "php/connectdb.php";
        $sql = "SELECT am_prefix , am_firstname , am_lastname , am_department_id , am_level , dbo.fncDecode(am_password) ".
                "FROM admin_user ".
                "WHERE am_id = '".$id_username."'; ";
        $stmt = sqlsrv_query( $conn, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        if( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
            if($row[1] != NULL){
                array_push($data_user, // ตัวแปรตัวตั้ง
                    $id_username, // เริ่มจาก $id_username เป็น $data_user[0]
                    $row[0],$row[1],$row[2],$row[3],$row[4],$row[5],
                );
            }
            else{
                header("Location: login.php");
            }
        }
        else{
            header("Location: login.php");
        }
        sqlsrv_free_stmt( $stmt);
    }
    else{
        header("Location: login.php");
    }
    //$id_username = '002';
    //ดึงข้อมูล Database มาเก็บในตัวแปร array() ชื่อ $data_user
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <!-- ส่วนของ JS -->
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/main_admin.js"></script>
    <script src="js/main.js"></script>
</head>
<body>
    <!-- modal แจ้งเตือนการลบข้อมูล  -->
    <div class="modal fade" id="deletModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">คุณต้องการลบหรือไม่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="btn_delete_data">Yes</button>
            </div>
            </div>
        </div>
    </div>

    <!-- modal Form เพิ่มข้อมูล  -->
    <div class="modal fade" id="addnewform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="exampleModalLabel">สร้าง Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="am_id">Admin ID</label>
                        <input type="text" class="form-control" id="am_id" aria-describedby="am_idHelp" placeholder="Enter AdminID">
                        <small id="am_idHelp" class="form-text text-muted">กรุณากรอก Admin ID เป็นภาษาอังกฤษ หรือ ตัวเลข</small>
                    </div>
                    <div class="form-group">
                        <label for="am_prefix">คำนำหน้า</label>
                        <select class="form-control" name="am_prefix" id="am_prefix">
                            <option selected></option>
                            <option value="นาย">นาย</option>
                            <option value="นาง">นาง</option>
                            <option value="นางสาว">นางสาว</option>
                            <option value="อาจารย์">อาจารย์</option>
                            <option value="ผู้ช่วยศาสตราจารย์">ผู้ช่วยศาสตราจารย์</option>
                            <option value="รองศาสตราจารย์">รองศาสตราจารย์</option>
                            <option value="ศาสตราจารย์">ศาสตราจารย์</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="am_fristname">ชื่อ</label>
                        <input type="text" class="form-control" id="am_firstname" placeholder="Enter ชื่อ">
                    </div>
                    <div class="form-group">
                        <label for="am_lastname">นามสกุล</label>
                        <input type="text" class="form-control" id="am_lastname" placeholder="Enter นามสกุล">
                    </div>
                    <div class="form-group">
                        <label for="am_department_id">บุคลากรประจำสาขา</label>
                        <select class="form-control" name="am_department_id" id="am_department_id">
                            <option selected></option>
                            <?php
                                include "php/sql_select_department.php";
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="am_leve">ระดับผู้ดูแล</label>
                        <select class="form-control" name="am_leve" id="am_leve">
                            <option selected></option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="am_password1">รหัสผ่าน</label>
                        <input type="password" class="form-control" id="am_password1" placeholder="Enter password">
                    </div>
                    <div class="form-group">
                        <label for="am_password2">รหัสผ่านอีกครั้ง</label>
                        <input type="password" class="form-control" id="am_password2" placeholder="Enter password again">
                        <small id="am_idpassword" class="form-text text-muted">กรุณาใส่ Password เป็นภาษาอังกฤษหรือตัวเลข</small>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success" id="am_add_new_submit"><i class="fa fa-plus"></i> ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>
    <!-- wrapper  -->
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <a href="index.php"><i class="fas fa-home"></i> Admin Home</a>
            </div>
            <ul class="list-unstyled components">
                <li><a href="#1"><i class="fas fa-download"></i> อัปโหลดข้อมูลผลการเรียน</a></li>
                <li><a href="#2"><i class="fas fa-database"></i> ข้อมูลผลการเรียน</a></li>
                <li><a href="admin.php"><i class="fas fa-users"></i> ผู้ดูแลระบบ</a></li>
                <li><a href="login.php"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a></li>
                <!-- dropdown-toggle -->
                <!--
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="#">Page 1</a>
                        </li>
                        <li>
                            <a href="#">Page 2</a>
                        </li>
                        <li>
                            <a href="#">Page 3</a>
                        </li>
                    </ul>
                </li>
                -->
            </ul>
        </nav>
        <!-- Page Content  -->
        <div id="content">
            <!-- การแจ้งเตือนผู้ใช้งาน  -->
            <div class="shadow-sm mb-2 p-2 pl-3 bg-success text-white sticky-top" id="mss1" style="display:none;"></div>
            <div class="shadow-sm mb-2 p-2 pl-3 bg-danger text-white sticky-top" id="mss2" style="display:none;"></div>
            <div class="shadow-sm mb-2 p-2 pl-3 bg-warning text-dark sticky-top" id="mss3" style="display:none;"></div>
            <!--เมนูส่วนหัว-->
            <nav class="navbar navbar-expand-lg pt-1 pb-1">
                <div class="container-fluid">
                    <div class="manubar">
                        <button type="button" id="sidebarCollapse" class="btn btn-primary" style="width: 37px; height: 36px; position: relative; margin: auto 0;">
                            <i class="fas fa-align-left"></i>
                        </button>
                        <div class="user_name">ชื่อผู้ใช้งาน 
                            <?php
                                echo $data_user[0]." ".$data_user[1]." ".$data_user[2]." ".$data_user[3];
                            ?>
                        </div>
                    </div>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!--เมนู Demo Test -->
            <nav class="navbar" id="demo"></nav>
            <!--เมนู 2 -->
            <nav class="navbar p-0" id="main_Content">

            </nav>
            <!--
            <h2>Collapsible Sidebar Using Bootstrap 4</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            <div class="line"></div>

            <h2>Lorem Ipsum Dolor</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            <div class="line"></div>

            <h2>Lorem Ipsum Dolor</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            <div class="line"></div>

            <h3>Lorem Ipsum Dolor</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            -->
        </div>
    </div>
</body>
</html>
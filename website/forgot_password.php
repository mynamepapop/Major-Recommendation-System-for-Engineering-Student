<?php
	ob_start();
	session_start();
	session_destroy();
	include 'php/connectdb.php';
	//Check ความถูกต้องของ Admin id หรือ รหัสผ่าน
	if (isset($_POST['sendemail'])){
		$email = $_POST['admin_email'];
		$msg = '';
		if(!empty($email)){
			$sql = "SELECT am_email ".
				   "FROM admin_user ".
			       "WHERE am_email = '".$email."';";
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			if($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC)) {
				//ส่ง Eamil
				$msg = "ส่ง";
			}
			else{
				$msg = "ไม่พบ Email : ".$email." ในระบบ กรุณาติดต่อ Admin";
			}
		}
		else{
			$msg = 'กรุณาใส่ Email';
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- add icon link -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
	<!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="js/login.js"></script>
	<title>Login</title>
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="card fat">
						<div class="clearfix">
							<a class="btn btn-primary float-right" href="login.php" role="button"><i class="fas fa-arrow-left"></i></a>
						</div>
						<div class="card-body">
							<h4 class="card-title">ลืมรหัสผ่าน</h4>
							<form id="formlogin" method="POST" class="my-login-validation"  action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
								<div class="form-group">
									<label for="admin_email">Email</label>
									<input id="admin_email" type="email" class="form-control" name="admin_email" placeholder="Enter email">
									<small class="text-muted d-block pt-2">ทางระบบจะส่ง Email เพื่อยืนยันการเปลี่ยนรหัสใหม่</small> 
									<small class="text-danger d-block"><?php if(isset($_POST['admin_email'])) echo $msg ?></small>
								</div>
								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block" name="sendemail">ส่ง Eamil</button>
								</div>
								<a href="forgot.html" class="float-right d-block p-2">ติดต่อ Admin</a> 
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; 2020 &mdash; นักศึกษาวิศวะกรรมคอมพิวเตอร์
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>
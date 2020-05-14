<?php
	ob_start();
	session_start();
	session_destroy();
	include 'php/connectdb.php';
	//Check ความถูกต้องของ Admin id หรือ รหัสผ่าน
	if (isset($_POST['login'])){
		$id_and_email = $_POST['id_and_email'];
		$admin_password = $_POST['admin_password'];
		$msg_adminid = '';
		$msg_password = '';
		if(!empty($id_and_email)){
			if(!empty($admin_password)){
				$sql = "SELECT am_id, am_email , dbo.fncDecode(am_password) ".
					   "FROM admin_user ".
					   "WHERE am_id = '".$id_and_email."';";
				$stmt = sqlsrv_query( $conn, $sql );
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				if($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC)) {
					if($row[0] == $id_and_email){
						if($row[2] == $admin_password){
							if(isset($_POST['remember']))
							{
								session_start();
								$_SESSION["id_username"] = $row[0];
								setcookie("id_username");
							}
							else
							{
								ob_start();
								setcookie("id_username",$row[0],time()+60*60*24*100);
								session_destroy();
							}
							header( "Location: index.php" );
						}
						else{
							$msg_password = 'รหัสผ่านผิดกรุณากรอกข้อมูลใหม่';
						}
					}
					else{
						$msg_adminid = 'ไม่พบ Admin Id';
					}
				}
				else{
					$sql = "SELECT am_id, am_email , dbo.fncDecode(am_password) ".
						   "FROM admin_user ".
						   "WHERE am_email = '".$id_and_email."';";
					$stmt = sqlsrv_query( $conn, $sql );
					if( $stmt === false) {
						die( print_r( sqlsrv_errors(), true) );
					}
					if($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC)) {
						if($row[1] == $id_and_email){
							if($row[2] == $admin_password){
								if(isset($_POST['remember']))
								{
									session_start();
									$_SESSION["id_username"] = $row[0];
									setcookie("id_username");
								}
								else
								{
									ob_start();
									setcookie("id_username",$row[0],time()+60*60*24*100);
									session_destroy();
								}
								header( "Location: index.php" );
							}
							else{
								$msg_password = 'รหัสผ่านผิดกรุณากรอกข้อมูลใหม่';
							}
						}
						else{
							$msg_adminid = 'ไม่พบ Admin Id';
						}
					}
					else{
						$msg_adminid = 'ไม่พบ Admin Id หรือ Email';
					}
				}
			}
			else{
				$msg_password = 'กรุณาใส่ Password';
			}
		}
		else{
			$msg_adminid = 'กรุณาใส่ Admin ID';
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
	<title>Login ระบบแนะนำสาขาสำหรับวิศวะกรรมคอมพิวเตอร์</title>
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Login สำหรับผู้ดูแลระบบ</h4>
							<form id="formlogin" method="POST" class="my-login-validation"  action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
								<div class="form-group">
									<label for="id_and_email">Admin ID หรือ Email</label>
									<input id="id_and_email" type="text" class="form-control" name="id_and_email" value="" placeholder="Enter Admin ID หรือ Email">
									<div class="feedback">
										<?php
											if(isset($_POST['login'])){
												echo $msg_adminid;
											}
										?>
									</div>
								</div>
								<div class="form-group">
									<label for="admin_password">Password</label>
									<input id="admin_password" type="password" class="form-control" name="admin_password" placeholder="Enter Password">
								    <div class="feedback">
										<?php
											if(isset($_POST['login'])){
												echo $msg_password;
											}
										?>
									</div>
								</div>
								<a href="forgot_password.php" class="float-right">Forgot Password?</a>
								<br>
								<div class="form-group">
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="remember" id="remember" class="custom-control-input" value="Yes">
										<label for="remember" class="custom-control-label">Remember Me</label>
									</div>
								</div>
								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
								</div>
								<div class="mt-4 text-center">สมัครผู้ดูแลระบบ <a href="register.html">สร้างบัญชี</a></div>
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
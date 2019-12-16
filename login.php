<?php
	$username = "";
	$password = "";
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$username = $_POST['username'];
		$password = $_POST['psw'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>CV | Log In</title>
	<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="log_in.css">

</head>
<body>
	<div class="container">
		<form form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
			<div class="container_info">
				<span class="field">Username:</span>
				<input class="text_input" type="text" name="username" value="<?php echo $username; ?>">
			</div>
			<div class="container_info">
				<span class="field">Password:</span>
				<input class="text_input" type="password" name="psw" value="<?php echo $password; ?>">
			</div>
			<input class="btn" type="submit" name="login" value="LOG IN">
		</form>
		<div class="container_line">
			<hr class="hr_left">
			<span class="field">OR</span>
			<hr class="hr_right">
		</div>
		<div class="btn_sign_up">
			<a href="signup.php">SIGN UP</a>
		</div>
		
	</div>
	<?php
		header('Content-type: text/html; charset=UTF-8');
		//xứ lý đăng nhập
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$error = login();
			if ($error) {
				echo "<script type = 'text/javascript'>alert('.$error.');</script>";
			}
		}

		function login() {
			$err = null;
			//kết nối tới database
			$con = mysqli_connect("localhost","root","","cv");
			if (mysqli_connect_errno()){
			    $err = "Failed to connect to MySQL: " . mysqli_connect_error();
			    return $err;
			}

			//lấy dl nhập vào
			$username = addslashes($_POST['username']);
			$password = addslashes($_POST['psw']);

			//kiểm tra đã nhập đủ tt đăng nhập chưa
			if (!$username || !$password) {
				$err = "Vui lòng nhập đầy đủ thông tin đăng nhập.";
				return $err;
			}

			//mã hóa pass
			$password = md5($password);

			//kiểm tra tên đăng nhập có tồn tại k
			$query = mysqli_query($con,"SELECT id,username,password FROM users WHERE username = '$username'");
			if (mysqli_num_rows($query) == 0) {
				$err = "Tên đăng nhập không tồn tại.";
				return $err;
			}

			//lấy mk trong database ra
			$row = mysqli_fetch_array($query,MYSQLI_ASSOC);

			//so sánh 2 mk có trùng nhau k
			if ($password != $row['password']) {
				$err = "Mật khẩu không đúng hoặc không tồn tại.";
				return $err;
			}

			$id = $row["id"];//lấy id
			setcookie("cv_id", $id, time() + (86400 * 30), "/");
			//kiểm tra cookie đã bật chưa
			if (array_key_exists("cv_id", $_COOKIE)) {
				header('Location:index.php');//chuyển hướng trang
			}else{
				$err = "Vui lòng bật cookie để tiếp tục";
				return $err;
		}
			}
	?>
</body>
</html>
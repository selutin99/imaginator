<?php
	session_start();

	$db = mysqli_connect("localhost", "root", "", "imaginator");

	if (isset($_POST['subLog'])) {
		$log = mysqli_real_escape_string($db, $_POST["login"]);  
		
		$pas = mysqli_real_escape_string($db, $_POST["pass"]);  
		$pas = md5($pas);
		
		$row = mysqli_query($db, "SELECT `login` FROM `users` WHERE `login`='$log' AND `password` = '$pas'");
		$idRow = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `users` WHERE `login`='$log'"));
		
		if ($log or $pas){
			if (mysqli_num_rows($row) > 0){ 
				$_SESSION['USER_ID'] = $idRow['id'];
				$_SESSION['USER_LOGIN'] = $log;
				
				if ($_REQUEST['remember-me']) 
					setcookie('user', $pas, strtotime('+30 days'), '/');
					
				header('location:profile.php');
			}							
		}	
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>IMAGINATOR: вход</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				<form class="login100-form validate-form flex-sb flex-w" method="post">
					<span class="login100-form-title p-b-32">
						Вход
					</span>

					<span class="txt1 p-b-11">
						Логин
					</span>
					<div class="wrap-input100 validate-input m-b-36">
						<input class="input100" type="text" name="login" required>
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Пароль
					</span>
					<div class="wrap-input100 validate-input m-b-12">
						<input class="input100" type="password" name="pass" required>
						<span class="focus-input100"></span>
					</div>
					
					<div class="flex-sb-m w-full p-b-48">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Запомнить меня
							</label>
						</div>
					</div>

					<div class="container-login100-form-btn">
						<input type="submit" name="subLog" class="login100-form-btn" value="Вход">
						<button class="login100-form-btn">
							<a href="index.php" id="back">
								На главную
							</a>
						</button>
					</div>
					<?php if(isset($_POST['subLog'])):?>
						<?php if(!$log or !$pas):?>
							<p style="margin-top: 10px; color: red;">Не могу обработать форму</p>
						<?php endif;?>
						
						<?php if(mysqli_num_rows($row) <= 0):?>
							<p style="margin-top: 10px; color: red;">Неверный логин или пароль</p>
						<?php endif;?>
					<?php endif;?>
				</form>
			</div>
		</div>
	</div>
	<div id="dropDownSelect1"></div>
</body>
</html>
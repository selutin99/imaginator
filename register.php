<?php
	session_start();
	function FormChars ($p1) {
		return nl2br(htmlspecialchars(trim($p1), ENT_QUOTES), false);
	}


	function GenPass ($p1, $p2) {
		return md5('IMAGINATOR'.md5('321'.$p1.'123').md5('678'.$p2.'890'));
	}

	$db = mysqli_connect("localhost", "root", "", "imaginator");	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>IMAGINATOR: регистрация</title>
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
						Регистрация
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
					
					<span class="txt1 p-b-11">
						Каптча
					</span>
					<div class="wrap-input100 validate-input m-b-12">
						<input type="text" class="input100" name="captcha" maxlength="10" pattern="[0-9]{1,5}" title="Только цифры." required> 
						<span class="focus-input100"></span>	
					</div>
					<img style="display: block; margin-left: auto; margin-right: auto; width: 30%;" src="/images/captcha.php" class="capimg" alt="Каптча">

					<div class="container-login100-form-btn">
						<input type="submit" name="reg" class="login100-form-btn" value="Регистрация">
						<button class="login100-form-btn">
							<a href="index.php" id="back">
								На главную
							</a>
						</button>
					</div>
					
					<?php
						if (isset($_POST['reg'])) {
							$log = mysqli_real_escape_string($db, $_POST["login"]);  
							$pas = mysqli_real_escape_string($db, $_POST["pass"]);  
							$pas = md5($pas);  
							$cap = FormChars($_POST['captcha']);
							
							if ($log or $pas){
								if($_SESSION['captcha'] == md5($cap)){
									$row = mysqli_fetch_assoc(mysqli_query($db, "SELECT `login` FROM `users` WHERE `login` = '$log'"));
									if (!$row['login']){ 
										mysqli_query($db, "INSERT INTO users (login, password) VALUES('$log', '$pas')");
										echo('<p style="margin-top: 10px; color: green;">Регистрация прошла успешно</p>');
									}
									else{
										echo('<p style="margin-top: 10px; color: red;">Логин уже используется</p>');
									}
								}
								else{
									echo('<p style="margin-top: 10px; color: red;">Неверная каптча</p>');
								}								
							}
							else{
								echo('<p style="margin-top: 10px; color: red;">Не могу обработать форму</p>');
							}	
						}
					?>
				</form>
			</div>
		</div>
	</div>
	<div id="dropDownSelect1"></div>
</body>
</html>
<?php
	session_start();
	
	include 'header.php';
	
	$db = mysqli_connect("localhost", "root", "", "imaginator");
	$msg = "";

	if (isset($_POST['upload'])) {
		
		$image = $_FILES['image']['name'];
		$image_text = mysqli_real_escape_string($db, $_POST['image_text']);
		$target = "images/".basename($image);

		$sql = "INSERT INTO images (image, description) VALUES ('$image', '$image_text')";

		if (mysqli_query($db, $sql)) {
			$uploadedID = mysqli_insert_id($db);
			$result = mysqli_query($db, "SELECT * FROM images WHERE id = '$uploadedID'");
		} else {
		}
		
		if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
			$msg = "Изображение успешно загружено";
		}else{
			$msg = "Ошибка при загрузке";
		}
	}

?>
		
		<content>
			<?php
				if(isset($_POST['upload'])){
				  $row = mysqli_fetch_array($result);
				  echo "<div id='img_div'>";
					echo "<center><h1>Загруженное изображение: </h1></center>";
					echo "<center><img style='width:100px; height:100px; margin-top: 20px;' src='images/".$row['image']."' ></center>";
					echo "<center><a href=\"/images/".$row['image']."\"> Скачать изображение </a></center>";
					
					echo "<center><p style='display: inline;'>Ссылка на картинку:</p> <input style='margin-top: 20px;' type='text' value=\"imaginator/images/".$row['image']."\" id='linkImage'>";
					echo "<button style='margin-left: 10px;' onclick='copyFunc()'>Скопировать</button></center>";
					
					echo "<center><p style='display: inline; margin-left: 72px;'>HTML-код:</p> <input style='margin-top: 5px;' type='text' value='<a href=\"imaginator\"><img src=\"imaginator/images/".$row['image']."\" alt=\"index\" border=\"0\"></a>' id='codeHtml'>";
					echo "<button style='margin-left: 10px;' onclick='copyHTML()'>Скопировать</button></center>";
					
					if($row['description']!=null){
						echo "<center><p style='margin-top: 10px;'>Описание: ".$row['description']."</p></center>";
					}
				  echo "</div>";
				}
			?>
			<form enctype="multipart/form-data" action="index.php" method="POST">
				<h1 align="center">Загрузите фото на сервер</h1>
				<div class="file-form-wrap">
					<div class="file-upload">
						<label>
							<input id="uploaded-file1" type="file" name="image" accept="image/*" onchange="getFileParam();" required />
							<span>Выберите файл</span><br />
						</label>
					</div>
					<center><div id="preview1">&nbsp;</div></center>
					<center><div id="file-name1">&nbsp;</div></center>
					<center><div id="file-size1">&nbsp;</div></center>
					<input class="sub_but" name="upload" type="submit" value="Отправить">
					<textarea name="image_text" style="resize: none; margin-top: 20px;" rows="5" cols="33" placeholder="Добавьте описание по желанию..."></textarea>
				</div>
			</form>
		</content>
		
		<script>
			function copyFunc() {
			  var copyText = document.getElementById("linkImage");
			  copyText.select();
			  document.execCommand("copy");
			}
			function copyHTML() {
			  var copyText = document.getElementById("codeHtml");
			  copyText.select();
			  document.execCommand("copy");
			}
		</script>
	
<?php
	include 'footer.php';
?>
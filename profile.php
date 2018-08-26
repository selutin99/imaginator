<?php
	session_start();
	include 'logheader.php';
	$db = mysqli_connect("localhost", "root", "", "imaginator");	
?>
		<content>
			<p id="about" align="justify">
				<center>
					<h3>
						<?php
							echo "Приветствую, ".$_SESSION['USER_LOGIN']."!<br/>";
							echo "Здесь отображаются все загруженные картинки.";
							if(isset($_SESSION['USER_LOGIN'])){
								$userID = $_SESSION['USER_ID'];
								$result = mysqli_query($db, "SELECT * FROM images WHERE user = '$userID'");
								while ($row = mysqli_fetch_array($result)) {
								  echo "<div id='img_div' style='margin-bottom: 55px;'>";
									echo "<center><img style='width:100px; height:100px; margin-top: 20px;' src='images/".$row['image']."' ></center>";
									echo "<center><a href=\"/images/".$row['image']."\"> Скачать изображение </a></center>";
									
									echo "<center><p style='display: inline;'>Ссылка на картинку:</p> <input style='margin-top: 20px;' type='text' value=\"imaginator/images/".$row['image']."\" id='linkImage'>";
									
									echo "<center><p style='display: inline; margin-left: 92px;'>HTML-код:</p> <input style='margin-top: 5px;' type='text' value='<a href=\"imaginator\"><img src=\"imaginator/images/".$row['image']."\" alt=\"index\" border=\"0\"></a>' id='codeHtml'>";
									
									if($row['description']!=null){
										echo "<center><p style='margin-top: 10px;'>Описание: ".$row['description']."</p></center>";
									}
								  echo "</div>";
								}
							}
						?>
					<h3>
				</center>
			</p>
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
<?php 

ob_start();

	session_start();

	include 'init.php'; 

?>

<div class="container">
	<?php include $TempDir . 'ads_and_secBtn.php'; ?>
	<div class="main_page">
		<div class="row">
			<!-- Right Side Start ############################################################################################ -->
			<div class="col-lg-8">
				<div class="Most_active_rooms">
					<div class="row">
						<?php 

						$Get_All_Rooms = $con-> prepare("SELECT * FROM chat_rooms ORDER BY Room_ID DESC");
						$Get_All_Rooms-> execute();
						$Count = $Get_All_Rooms-> rowCount();
						if($Count > 0) {

							$Room_Chats = $Get_All_Rooms-> fetchAll();
							foreach($Room_Chats as $Rooms) {

								echo '<div class="col-lg-6">';
									echo '<div class="The_room">';
										echo '<img src="Uploads/Images/Room_Chats_Images/'. $Rooms['Room_Image'] .'" alt="'. $Rooms['Room_Name'] .'" class="img-responsive img-thumbnail">';
										echo '<h3>'. $Rooms['Room_Name'] .'</h3>';
										echo '<hr>';
										$Memeber_array = explode(',', $Rooms['Members_In_Room']);
										$Member_In_Room = count($Memeber_array);

										echo '<span>المتواجدين: <strong> ';
											if($Member_In_Room == 1) {
												echo '0';
											} else {
												echo $Member_In_Room - 1;
											}
										echo ' </strong></span>';
										echo '<p class="Room_Description">'. $Rooms['Room_Description'] .'</p><br>';
										$Room_Name_URL = str_replace(' ', '-', $Rooms['Room_Name']);
										echo '<a href="Caht.php?RoomName='. $Room_Name_URL .'"><button class="btn btn-danger"> الدخول للغرفة </button> </a>';
									echo '</div>';
								echo '</div>';

							}

						} else {

							echo '<div class="alert alert-damger">لا يوجد غرف</div>';

						}

					?>
					</div>
				</div>
			</div>
			<!-- Right Side End ############################################################################################ -->
			<!-- Left Side Start ############################################################################################ -->
			<div class="col-lg-4">
				<div class="leftSide">
					<h3>الأخبار</h3>
					<hr>
					<?php 

						$Get_All_News = $con-> prepare("SELECT * FROM news ORDER BY News_ID DESC LIMIT 5");
						$Get_All_News-> execute();
						$Count = $Get_All_News-> rowCount();
						if($Count > 0) {

							$News_Art = $Get_All_News-> fetchAll();
							foreach($News_Art as $news) {

								echo '<div class="news_today">';
									echo '<a href="news.php?News_ID='. $news['News_ID'] .'"><p>'. $news['News_Title'] .' </p></a>';
								echo '</div>';

							}

						} else {

							echo '<div class="news_today">';
								echo '<p>لا يوجد أخبار</p>';
							echo '</div>';

						}


					?>
					<a href="news.php"> <button class="btn btn-danger"> للمزيد </button></a>
				</div>
			</div>
			<!-- Left Side End ############################################################################################ -->
		</div>
	</div>
</div>
<?php

    ob_end_flush();

    include $TempDir . 'footer.php'; 
    
?>
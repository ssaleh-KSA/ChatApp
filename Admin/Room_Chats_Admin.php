<?php 

    ob_start();

	session_start();

	if(isset($_SESSION['User_Admin']) && $_SESSION['User_Admin'] == 1) {

		include 'init.php'; 

		date_default_timezone_set('Asia/Riyadh');
		$time_Now = date('h:i');

		?>

		<div class="container">
			<div class="Page-First text-center">التحكم - غرف المحادثات</div>
			<hr>
			<a href="Add_Chat_Room.php"> <button class="btn btn-success btn-block">أضف غرفة</button> </a>
			<br><br>
			<div class="Room_Chats">
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
										echo '<img src="../Uploads/Images/Room_Chats_Images/'. $Rooms['Room_Image'] .'" alt="'. $Rooms['Room_Name'] .'" class="img-responsive img-thumbnail">';
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

							echo '<div class="alert alert-warning text-center">لا يوجد غرف</div>';

						}

					?>
				</div>
			</div>
		</div>

<?php
		include $TempDir . 'footer.php';

	} else {

		header('Location: Login_Out.php');
		exit();

	}
	
	
	ob_end_flush();

?>
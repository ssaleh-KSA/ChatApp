<?php

	ob_start();

	if(!isset($_SESSION)) {

		session_start();

	}

	include 'init.php';

	if(!isset($_SESSION['user_membership']) && !isset($_SESSION['User_ID'])) {

		header('Location: membership_Login.php');
		exit();

	} else { 

		$user_ID = $_SESSION['User_ID'];

		$Check_SESSION = $con-> prepare("SELECT ID FROM users WHERE ID = ?");
		$Check_SESSION-> execute(array($user_ID));
		$SESSION_Count = $Check_SESSION-> rowCount();
		if($SESSION_Count == 0) {

			header('Location: LoginOut.php');
			exit();

		}

?>

<div class="container">
	<?php

		include $TempDir . 'ads_and_secBtn.php';


		$Room_Name = isset($_GET['RoomName']) ? $_GET['RoomName'] : 0;
		$R_Name = filter_var($Room_Name, FILTER_SANITIZE_STRING);
		$Room_N = str_replace('-', ' ', $R_Name);

		$Get_All_Rooms = $con-> prepare("SELECT * FROM chat_rooms WHERE Room_Name = ?");
		$Get_All_Rooms-> execute(array($Room_N));
		$Count = $Get_All_Rooms-> rowCount();

		if($Count > 0) {

			$FetchInfo = $Get_All_Rooms-> fetch();
			$Room_ID = $FetchInfo['Room_ID'];

			$_SESSION['Room_ID'] = $Room_ID;

		} else {

			echo '<div class="alert alert-danger"> لا يوجد غرفة بهذا الأسم, رجاءاً قم بأخيار الغرفة من <a href="index.php" class="btn btn-primary"> هنا </a> </div>';

		}


	?>
	 <h3 class="Page-First text-center"><?php echo $Room_Name; ?></h3>
	<div class="chat_main">
		<div class="row">
			<div class="col-lg-3">
				<div class="chat_info">
					<?php 

						if(isset($Room_N)) {

							$user_ID = $_SESSION['User_ID'];
							$get_user_in_chat = $con-> prepare("SELECT * FROM chat_rooms WHERE Room_ID = ?");
							$get_user_in_chat-> execute(array($Room_ID));
							$array_Of_Members = $get_user_in_chat-> fetch();

							$User_In_Room = $array_Of_Members['Members_In_Room'];
							$To_array = explode(',', $User_In_Room);
							if(in_array($user_ID, $To_array)) {

								$New_User_In_Room = $To_array;

							} else {

								$Array_To_String = implode(',', $To_array);
								$New_User_In_Room = $Array_To_String . $user_ID . ',';

								$Add_user_In_Members_In_Room = $con-> prepare("UPDATE chat_rooms SET Members_In_Room = ? WHERE Room_ID = ?");
								$Add_user_In_Members_In_Room-> execute(array($New_User_In_Room, $Room_ID));

							}

						}

					?>
						<span>
							<?php

									$Get_ID_IN_Room = explode(',', $User_In_Room);
									foreach($Get_ID_IN_Room as $users_in_Room) {

										$Get_users_Info = $con-> prepare("SELECT * FROM users WHERE ID = ?");
										$Get_users_Info-> execute(array($users_in_Room));
										$User_Check = $Get_users_Info-> rowCount();
										if($User_Check > 0) {

											$User_Info = $Get_users_Info-> fetch();
											echo '<div class="user_in_chat">';
											if($User_Info['User_Name'] == $_SESSION['user_membership']) {

												echo '<span> Me </span>';

											} else {

												echo '<span>'. $User_Info['User_Name'] .'</span>';

											}

											echo '</div>';


										}
									}

							?>
						</span>
				</div>
			</div>
			<div class="col-lg-9">
				<div class="row">
					<div class="chat_text">
					
					</div>
				</div>
			</div>
			<form class="fomr-group">
				<div class="col-lg-10">
					<div class="message_Send">
						<input type="text" name="message_input" id="message_input" class="form-control" placeholder="أكتب رسالتك هنا...">
						<input type="hidden" name="username" id="username" value="<?php echo $_SESSION['user_membership']; ?>">
						<input type="hidden" name="User_ID" id="User_ID" value="<?php echo $_SESSION['User_ID']; ?>">
						<input type="hidden" name="Room_ID" id="Room_ID" value="<?php echo $Room_ID; ?>">
					</div>
				</div>
				<div class="col-lg-1">
					<div class="Emoji_Button">
						<i class="fa fa-smile-o" aria-hidden="true"></i>
					</div>
				</div>
				<div class="col-lg-1">
					<div class="button_Send">
						<input type="submit" name="Send_messgae" id="Send_messgae" class="btn btn-success">
					</div>
				</div>
			</form>
			<div class="emojis_alert">
				<img src='em/angry.png' id=":angry:">
			<img src='em/bigsmile.png' id=":bigsmile:">
			<img src='em/blink.png' id=":blink:">
			<img src='em/bored.png' id=":bored:">
			<img src='em/bored2.png' id=":bored2:">
			<img src='em/calm.png' id=":calm:">
			<img src='em/clap.png' id=":clap:">
			<br>
			<img src='em/cool.png' id=":cool:">
			<img src='em/cry.png' id=":cry:">
			<img src='em/devil.png' id=":devil:">
			<img src='em/facepalm.png' id=":facepalm:">
			<img src='em/feww.png' id=":feww:">
			<img src='em/flower.png' id=":flower:">
			<img src='em/funny.png' id=":funny:">
			<br>
			<img src='em/genius.png' id=":genius:">
			<img src='em/good.png' id=":good:">
			<img src='em/heart.png' id=":heart:">
			<img src='em/hey.png' id=":hey:">
			<img src='em/hmm.png' id=":hmm:">
			<img src='em/hono.png' id=":hono:">
			<img src='em/inocent.png' id=":inocent:">
			<br>
			<img src='em/joy.png' id=":joy:">
			<img src='em/lol.png' id=":lol:">
			<img src='em/love.png' id=":love:">
			<img src='em/loveyou.png' id=":loveyou:">
			<img src='em/mad.png' id=":mad:">
			<img src='em/mute.png' id=":mute:">
			<img src='em/neutral.png' id=":neutral:">
			<br>
			<img src='em/nice.png' id=":nice:">
			<img src='em/ninja.png' id=":ninja:">
			<img src='em/nothing.png' id=":nothing:">
			<img src='em/omg.png' id=":omg:">
			<img src='em/peace.png' id=":peace:">
			<img src='em/pray.png' id=":pray:">
			<img src='em/sad.png' id=":sad:">
			<br>
			<img src='em/sadic.png' id=":sadic:">
			<img src='em/scare.png' id=":scare:">
			<img src='em/shy.png' id=":shy:">
			<img src='em/shysmile.png' id=":shysmile:">
			<img src='em/sleep.png' id=":sleep:">
			<img src='em/smile.png' id=":smile:">
			<img src='em/stink.png' id=":stink:">
			<br>
			<img src='em/tongue.png' id=":tongue:">
			<img src='em/tongue2.png' id=":tongue2:">
			<img src='em/unsure.png' id=":unsure:">
			<img src='em/wakeup.png' id=":wakeup:">
			<img src='em/win.png' id=":win:">
			<img src='em/yeahyeah.png' id=":yeahyeah:">
			</div>
		</div>
	</div>
</div>

<?php include $TempDir . 'footer.php'; ?>

<script type="text/javascript">

$(document).ready(function () {

	setInterval(function() {

		get_Messages();
		$(".chat_text").scrollTop($(".chat_text")[0].scrollHeight);

	}, 2000);

	function get_Messages() {

		var action = 'GetMessages';
		var Room_ID = $('#Room_ID').val();
		var username = $('#username').val();
		$.ajax({

			url: 'Chats_Text_Set_And_Get.php',
			method: 'POST',
			data: {action: action, Room_ID: Room_ID, username: username},
			success: function(data) {

				$('.chat_text').html(data);

			}

		});

	}
	
	$(document).on('click', '.Emoji_Button', function() {

		if($('.emojis_alert').hasClass('shwo')) {

			$('.emojis_alert').removeClass('shwo');

		} else {

			$('.emojis_alert').addClass('shwo');

		}

	});

	$(document).on('click', '.emojis_alert img', function() {

		var img_name = $(this).attr('id');

		var last = $('#message_input').val();
		$('#message_input').val(last+img_name);
		$('.emojis_alert').removeClass('shwo');

	});

	$(document).on('click', '#Send_messgae', function(e) {

		e.preventDefault();

		var Message = $('#message_input').val();
		var Username = $('#username').val();
		var Room_ID = $('#Room_ID').val();
		var action = 'AddMessage';
		$.ajax({

			url: 'Chats_Text_Set_And_Get.php',
			method: 'POST',
			data: {action: action, Username: Username, Message: Message, Room_ID: Room_ID},
			success: function() {

				$('#message_input').val('');
				get_Messages();
				$(".chat_text").scrollTop($(".chat_text")[0].scrollHeight);

			}

		});

	});

	$(document).on('click', '.delete_chat', function() {

		var Chat_ID = $(this).attr('id');
		var action = 'Delete_Chat';
		if(confirm("هل أنت تريد فعلاً حذف هذه الرسالة")) {

			$.ajax({

				url: 'Delete.php',
				method: 'POST',
				data: {action: action, Chat_ID: Chat_ID},
				beforeSend: function() {

					$('.delete_chat[id='+Chat_ID+']').html('<img src="img/1.gif" style="width: 20px;height: 18px;">');

				},
				success: function() {

					$('.chat_ID_'+Chat_ID+'').css('background-color', '#CCC');
					$('.chat_ID_'+Chat_ID+'').fadeOut(1000);

				}

			});

		}

	});

	$(document).on('click', '.Report_Abuse', function() {

		if($(this).hasClass('The_Report_Send')) {

			return false;

		} else {


			var Chat_Report_ID = $(this).attr('id');
			var Room_ID = $('#Room_ID').val();
			var User_ID = $('#User_ID').val();
			var action = 'Report_Abuse';
			if(confirm("هل تريد البلاغ عن هذه الرسالة")) {

				$.ajax({

					url: 'Report_Abuse.php',
					method: 'POST',
					data: {action: action, Chat_Report_ID: Chat_Report_ID, Room_ID: Room_ID, User_ID: User_ID},
					beforeSend: function() {

						$('.Report_Abuse[id='+Chat_Report_ID+']').html('<img src="img/1.gif" style="width: 20px;height: 18px;">');

					},
					success: function() {

						$('.Report_Abuse[id='+Chat_Report_ID+']').text("تم أرسال البلاغ").addClass('The_Report_Send');
						$('.Report_Abuse[id='+Chat_Report_ID+'] img').remove();
						alert('ـم إرسال البلاغ, سيتم التعامل معه في أقرب فرصة, شكراً لك');

					}

				});

			}

		}

	});

});

</script>

<?php } 

ob_end_flush();
?>
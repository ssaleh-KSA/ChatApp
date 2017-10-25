<?php 

	include 'connect.php';

		$emot = array("<img src='em/angry.png'>",
					 "<img src='em/bigsmile.png'>",
					 "<img src='em/blink.png'>",
					 "<img src='em/bored.png'>",
					 "<img src='em/bored2.png'>",
					 "<img src='em/calm.png'>",
					 "<img src='em/clap.png'>",
					 "<img src='em/cool.png'>",
					 "<img src='em/cry.png'>",
					 "<img src='em/devil.png'>",
					 "<img src='em/facepalm.png'>",
					 "<img src='em/feww.png'>",
					 "<img src='em/flower.png'>",
					 "<img src='em/funny.png'>",
					 "<img src='em/genius.png'>",
					 "<img src='em/good.png'>",
					 "<img src='em/heart.png'>",
					 "<img src='em/hey.png'>",
					 "<img src='em/hmm.png'>",
					 "<img src='em/hono.png'>",
					 "<img src='em/inocent.png'>",
					 "<img src='em/joy.png'>",
					 "<img src='em/lol.png'>",
					 "<img src='em/love.png'>",
					 "<img src='em/loveyou.png'>",
					 "<img src='em/mad.png'>",
					 "<img src='em/mute.png'>",
					 "<img src='em/neutral.png'>",
					 "<img src='em/nice.png'>",
					 "<img src='em/ninja.png'>",
					 "<img src='em/nothing.png'>",
					 "<img src='em/omg.png'>",
					 "<img src='em/peace.png'>",
					 "<img src='em/pray.png'>",
					 "<img src='em/sad.png'>",
					 "<img src='em/sadic.png'>",
					 "<img src='em/scare.png'>",
					 "<img src='em/shy.png'>",
					 "<img src='em/shysmile.png'>",
					 "<img src='em/sleep.png'>",
					 "<img src='em/smile.png'>",
					 "<img src='em/stink.png'>",
					 "<img src='em/tongue.png'>",
					 "<img src='em/tongue2.png'>",
					 "<img src='em/unsure.png'>",
					 "<img src='em/wakeup.png'>",
					 "<img src='em/win.png'>",
					 "<img src='em/yeahyeah.png'>");

//emoticon string variable
$replace = array(":angry:",
					 ":bigsmile:",
					 ":blink:",
					 ":bored:",
					 ":bored2:",
					 ":calm:",
					 ":clap:",
					 ":cool:",
					 ":cry:",
					 ":devil:",
					 ":facepalm:",
					 ":feww:",
					 ":flower:",
					 ":funny:",
					 ":genius:",
					 ":good:",
					 ":heart:",
					 ":hey:",
					 ":hmm:",
					 ":hono:",
					 ":inocent:",
					 ":joy:",
					 ":lol:",
					 ":love:",
					 ":loveyou:",
					 ":mad:",
					 ":mute:",
					 ":neutral:",
					 ":nice:",
					 ":ninja:",
					 ":nothing:",
					 ":omg:",
					 ":peace:",
					 ":pray:",
					 ":sad:",
					 ":sadic:",
					 ":scare:",
					 ":shy:",
					 ":shysmile:",
					 ":sleep:",
					 ":smile:",
					 ":stink:",
					 ":tongue:",
					 ":tongue2:",
					 ":unsure:",
					 ":wakeup:",
					 ":win:",
					 ":yeahyeah:");

	if(isset($_POST['action'])) {

		if($_POST['action'] == 'AddMessage') {

			date_default_timezone_set('Asia/Riyadh');
			$date = date('F j, Y');
			$time_Now = date('h:i');

			$Message = $_POST['Message'];
			$username = $_POST['Username'];
			$Room_ID = $_POST['Room_ID'];
			$Add_Message_Stmt = $con-> prepare("INSERT INTO texts_chats(Text_Chat, Text_Date, Text_Time, Text_Sender, Chat_Room)
												VALUES(:TChat, :TDate, :TTime, :TSender, :TRoom)");
			$Add_Message_Stmt-> execute(array(

				'TChat' => $Message,
				'TDate' => $date,
				'TTime' => $time_Now,
				'TSender' => $username,
				'TRoom' => $Room_ID

			));

		} elseif ($_POST['action'] == 'GetMessages') {

			$Room_ID = $_POST['Room_ID'];
			$username = $_POST['username'];

			$get_user_Group_ID = $con-> prepare("SELECT * FROM users WHERE User_Name = ?");
			$get_user_Group_ID-> execute(array($username));
			$User_check = $get_user_Group_ID-> rowCount();
			if($User_check > 0) {

				$fetch_data = $get_user_Group_ID-> fetch();
				$User_Group_ID = $fetch_data['User_Group'];

			}

			date_default_timezone_set('Asia/Riyadh');
			$time_now = date('h:i');
			$Get_All_Chats_Text = $con-> prepare("SELECT * FROM texts_chats WHERE Chat_Room = ?");
			$Get_All_Chats_Text-> execute(array($Room_ID));
			$Count_Of_Chats = $Get_All_Chats_Text-> rowCount();
			if($Count_Of_Chats > 0) {

				$Chats = $Get_All_Chats_Text-> fetchAll();
				foreach($Chats as $chats_text) {

					$img_replace = str_replace($replace, $emot, $chats_text['Text_Chat']);

					if($username === $chats_text['Text_Sender']) {

						echo '<div class="user_messages chat_ID_'. $chats_text['Text_ID'] .'">';
							echo '<div class="col-lg-2">';
								if($username === $chats_text['Text_Sender']) {

									echo '<b>Me:</b>';

								} else {

									echo '<b>' . $chats_text['Text_Sender'] . ':</b>';

								}
							echo '</div>';
							echo '<div class="col-lg-8">';
								echo '<span> ' . $img_replace . '</span>';
								echo '<br>';
							echo '</div>';
							if($time_now == $chats_text['Text_Time']) {

								echo '<div class="col-lg-2">';
									if($User_Group_ID == 1) {

										echo '<p class="pull-left delete_chat" id="'. $chats_text['Text_ID'] .'">حذف</p>';

									} else {

										echo '<p class="pull-left Report_Abuse" id="'. $chats_text['Text_ID'] .'">الإبلاغ عن أساءة</p>';

									}
									echo '<small class="msg_time pull-left">' . $chats_text['Text_Date'] . '<br>' . 'الان</small>';
								echo '</div>';

							} else {

								echo '<div class="col-lg-2">';
									if($User_Group_ID == 1) {

										echo '<p class="pull-left delete_chat" id="'. $chats_text['Text_ID'] .'">حذف</p>';

									} else {

										echo '<p class="pull-left Report_Abuse" id="'. $chats_text['Text_ID'] .'">الإبلاغ عن أساءة</p>';

									}
									echo '<small class="msg_time pull-left">' . $chats_text['Text_Date'] . '<br>' . $chats_text['Text_Time'] . '</small>';
								echo '</div>';

							}
						echo '</div>';

					} else {

						echo '<div class="users_messages chat_ID_'. $chats_text['Text_ID'] .'">';
							echo '<div class="col-lg-2">';
								echo '<b>' . $chats_text['Text_Sender'] . ':</b>';
							echo '</div>';
							echo '<div class="col-lg-8">';
								echo '<span> ' . $img_replace . '</span>';
								echo '<br>';
							echo '</div>';
							if($time_now == $chats_text['Text_Time']) {

								echo '<div class="col-lg-2">';
									if($User_Group_ID == 1) {

										echo '<p class="pull-left delete_chat" id="'. $chats_text['Text_ID'] .'">حذف</p>';

									} else {

										echo '<p class="pull-left Report_Abuse" id="'. $chats_text['Text_ID'] .'">الإبلاغ عن أساءة</p>';

									}
									echo '<small class="msg_time pull-left">' . $chats_text['Text_Date'] . '<br>' . 'الان</small>';
								echo '</div>';

							} else {

								echo '<div class="col-lg-2">';
									if($User_Group_ID == 1) {

										echo '<p class="pull-left delete_chat" id="'. $chats_text['Text_ID'] .'">حذف</p>';

									} else {

										echo '<p class="pull-left Report_Abuse" id="'. $chats_text['Text_ID'] .'">الإبلاغ عن أساءة</p>';

									}
									echo '<small class="msg_time pull-left">' . $chats_text['Text_Date'] . '<br>' . $chats_text['Text_Time'] . '</small>';
								echo '</div>';

							}
						echo '</div>';

					}

				}

			} else {

				echo '
					<div class="col-lg-12">
					<div class="alert alert-danger"> لا يوجد محادثات حالياً, شارك بأول رسالة </div>
					</div>
				';

			}

		} else {



		}

	}

?>
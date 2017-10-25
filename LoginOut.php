<?php 

    ob_start();

	session_start();

	require_once('connect.php');

	$username = $_SESSION['user_membership'];

	$Chaech_User_Stmt = $con-> prepare("SELECT User_Type FROM users WHERE User_Name = ?");
	$Chaech_User_Stmt-> execute(array($username));
	$User_Type = $Chaech_User_Stmt-> fetch();

	if($User_Type['User_Type'] == '1') {

		$Delete_NickName_Stmt = $con-> prepare("DELETE FROM users WHERE User_Name = ?");
		$Delete_NickName_Stmt-> execute(array($username));

		$Room_ID = $_SESSION['Room_ID'];
		$User_ID = $_SESSION['User_ID'];

		$get_Room_info = $con-> prepare("SELECT * FROM chat_rooms WHERE Room_ID = ?");
		$get_Room_info-> execute(array($Room_ID));
		$Room_Count = $get_Room_info-> rowCount();
		if($Room_Count > 0) {

			$get_users = $get_Room_info-> fetch();
			$users = $get_users['Members_In_Room'];
			$To_array = explode(',', $users);
			if(in_array($User_ID, $To_array)) {

				$remove = array($User_ID);
				$new_array = array_diff($To_array,$remove);

				$To_String = implode(',', $new_array);
				$Update_New_Memeber_In_Room = $con-> prepare("UPDATE chat_rooms SET Members_In_Room = ? WHERE Room_ID = ?");
				$Update_New_Memeber_In_Room-> execute(array($To_String, $Room_ID));

			}

		}

		session_unset();
		session_destroy();
		header('Location: index.php');
		exit();

	} else {

		$Room_ID = $_SESSION['Room_ID'];
		$User_ID = $_SESSION['User_ID'];

		$get_Room_info = $con-> prepare("SELECT * FROM chat_rooms WHERE Room_ID = ?");
		$get_Room_info-> execute(array($Room_ID));
		$Room_Count = $get_Room_info-> rowCount();
		if($Room_Count > 0) {

			$get_users = $get_Room_info-> fetch();
			$users = $get_users['Members_In_Room'];
			$To_array = explode(',', $users);
			if(in_array($User_ID, $To_array)) {

				$remove = array($User_ID);
				$new_array = array_diff($To_array,$remove);

				$To_String = implode(',', $new_array);
				$Update_New_Memeber_In_Room = $con-> prepare("UPDATE chat_rooms SET Members_In_Room = ? WHERE Room_ID = ?");
				$Update_New_Memeber_In_Room-> execute(array($To_String, $Room_ID));

			}

		}

		session_unset();
		session_destroy();
		header('Location: index.php');
		exit();

	}	

ob_end_flush();
?>

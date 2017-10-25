<?php 

	include 'connect.php';

	if($_POST['action']) {

		if($_POST['action'] == 'Delete_Chat') {

			$Chat_ID = $_POST['Chat_ID'];
			$Delete_Chat_Stmt = $con-> prepare("DELETE FROM texts_chats WHERE Text_ID = ?");
			$Delete_Chat_Stmt-> execute(array($Chat_ID));

		}

	}

?>
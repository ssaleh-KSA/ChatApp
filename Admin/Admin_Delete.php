
<?php 

    ob_start();

	include 'connect.php';

	if($_POST['action']) {

		if($_POST['action'] == 'Delete_Complaints') {

			$Complaints_ID = $_POST['Complaints_ID'];

			$Delete_Complaints_Stmt = $con-> prepare("DELETE FROM complaints WHERE Complaints_ID = ?");
			$Delete_Complaints_Stmt-> execute(array($Complaints_ID));
			if($Delete_Complaints_Stmt) {

				echo "تم حذف الشكوى";

			} else {

				echo 'هناك خطأ';

			}

		}

		if($_POST['action'] == 'News_Delete') {

			$News_ID = $_POST['News_ID'];
			$Delete_News_Stmt = $con-> prepare("DELETE FROM news WHERE News_ID = ?");
			$Delete_News_Stmt-> execute(array($News_ID));

		}

		if($_POST['action'] == 'Delete_Mumber') {

			$User_ID = $_POST['Member_ID'];
			$Delete_Mumber_Stmt = $con-> prepare("DELETE FROM users WHERE ID = ?");
			$Delete_Mumber_Stmt-> execute(array($User_ID));

			if($Delete_Mumber_Stmt) {

				echo 'تم حذف العضو!';

			} else {

				echo 'هناك خطأ!';

			}

		}

		if($_POST['action'] == 'Delete_Abuse') {

			$Abuse_ID = $_POST['Abuse_ID'];
			$Delete_Mumber_Stmt = $con-> prepare("DELETE FROM report_abuse WHERE Abuse_ID = ?");
			$Delete_Mumber_Stmt-> execute(array($Abuse_ID));

		}

		if($_POST['action'] == 'Delete_Chat_Text') {

			$Chat_ID = $_POST['Chat_Text_ID'];
			$Delete_Mumber_Stmt = $con-> prepare("DELETE FROM texts_chats WHERE Text_ID = ?");
			$Delete_Mumber_Stmt-> execute(array($Chat_ID));

		}

	}

ob_end_flush();

?>
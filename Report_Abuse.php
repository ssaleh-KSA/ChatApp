<?php 

	include 'connect.php';

	if($_POST['action']) {

		if($_POST['action'] == 'Report_Abuse') {

			date_default_timezone_set('Asia/Riyadh');
			$date = date('F j, Y');
			$time = date('h:i');
			$date_Now = $date . ' الساعة: ' . $time;

			$Chat_Report_ID = $_POST['Chat_Report_ID'];
			$Room_ID = $_POST['Room_ID'];
			$User_ID = $_POST['User_ID'];

			$Check_Abuse_Stmt = $con-> prepare("SELECT * FROM report_abuse WHERE Abuse_In_Text_DI = ?");
			$Check_Abuse_Stmt-> execute(array($Chat_Report_ID));
			$Abuse_Count = $Check_Abuse_Stmt-> rowCount();
			if($Abuse_Count > 0) {

				$Num = 1;
				$Get_Info = $Check_Abuse_Stmt-> fetch();
				$Count = $Get_Info['Abuse_Count'];
				$A_Count = $Count + $Num;
				$Abuse_Update_Stmt = $con-> prepare("UPDATE report_abuse SET Abuse_Count = ? WHERE Abuse_In_Text_DI = ?");
				$Abuse_Update_Stmt-> execute(array($A_Count, $Chat_Report_ID));

				if($Abuse_Update_Stmt) {

					echo "Abuse Updated";

				} else {

					echo "Abuse Not Updated";

				}

			} else {

				$Add_New_Abuse = $con-> prepare("INSERT INTO report_abuse(Abuse_In_Text_DI, Abuse_Report_Send_Date, Abuse_In_Room_ID, Abuse_Count) 
												 VALUES(:ChatID, :ReportDate, :AbuseInRoom, :AbuseCount)");
				$Add_New_Abuse-> execute(array(

					'ChatID' => $Chat_Report_ID,
					'ReportDate' => $date_Now,
					'AbuseInRoom' => $Room_ID,
					'AbuseCount' => '1'

				));

				if($Add_New_Abuse) {

					echo "Abuse Send";

				} else {

					echo "Abuse Not Send";

				}

			}

		}

	}

?>
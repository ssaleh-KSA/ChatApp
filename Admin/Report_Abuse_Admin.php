<?php 

    ob_start();

	session_start();

	if(isset($_SESSION['User_Admin']) && $_SESSION['User_Admin'] == 1) {

		include 'init.php'; 

		date_default_timezone_set('Asia/Riyadh');
		$time_Now = date('h:i');

		$Get_All_Report_Abuse = $con-> prepare("SELECT report_abuse.*,
											texts_chats.Text_Chat AS Text_String,
											chat_rooms.Room_Name AS Room_Chat
											FROM  report_abuse
											JOIN texts_chats 
											ON texts_chats.Text_ID = report_abuse.Abuse_In_Text_DI
											JOIN chat_rooms
											ON chat_rooms.Room_ID = report_abuse.Abuse_In_Room_ID
											ORDER BY Abuse_ID DESC");
		$Get_All_Report_Abuse-> execute();
		$Report_Abuse_Count = $Get_All_Report_Abuse-> rowCount(); ?>


		<div class="container">
			<div class="Page-First text-center">التحكم - البلاغات عن أساءة</div>
			<hr>
			<table class="table table-striped text-center">
				<tr>
					<td>تاريخ البلاغ</td>
					<td>عدد مرات البلاغ على النص</td>
					<td>النص المقدم فيه لابلاغ</td>
					<td>الغرفة التي حصل فيها البلاغ</td>
					<td>حذف البلاغ</td>
					<td>حذف النص المقدم البلاغ عليه</td>
				</tr>
<?php
				if($Report_Abuse_Count > 0) {

					$Report_Abuse_Info = $Get_All_Report_Abuse-> fetchAll();

					foreach($Report_Abuse_Info as $Report_Abuse) {

						echo '<tr id="Abuse_row_ID_'. $Report_Abuse['Abuse_ID'] .'">';
							echo '<td>'. $Report_Abuse['Abuse_Report_Send_Date'] .'</td>';
							echo '<td>'. $Report_Abuse['Abuse_Count'] .'</td>';
							echo '<td>'. $Report_Abuse['Text_String'] .'</td>';
							echo '<td>'. $Report_Abuse['Room_Chat'] .'</td>';
							echo '<td><a class="btn btn-danger Delete_Abuse Abuse_ID_'. $Report_Abuse['Abuse_ID'] .'" id="'. $Report_Abuse['Abuse_ID'] .'">حذف</a></td>';
							echo '<td class="Abuse_Remove_'. $Report_Abuse['Abuse_In_Text_DI'] .'"><a class="btn btn-danger Delete_chat_Text chat_Text_ID_'. $Report_Abuse['Abuse_In_Text_DI'] .'" data-Abuse-ID="'. $Report_Abuse['Abuse_ID'] .'" id="'. $Report_Abuse['Abuse_In_Text_DI'] .'">حذف</a></td>';
						echo '</tr>';

					}

				} else {

					echo '<tr><div class="alert alert-warning text-center">لا يوجد بلاغات </div></tr>';

				}
?>
			</table>
		</div>

<?php
		include $TempDir . 'footer.php';

	} else {

		header('Location: Login_Out.php');
		exit();

	}
	
	ob_end_flush();

?>
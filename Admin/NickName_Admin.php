<?php 

    ob_start();

	session_start();

	if(isset($_SESSION['User_Admin']) && $_SESSION['User_Admin'] == 1) {

		include 'init.php'; 

		date_default_timezone_set('Asia/Riyadh');
		$time_Now = date('h:i');

		$Get_All_NickNames = $con-> prepare("SELECT * FROM users WHERE User_Type = 1 ORDER BY ID DESC");
		$Get_All_NickNames-> execute();
		$NickNames_Count = $Get_All_NickNames-> rowCount(); ?>

		<div class="container">
			<div class="Page-First text-center">التحكم - الأسماء المستعارة</div>
			<hr>
			<table class="table table-striped text-center">
				<tr>
					<td>الأسم المستعار</td>
					<td>تاريخ التسجيل</td>
					<td>التحكم</td>
				</tr>
<?php
				if($NickNames_Count > 0) {

					$NickNames_Info = $Get_All_NickNames-> fetchAll();
					foreach($NickNames_Info as $NickNames) {

						echo '<tr id="row_ID_'. $NickNames['ID'] .'">';
							echo '<td>'. $NickNames['User_Name'] .'</td>';
							echo '<td>'. $NickNames['Login_Date'] .'</td>';
							echo '<td><a class="btn btn-danger Delete_Mumber Member_ID_'. $NickNames['ID'] .'" id="'. $NickNames['ID'] .'">حذف</a></td>';
						echo '</tr>';

					}

				} else {

					echo '<tr><div class="alert alert-warning text-center">لا يوجد أسماء مستعارة</div></tr>';

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
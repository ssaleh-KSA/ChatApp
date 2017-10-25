<?php 

    ob_start();

	session_start();

	if(isset($_SESSION['User_Admin']) && $_SESSION['User_Admin'] == 1) {

		include 'init.php'; 

		date_default_timezone_set('Asia/Riyadh');
		$time_Now = date('h:i');

		$Get_All_Members = $con-> prepare("SELECT * FROM users WHERE User_Type = 0 ORDER BY ID DESC");
		$Get_All_Members-> execute();
		$Members_Count = $Get_All_Members-> rowCount(); ?>

		<div class="container">
			<div class="Page-First text-center">التحكم - بالأعضاء</div>
			<hr>
			<table class="table table-striped text-center">
				<tr>
					<td>الأسم المستعار</td>
					<td>الدولة</td>
					<td>الأسم كامل</td>
					<td>الجنس</td>
					<td>تاريخ الميلاد</td>
					<td>نوع العضوية</td>
					<td>تاريخ التسجيل</td>
					<td>التحكم</td>
				</tr>
<?php
				if($Members_Count > 0) {

					$Members_Info = $Get_All_Members-> fetchAll();
					foreach($Members_Info as $Members) {

						echo '<tr id="row_ID_'. $Members['ID'] .'">';
							echo '<td>'. $Members['User_Name'] .'</td>';
							echo '<td>'. $Members['User_Country'] .'</td>';
							echo '<td>'. $Members['User_FullName'] .'</td>';
							if($Members['User_Sex'] == 1) {
								echo '<td>ذكر</td>';
							} else {
								echo '<td>أنثى</td>';
							}
							echo '<td>'. $Members['User_Birthday'] .'</td>';
							if($Members['User_Group'] == 1) {
								echo '<td>مشرف</td>';
							} else {
								echo '<td>مستخدم</td>';
							}
							echo '<td>'. $Members['Login_Date'] .'</td>';
							echo '<td><a class="btn btn-danger Delete_Mumber Member_ID_'. $Members['ID'] .'" id="'. $Members['ID'] .'">حذف</a></td>';
						echo '</tr>';

					}

				} else {

					echo '<tr><div class="alert alert-warning text-center">لا يوجد أعضاء</div></tr>';

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
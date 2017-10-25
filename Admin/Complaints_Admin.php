<?php

    ob_start();

	if(!isset($_SESSION['User_Admin'])) {

		session_start();

	}

	if(isset($_SESSION['User_Admin']) && $_SESSION['User_Admin'] == 1) {

		include 'init.php'; 

		$Complaints = '';
		if(isset($_GET['Complaints'])) {

			$Complaints = $_GET['Complaints'];

		} else {

			$Complaints = 'Main';

		}

		if($Complaints == 'Main') {

			date_default_timezone_set('Asia/Riyadh');
					$time_Now = date('h:i');

					?>

					<div class="container">
						<div class="Page-First text-center">التحكم - الشكاوى</div>
						<hr>
						<table class="table table-striped text-center">
						   <tr>
						   		<td>رقم الشكوى</td>
						   		<td>المرسل</td>
						   		<td>التاريخ</td>
						   		<td>الرسالة</td>
						   		<td>حالة الشكوى</td>
						   		<td>التحكم</td>
						   </tr>
								<?php 

									$Get_All_Complaints = $con-> prepare("SELECT * FROM complaints ORDER BY Complaints_ID DESC");
									$Get_All_Complaints-> execute();
									$Count = $Get_All_Complaints-> rowCount();
									if($Count > 0) {

										$Complaints_info = $Get_All_Complaints-> fetchAll();
										foreach($Complaints_info as $Complaints) {

											echo '<tr class="Com_ID_'. $Complaints['Complaints_ID'] .'">';
												echo '<td>'. $Complaints['Complaints_ID'] .'</td>';
												echo '<td>'. $Complaints['Complaints_Sender'] .'</td>';
												echo '<td>'. $Complaints['Complaints_Date'] .'</td>';
												echo '<td><a href="Complaints_Admin.php?Complaints=Complaints_Details&Com_ID='. $Complaints['Complaints_ID'] .'" class="btn btn-success">مشاهدة</a></td>';
													echo '<td>';
														if($Complaints['Complaints_Status'] == 1) {

															echo '<p class="text-danger">لم يتم الرد</p>';

														} else {

															echo '<p class="text-success">تم الرد</p>';

														}
													echo '</td>';
												echo '<td><a class="btn btn-danger Complaints_ID IDis_'. $Complaints['Complaints_ID'] .'" id="'. $Complaints['Complaints_ID'] .'">حذف</a></td>';
											echo '</tr>';

										}

									} else {

										echo '<div class="alert alert-warning text-center">لا يوجد شكاوى</div>';

									}

								?>
						</table>
					</div>

<?php

		} elseif($Complaints == 'Complaints_Details') {

			$Complaints_ID = isset($_GET['Com_ID']) && is_numeric($_GET['Com_ID']) ? intval($_GET['Com_ID']) : 0;
			$Get_Complaints_Stmt = $con-> prepare("SELECT * FROM complaints WHERE Complaints_ID = ?");
			$Get_Complaints_Stmt-> execute(array($Complaints_ID));
			$Complaints_Count = $Get_Complaints_Stmt-> rowCount();
			if($Complaints_Count > 0) {

				$Complaints_Info = $Get_Complaints_Stmt-> fetch();
				$User_Name = $Complaints_Info['Complaints_Sender'];
				$Get_User_Sender_Complaints = $con-> prepare("SELECT * FROM users WHERE User_Name = ?");
				$Get_User_Sender_Complaints-> execute(array($User_Name));
				$User_Count = $Get_User_Sender_Complaints-> rowCount();
				if($User_Count > 0) { 

					$User_Info = $Get_User_Sender_Complaints-> fetch();

					?>

					<div class="container">
						<div class="Page-First text-center">تفاصيل الشكوىل المقدمة من, <?php echo $User_Name; ?></div>
						<div class="Complaints_Page">
							<h3>بيانات مرسل الشكوى</h3>
							<div class="table-responsive">
								<table class="table table-striped text-center">
									<tr>
										<td>نوع الأشتراك</td>
										<td>أسم المستخدم</td>
										<td>الدولة</td>
										<td>الأسم كامل</td>
										<td>الجنس</td>
										<td>تاريخ الميلاد</td>
										<td>الصلاحيات</td>
									</tr>
									<tr>
										<td>
										<?php
											if($User_Info['User_Type'] == '0') {
												echo "مشترك بعضوية";
											} else {
												echo "مشترك بأسم مستعار";
											}
										?>
										</td>
										<td><?php echo $User_Info['User_Name'] ?></td>
										<td><?php echo $User_Info['User_Country'] ?></td>
										<td><?php echo $User_Info['User_FullName'] ?></td>
										<td>
										<?php
											if($User_Info['User_Sex'] == '1') {
												echo "ذكر";
											} else {
												echo "أنثى";
											}
										?>
										</td>
										<td><?php echo $User_Info['User_Birthday'] ?></td>
										<td>
										<?php
											if($User_Info['User_Group'] == '1') {
												echo "مشرف";
											} else {
												echo "مستخدم";
											}
										?>
										</td>
									</tr>
								</table>
							</div>
							<hr>
							</div>
							<h3>تفاصيل الشكوى</h3>
							<div class="Complaints_box">
								<div class="row">
									<div class="col-lg-12">
										<h4>أرسلت بتاريخ -- <?php echo $Complaints_Info['Complaints_Date'] ?></h4>
										<div class="complaints_Details">
											<?php echo $Complaints_Info['Complaints_Message'] ?>
										</div>
										<div class="complaints_Status">
											<?php 
												if($Complaints_Info['Complaints_Status'] == '1') {
													echo '<div class="Complaints_no_answer">لم يتم الرد</div>';
													echo '<a href="Complaints_Admin.php?Complaints=Complaints_Answer&User='. $User_Name .'" class="btn btn-success">الرد الان</a>';
												} else {
													echo '<div class="Complaints_answer">تم الرد</div>';
												}
											?>
										</div>
									</div>
								</div>
							</div>
							<a href="Complaints_Admin.php" class="btn btn-success btn-block Complaints_Admin_Back">العودة</a>
						</div>
					</div>

<?php
				} else {

					echo '<div class="Page-First text-center">الرجاء التأكد من رقم الشكوى</div>';

				}

			} else {

				echo '<div class="Page-First text-center">الرجاء التأكد من رقم الشكوى</div>';

			}


		} elseif ($Complaints == 'Complaints_Answer') {

			$User_Name = isset($_GET['User']) ? strval($_GET['User']) : 0;
			$User_Sender_Complaints = $con-> prepare("SELECT * FROM users WHERE User_Name = ?");
			$User_Sender_Complaints-> execute(array($User_Name));
			$Check_Count = $User_Sender_Complaints-> rowCount();
			if($Check_Count > 0) {

				echo '<div class="Page-First text-center">الرد على, '. $User_Name .'</div>'; 

				if(isset($_POST['Complaints_Answer_box'])) {

					$Complaints = $_POST['Complaints_Answer_box'];
					$Update_Complaints_Stmt = $con-> prepare("UPDATE complaints SET Complaints_Status = ?, Complaints_Answer = ? WHERE Complaints_Sender = ?");
					$Complaints_Status = 2;
					$Update_Complaints_Stmt-> execute(array($Complaints_Status, $Complaints, $User_Name));
					if($Complaints) {

						echo '<div class="container alert alert-success">تم الرد</div>';

					}

				}

				?>

				<div class="container">
					<div class="Complaints_Answer_textarea">
						<form class="form-group" id="Complaints_Answer" action="Complaints_Admin.php?Complaints=Complaints_Answer&User=<?php echo $User_Name ?>" method="POST">
							<label>الرد</label>
							<textarea class="form-control" name="Complaints_Answer_box" id="Complaints_Answer_box"></textarea>
							<div class="alert alert-danger Complaints_Answer_box_error">
								<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> يجب ان يكون الرد أبر من 20 حرف
							</div>
							<input type="submit" name="Send_Answer" id="Send_Answer" value="أرسل الرد" class="btn btn-success">
						</form>
					</div>
					<a href="Complaints_Admin.php" class="btn btn-success btn-block Complaints_Admin_Back">العودة</a>
				</div>

<?php

			} else {

				echo '<div class="Page-First text-center">لا يوجد مستخدم بهذا الأسم</div>';

			}


		} else {

			echo "<div class='Page-First text-center'>لا يوجد صفحة بهذا الأسم</div>";

		}

	} else {

		header('Location: Login_Out.php');
		exit();

	}

	include $TempDir . 'footer.php';

ob_end_flush();

?>
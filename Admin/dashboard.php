<?php 

    ob_start();

	session_start();

	if(isset($_SESSION['User_Admin']) && $_SESSION['User_Admin'] == 1) {

		include 'init.php'; ?>

		<div class="container">
			<div class="Page-First text-center">لوحة التحكم</div>
			<div class="dashboard_boxs">
				<div class="row">
					<div class="col-lg-6">
						<div class="dashboard_box">
							<a href="News_Admin.php"> <p>الأخبار</p> </a>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="dashboard_box">
							<a href="Room_Chats_Admin.php"> <p>غرف المحادثات</p> </a>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="dashboard_box">
							<a href="Complaints_Admin.php"> <p>الشكاوى</p> </a>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="dashboard_box">
							<a href="NickName_Admin.php"> <p>الأسماء المستعارة</p> </a>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="dashboard_box">
							<a href="membership_Admin.php"> <p>اصحاب العضويات</p> </a>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="dashboard_box">
							<a href="Report_Abuse_Admin.php"> <p>بلاغات عن أساءة</p> </a>
						</div>
					</div>
				</div>
			</div>
			<hr>
		</div>

<?php
		include $TempDir . 'footer.php';

	} else {

		header('Location: Login_Out.php');
		exit();

	}

ob_end_flush();

?>
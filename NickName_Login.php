<?php 

    ob_start();

	session_start();

	if(isset($_SESSION['user_membership'])) {

		header('Location: index.php');
		exit();

	} else {

		include 'init.php';

			date_default_timezone_set('Asia/Riyadh');
			$date = date('F j, Y');
			$time = date('h:i');
    		$Time_Now = $date . ' الساعة: ' . $time;

			if(isset($_POST['NickName_submit'])) {

				$NickName = filter_var($_POST['NickName'], FILTER_SANITIZE_STRING);
				$Add_NickName_Stmt = $con-> prepare("INSERT INTO users(User_Type, User_Name, User_Password, User_Country, User_FullName, User_Sex, User_Birthday, User_Favorite, User_Group, Login_Date) VALUES(:UType, :UName, :UPass, :UCountry, :UFName, :USex, :UBirthday, :UFav, :UGroup, :LoginDate)");
				$Add_NickName_Stmt-> execute(array(

					'UType' => '1',
					'UName' => $NickName,
					'UPass' => 'No',
					'UCountry' => 'No',
					'UFName' => 'No',
					'USex' => '0',
					'UBirthday' => 'No',
					'UFav' => 'No',
					'UGroup' => '0',
					'LoginDate' => $Time_Now

				));

				$session_set = $con-> prepare("SELECT * FROM users WHERE User_Name = ?");
				$session_set-> execute(array($NickName));
				$NickName_Info = $session_set-> fetch();


				$_SESSION['user_membership'] = $NickName_Info['User_Name'];
				$_SESSION['User_ID'] = $NickName_Info['ID'];

				header('Location: index.php');
				exit();

			}


		?>

		<div class="page">
			<h3 class="Page-First text-center">تسجيل الدخول بأسم مستعار مؤقت</h3>
			<div class="container">
				<div class="row">
					<div class="col-lg-2"></div>
					<div class="col-lg-8">
						<div class="NickName_box">
							<div class="form_box">
								<form class="form-group" id="NickName_Form" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
									<input type="text" name="NickName" id="NickName" class="form-control" placeholder="الأسم المستعار المؤقت" autocomplete="off">
									<div class="alert alert-danger NickName_error">
										الاسم المستعار يجب ان يكون أكبر من <strong>5</strong> حروف
									</div>
									<input type="submit" name="NickName_submit" id="NickName_submit" value="الدخول بالأسم المستعار" class="btn btn-success">
								</form>
							</div>
						</div>
					</div>
					<div class="col-lg-2"></div>
				</div>
			</div>
		</div>

<?php

		include $TempDir . 'footer.php';

	}

ob_end_flush();

	?>
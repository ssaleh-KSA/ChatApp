<?php 
    
    ob_start();

	session_start();

	if(isset($_SESSION['user_membership'])) {

		header('Location: index.php');
		exit();

	} else {

		include 'init.php'; 

			if(isset($_POST['memebership_submit'])) {

				date_default_timezone_set('Asia/Riyadh');
    			$date = date('F j, Y');
    			$time = date('h:i');
    			$Time_Now = $date . ' الساعة: ' . $time;

				$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
				$pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
				$password = sha1($pass);
				$Nationality = filter_var($_POST['Nationality'], FILTER_SANITIZE_STRING);
				$Full_Name = filter_var($_POST['Full_Name'], FILTER_SANITIZE_STRING);
				$sex = $_POST['sex'];
				$birth_Day = 'ولد في, ' . $_POST['Day_of_birth'] . ' ' . $_POST['Month_of_birth'] . ' عام ' . $_POST['Year_of_birth'];

				$Add_NickName_Stmt = $con-> prepare("INSERT INTO users(User_Type, User_Name, User_Password, User_Country, User_FullName, User_Sex, User_Birthday, User_Favorite, User_Group, Login_Date) VALUES(:UType, :UName, :UPass, :UCountry, :UFName, :USex, :UBirthday, :UFav, :UGroup, :LoginDate)");
				$Add_NickName_Stmt-> execute(array(

					'UType' => '0',
					'UName' => $username,
					'UPass' => $password,
					'UCountry' => $Nationality,
					'UFName' => $Full_Name,
					'USex' => $sex,
					'UBirthday' => $birth_Day,
					'UFav' => 'No',
					'UGroup' => '2',
					'LoginDate' => $Time_Now

				));

			$singUp_msg = "<div class='alert alert-success container text-center'>تم تسجيلك بنجاح مرحباً بك... <a class='btn btn-primary' href='membership_Login.php'> سجل دخولك </a></div>";

			}


		?>

		<div class="page">
			<h3 class="Page-First text-center">تسجيل جديد بعضوية</h3>
				<?php 

					if(isset($_POST['memebership_submit'])) {

						echo $singUp_msg;

					} else {

						echo '<div class="alert alert-warning container text-center"><p>أذا كان لديك حساب, <a class="btn btn-primary" href="membership_Login.php">سجل دخولك </a></p></div>';

					}

				?>
			<div class="container">
				<div class="row">
					<div class="col-lg-2"></div>
					<div class="col-lg-8">
						<div class="NickName_box">
							<div class="form_box">
								<form class="form-group" id="memebership_form" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
									<input type="text" name="username" id="username" class="form-control" placeholder="أسم المستخدم" autocomplete="off">
										<div class="alert alert-danger membership_error username">
											<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> أسم المستخدم يجب ان يكون أكبر من <strong>5</strong> حروف
										</div>
									<input type="password" name="password" id="password" class="form-control" placeholder="الرقم السري" autocomplete="off">
										<div class="alert alert-danger membership_error password">
											<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> الرقم السري يجب ان يكون أكبر من <strong>8</strong> حروف و أرقام
										</div>
									<input type="text" name="Nationality" id="Nationality" class="form-control" placeholder="الجنسية" autocomplete="off">
										<div class="alert alert-danger membership_error Nationality">
											<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> الجنسية مطلوبة
										</div>
									<input type="text" name="Full_Name" id="Full_Name" class="form-control" placeholder="الأسم" autocomplete="off">
										<div class="alert alert-danger membership_error Full_Name">
											<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> الأسم مطلوب
										</div>
									<select class="form-control" name="sex" id="sex">
										<option value="0">--الجنس--</option>
										<option value="1">ذكر</option>
										<option value="2">أنثى</option>
									</select>
										<div class="alert alert-danger membership_error sex">
											<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> الجنس مطلوب
										</div>
									<select class="form-control" name="Day_of_birth" id="Day_of_birth">
										<option value="0">--يوم الميلاد--</option>
											<?php 

												$Year_Start = 1;
												$Year_End = 31;
												for($i=$Year_Start; $i <= $Year_End;$i++) {

													echo '<option value="'. $i .'">'. $i .'</option>';

												}

											?>
									</select>
										<div class="alert alert-danger membership_error Day_of_birth">
											<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> يوم الميلاد مطلوب
										</div>
									<select class="form-control" name="Month_of_birth" id="Month_of_birth">
										<option value="0">--شهر الميلاد--</option>
										<option value="يناير<">يناير</option>
										<option value="فبراير">فبراير</option>
										<option value="مارس">مارس</option>
										<option value="أبريل">أبريل</option>
										<option value="مايو">مايو</option>
										<option value="يونيو">يونيو</option>
										<option value="يوليو">يوليو</option>
										<option value="أغسطس">أغسطس</option>
										<option value="سبتمبر">سبتمبر</option>
										<option value="أكتوبر">أكتوبر</option>
										<option value="نوفمبر">نوفمبر</option>
										<option value="ديسمبر">ديسمبر</option>
									</select>
										<div class="alert alert-danger membership_error Month_of_birth">
											<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> شهر الميلاد مطلوب
										</div>
									<select class="form-control" name="Year_of_birth" id="Year_of_birth">
										<option value="0">--سنة الميلاد--</option>
											<?php 

												$Year_Start = 1900;
												$Year_End = 2000;
												for($i=$Year_Start; $i <= $Year_End;$i++) {

													echo '<option value="'. $i .'">'. $i .'</option>';

												}

											?>
									</select>
										<div class="alert alert-danger membership_error Year_of_birth">
											<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> سنة الميلاد مطلوبة
										</div>
									<input type="submit" name="memebership_submit" id="memebership_submit" value="تسجيل العضوية" class="btn btn-success">
									<div class="alert alert-danger memebership_submit">
										<i class="fa fa-exclamation-circle" aria-hidden="true"></i> يجب أكمال كافة الحقول
									</div>
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
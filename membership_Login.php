<?php 

    ob_start();

	session_start();

	if(isset($_SESSION['user_membership'])) {

		header('Location: index.php');
		exit();

	} else {

		include 'init.php'; 

		if(isset($_POST['membership_Login'])) {

						$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
						$pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
						$password = sha1($pass);

						$Add_username_Stmt = $con-> prepare("SELECT * FROM users WHERE User_Name = ? AND User_Password = ?");
						$Add_username_Stmt-> execute(array($username, $password));
						$Count = $Add_username_Stmt-> rowCount();

						if($Count > 0) {

							$info = $Add_username_Stmt-> fetch();

							$_SESSION['user_membership'] = $info['User_Name'];
							$_SESSION['User_Admin'] = $info['User_Group'];
							$_SESSION['User_ID'] = $info['ID'];
							header('Location: index.php');
							exit();

						} else {

							$error_msg = "<div class='alert alert-danger'> الرقم السري او اسم المستخدم غير صحيح </div>";

						}

					}


		?>

		<div class="page">
			<h3 class="Page-First text-center">تسجيل الدخول</h3>
			<div class="container">
				<div class="alert alert-warning text-center">
					<p>اذا لم يكن لديك حساب, 
							<a class="btn btn-primary" href="membership_SingUp.php">
								سجل حسابك الجديد الان 
							</a>
								أو سجل بأسم مستعار من 
							<a href="NickName_Login.php" class="btn btn-primary"> 
							هنا 
							</a>
					</p>
				</div>
				<div class="row">
					<div class="col-lg-2"></div>
					<div class="col-lg-8">
						<div class="NickName_box">
							<div class="form_box">
								<form class="form-group" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
									<?php 

										if(isset($error_msg)) {

											echo $error_msg; 

										}

									?>
									<input type="text" name="username" class="form-control" placeholder="أسم المستخدم..." autocomplete="off">
									<input type="password" name="password" class="form-control" placeholder="الرقم السري..." autocomplete="off">
									<input type="submit" name="membership_Login" value="الدخول" class="btn btn-success">
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
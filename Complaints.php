<?php

    ob_start();

    include 'init.php'; 

	if(!isset($_SESSION)) {

    	session_start();

    }

    date_default_timezone_set('Asia/Riyadh');
    $date = date('F j, Y');

    if(isset($_SESSION['user_membership'])) {

		if(isset($_POST['Complaints_text'])) {

			$Complaints_Message = filter_var($_POST['Complaints_text'], FILTER_SANITIZE_STRING);
			$Add_New_Complaints = $con-> prepare("INSERT INTO Complaints(Complaints_Sender, Complaints_Date, Complaints_Message, Complaints_Status) 
												VALUES(:CSender, :CDate, :CMessage, :CStatus)");
			$Add_New_Complaints-> execute(array(

				'CSender' => $_SESSION['user_membership'],
				'CDate' => $date,
				'CMessage' => $Complaints_Message,
				'CStatus' => '1'

			));

		}

		if(isset($Add_New_Complaints)) {

			$Complaints_Message = '<div class="alert alert-success">تم إرسالة الشكوى الى الإدارة, وسيتم الرد عليك في أقرب فرصة... مع تحيات إدارة الموقع</div>';

		}


  ?>

    	<div class="container">
			<?php include $TempDir . 'ads_and_secBtn.php'; ?>
			<div class="Complaints">
				<?php if(isset($Complaints_Message)) {echo $Complaints_Message;} ?>
				<h1 class="text-center">تقدم بشكوى</h1>
				<form class="form-group" id="Complaints_Form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
					<label class="alert alert-danger">أكتب الشكوى في الحقل الأسفل*</label>
					<textarea class="form-control" name="Complaints_text" id="Complaints_text"></textarea>
						<div class="alert alert-danger Complaints_error ">
							<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> يجب أدخال رسالة, ويجب أن تكون أطول من 60 حرف.
						</div>
					<input type="submit" name="Complaints_submit" id="Complaints_submit" class="btn btn-success btn-block">
				</form>
			</div>
		</div>

<?php

    } else {

    	header('Location: membership_Login.php');
    	exit();

    }

?>
<?php

    include $TempDir . 'footer.php'; 
    
    ob_end_flush();
    
?>
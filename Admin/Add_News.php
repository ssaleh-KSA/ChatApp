<?php 

    ob_start();
    
	session_start();

	if(isset($_SESSION['User_Admin']) && $_SESSION['User_Admin'] == 1) {

		include 'init.php'; 

			if(isset($_POST['Add_News'])) {

				$News_Title = filter_var($_POST['News_Title'], FILTER_SANITIZE_STRING);
				$News_Image_tmp = $_FILES['News_Image']['tmp_name'];
				$News_Image_name = $_FILES['News_Image']['name'];
				$News_Image_size = $_FILES['News_Image']['size'];
				$News_Details = filter_var($_POST['News_Details'], FILTER_SANITIZE_STRING);

				// Image Extension Allowed List
				$ImageAllowedExtension = array('jpg', 'jpeg', 'png', 'bmp', 'tiff', 'gif');
				// Conversion From UpperCase To LowerCase
				$ImageToLo = strtolower($News_Image_name);
				// Conversion Image Name To Array With explode
				$ImageExplode = explode('.', $ImageToLo);
				// Get The End From The Image Name Array
				$ImageExplodeEnd = end($ImageExplode);

				if (!in_array($ImageExplodeEnd, $ImageAllowedExtension)) {
					$Image_Explode_error = '<div class="alert alert-danger"> أمتداد الصورة غير مسموح به أبحث عن صورة يكون أمتدادها " jpg - jpeg - png - bmp - tiff - gif " </div>';
				}
				if ($News_Image_size > 4194304) {
					$Image_size_error = '<div class="alert alert-danger"> حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB </div>';
				}

				date_default_timezone_set('Asia/Riyadh');
				$date = date('F j, Y');
				$time_Now = date('h:i');

				// Add Random Number To Image Name
				$Image = rand(0, 100000) . '_' . $News_Image_name;
				// Chang Path $_FILES['News_Image']['tmp_name']; To My Path, "../Uploads/Images/" Folders I Created In admin Folder
			 	move_uploaded_file($News_Image_tmp, '../Uploads/Images/' . $Image);

			 	$Add_New_News_Stmt = $con-> prepare("INSERT INTO news(News_Title, News_Image, News_Write, News_Date, News_Time, News_Views, News_Details)
			 										VALUES(:Tilte, :Image, :Write, :NDate, :NTime, :Views, :Details)");
			 	$Add_New_News_Stmt-> execute(array(

			 		'Tilte' => $News_Title,
			 		'Image' => $Image,
			 		'Write' => $_SESSION['user_membership'],
			 		'NDate' => $date,
			 		'NTime' => $time_Now,
			 		'Views' => '0',
			 		'Details' => $News_Details

			 	));

			 	header('Location: News_Admin.php');
			 	exit();

			}

		?>

		<div class="container">
			<div class="Add_News_Page">
				<div class="Page-First text-center">أضف خبر جديد</div>
				<div class="Add_News_Boxs">
					<div class="row">
						<div class="col-lg-2"></div>
							<div class="col-lg-8">
								<form class="form-group" id="News_Form" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
									<label>عنوان الخبر *</label>
										<input class="form-control" type="text" name="News_Title" id="News_Title" placeholder="عنوان الخبر..." autocomplete="off" value="<?php if(isset($News_Title)) {echo $News_Title;} ?>">
											<div class="alert alert-danger News_Title">
												<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> يجب أن يكون عنوان الخبر اكبر من <strong> 10 </strong> حروف
											</div>
									<label>صورة الخبر *</label>
										<input class="form-control" type="file" name="News_Image" id="News_Image">
											<div class="alert alert-danger News_Image">
												<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> يجب أن تختار صورة للخبر
											</div>
											<?php if(isset($Image_Explode_error)) {echo $Image_Explode_error;} ?>
											<?php if(isset($Image_size_error)) {echo $Image_size_error;} ?>
									<label>تفاصيل الخبر *</label>
										<textarea class="form-control" placeholder="تفاصيل الخبر..." id="News_Details" name="News_Details"><?php if(isset($News_Details)) {echo $News_Details;} ?></textarea>
											<div class="alert alert-danger News_Details">
												<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> يجب أن يكون تفصيل الخبر أكبر من <strong> 300 </strong> حرف
											</div>
									<input type="submit" name="Add_News" id="Add_News" class="btn btn-success Add_News" value="أضف الخبر">
										<div class="alert alert-danger News_Form">
											<i class="fa fa-exclamation-circle" aria-hidden="true"></i> يجب أكمال كافة الحقول
										</div>
								</form>
							</div>
						<div class="col-lg-2"></div>
					</div>
				</div>
			</div>
		</div>
		
<?php

		include $TempDir . 'footer.php';

	} else {

		header('Location: ../LoginOut.php');
		exit();

	}

    ob_end_flush();

?>
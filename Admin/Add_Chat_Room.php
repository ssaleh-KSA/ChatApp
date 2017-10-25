<?php 

    ob_start();

	session_start();

	if(isset($_SESSION['User_Admin']) && $_SESSION['User_Admin'] == 1) {

		include 'init.php'; 

			if(isset($_POST['Add_Room'])) {

				$Room_Name = filter_var($_POST['Room_Name'], FILTER_SANITIZE_STRING);
				$Room_Image_tmp = $_FILES['Room_Image']['tmp_name'];
				$Room_Image_name = $_FILES['Room_Image']['name'];
				$Room_Image_size = $_FILES['Room_Image']['size'];
				$Room_Description = filter_var($_POST['Room_Description'], FILTER_SANITIZE_STRING);

				// Image Extension Allowed List
				$ImageAllowedExtension = array('jpg', 'jpeg', 'png', 'bmp', 'tiff', 'gif');
				// Conversion From UpperCase To LowerCase
				$ImageToLo = strtolower($Room_Image_name);
				// Conversion Image Name To Array With explode
				$ImageExplode = explode('.', $ImageToLo);
				// Get The End From The Image Name Array
				$ImageExplodeEnd = end($ImageExplode);

				if (!in_array($ImageExplodeEnd, $ImageAllowedExtension)) {
					$Image_Explode_error = '<div class="alert alert-danger"> أمتداد الصورة غير مسموح به أبحث عن صورة يكون أمتدادها " jpg - jpeg - png - bmp - tiff - gif " </div>';
				}
				if ($Room_Image_size > 4194304) {
					$Image_size_error = '<div class="alert alert-danger"> حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB </div>';
				}

				// Add Random Number To Image Name
				$Image = rand(0, 100000) . '_' . $Room_Image_name;
				// Chang Path $_FILES['Room_Image']['tmp_name']; To My Path, "../Uploads/Images/Room_Chats_Images/" Folders I Created In admin Folder
			 	move_uploaded_file($Room_Image_tmp, '../Uploads/Images/Room_Chats_Images/' . $Image);

			 	$Add_New_Room_Stmt = $con-> prepare("INSERT INTO chat_rooms(Room_Name, Room_Description, Members_In_Room, Room_Image)
			 										VALUES(:RName, :RDescription, :RMembers, :RImage)");
			 	$Add_New_Room_Stmt-> execute(array(

			 		'RName' => $Room_Name,
			 		'RDescription' => $Room_Description,
			 		'RMembers' => '0',
			 		'RImage' => $Image

			 	));

			 	header('Location: Room_Chats_Admin.php');
			 	exit();

			}

		?>

		<div class="container">
			<div class="Add_Room_Page">
				<div class="Page-First text-center">أضف غرفة جديدة</div>
				<div class="Add_Room_Boxs">
					<div class="row">
						<div class="col-lg-2"></div>
							<div class="col-lg-8">
								<form class="form-group" id="Add_Room_Form" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
									<label> أسم الغرفة *</label>
										<input class="form-control" type="text" name="Room_Name" id="Room_Name" placeholder="أسم الغرفة..." autocomplete="off" value="<?php if(isset($Room_Name)) {echo $Room_Name;} ?>">
											<div class="alert alert-danger Room_Name">
												<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> يجب أن يكون أسم الغرفة اكبر من <strong> 5 </strong> حروف
											</div>
									<label>وصف الغرفة *</label>
										<textarea class="form-control" type="text" name="Room_Description" id="Room_Description" placeholder="وصف الغرفة..." value="<?php if(isset($Room_Description)) {echo $Room_Description;} ?>"><?php if(isset($Room_Name)) {echo $Room_Name;} ?></textarea>
											<div class="alert alert-danger Room_Description">
												<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> يجب أن يكون الوصف أكبر من <strong> 60 </strong> حرف
											</div>
											
									<label>صورة الغرفة *</label>
										<input class="form-control" type="file" id="Room_Image" name="Room_Image">
											<?php if(isset($Image_Explode_error)) {echo $Image_Explode_error;} ?>
											<?php if(isset($Image_size_error)) {echo $Image_size_error;} ?>
									<input type="submit" name="Add_Room" id="Add_Room" class="btn btn-success Add_Room" value="أضف الغرفة">
										<div class="alert alert-danger Add_Room_Form">
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
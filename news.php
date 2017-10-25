<?php

ob_start();

if(!isset($_SESSION['user_membership'])) {

	session_start();

}

include 'init.php'; 

?>

<?php

	$News_ID = '';

	if(isset($_GET['News_ID'])) {

		$News_ID = $_GET['News_ID'];

	} else {

		$News_ID = 'News-Page';

	}

	//###############################################################################

	if($News_ID == 'News-Page') { ?>

		<div class="container">
			<?php include $TempDir . 'ads_and_secBtn.php'; ?>
			<h3 class="text-center">الأخبار</h3>
			<div class="row">
				<div class="Most_active_rooms">
					<div class="row">
						<?php 

							$Get_All_News = $con-> prepare("SELECT * FROM news ORDER BY News_ID DESC");
							$Get_All_News-> execute();
							$Count = $Get_All_News-> rowCount();
							if($Count > 0) {

								$News_Art = $Get_All_News-> fetchAll();
								foreach($News_Art as $news) {

									echo '<div class="col-lg-6">';
										echo '<div class="The_room">';
											echo '<img src="Uploads/Images/'. $news['News_Image'] .'" alt="'. $news['News_Title'] .'" class="img-responsive img-thumbnail">';
											echo '<h3>'. $news['News_Title'] .'</h3>';
											echo '<hr>';
											// echo '<p>'. $news['News_Details'] .'</p>';
											echo '<button class="btn btn-danger"><a href="news.php?News_ID='. $news['News_ID'] .'"> للمزيد </a></button>';
										echo '</div>';
									echo '</div>';

								}

							} else {

								echo '<div class="The_room">';
									echo '<p>لا يوجد أخبار</p>';
								echo '</div>';

							}

						?>
					</div>
				</div>
			</div>
		</div>

<?php
	} elseif($News_ID = 'News_ID') { ?>

		<div class="container">
			<?php include $TempDir . 'ads_and_secBtn.php'; ?>
			<div class="news_Art">
				<?php 

						$News_ID = isset($_GET['News_ID']) & is_numeric($_GET['News_ID']) ? intval($_GET['News_ID']) : 0;

							$Get_All_News = $con-> prepare("SELECT * FROM news WHERE News_ID = ?");
							$Get_All_News-> execute(array($News_ID));
							$Count = $Get_All_News-> rowCount();
							if($Count > 0) {

								$News_Art = $Get_All_News-> fetch();
								
								echo '<h1 class="text-center">'. $News_Art['News_Title'] .'</h1>';
								echo '<div class="news_image_box">';
									echo '<img src="Uploads/Images/'. $News_Art['News_Image'] .'" alt="'. $News_Art['News_Title'] .'" class="img-responsive img-thumbnail">';
								echo '</div>';
								echo '<div class="news_Date">';
									echo '<span><strong><i class="fa fa-user" aria-hidden="true"></i> كتب بواسطة: </strong> <a href="#">'. $News_Art['News_Write'] .'</a> </span>';
									echo '<span><strong><i class="fa fa-calendar" aria-hidden="true"></i> تاريخ النشر: </strong>'. $News_Art['News_Date'] .'</span>';
									echo '<span><strong><i class="fa fa-eye" aria-hidden="true"></i> المشاهدات: </strong>'. $News_Art['News_Views'] .' مشاهدة </span>';
								echo '</div>';
								echo '<hr>';
								echo '<div class="News_Details">';
									echo '<p>'. $News_Art['News_Details'] .'</p>';
								echo '</div>';
								echo '<hr>';

							} else {

								echo '<div class="The_room">';
									echo '<p>لا يوجد أخبار</p>';
								echo '</div>';

							}

						?>
				<div class="Share_box">
					<a href="#" title="twitter">
						<i class="fa fa-twitter" aria-hidden="true" style="background-color: #429cd6"></i>
					</a>
					<a href="#" title="facebook">
						<i class="fa fa-facebook" aria-hidden="true" style="background-color: #3a589e;padding: 10px 13px 10px 13px;"></i>
					</a>
					<a href="#" title="whatsapp">
						<i class="fa fa-whatsapp" aria-hidden="true" style="background-color: #25d366"></i>
					</a>
					<a href="#" title="linkedin">
						<i class="fa fa-linkedin" aria-hidden="true" style="background-color: #0d77b7"></i>
					</a>
					<a href="#" title="google">
						<i class="fa fa-google" aria-hidden="true" style="background-color: #df4b37"></i>
					</a>
				</div>
			</div>
			<div class="news_Add_Comment">
				<h3 class="Com_Title text-center">أضافة تعليق</h3>
				<hr>
				<div class="form_input">
					<?php 

						if(isset($_POST['Comment_textarea'])) {

							if(!isset($_SESSION['user_membership'])) {

								header('Location: membership_Login.php');
								exit();

							} else {

								date_default_timezone_set('Asia/Riyadh');
								$date = date('F j, Y');
								$time = date('h:i');
								$Comment = $_POST['Comment_textarea'];
								$Sender = $_SESSION['User_ID'];
								$DateNow = 'بتاريخ: ' . $date . ' الساعة: ' . $time;
								$Add_New_Comment = $con-> prepare("INSERT INTO comments(Com_Comment, Com_Sender, Com_Date, Con_In) 
																	VALUES(:Comment, :Sender, :DateNow, :News_ID)");
								$Add_New_Comment-> execute(array(

									'Comment' => $Comment,
									'Sender' => $Sender,
									'DateNow' => $DateNow,
									'News_ID' => $News_ID

								));

									if($Add_New_Comment) {

										$Com_ID = $Comments['Com_ID'];
										header('Location: news.php?News_ID=' . $News_ID . '#news_Comments');
										exit();

									}

							}

						}

					?>
					<form class="form-group" id="Add_Comment_Form" action="news.php?News_ID=<?php echo $News_Art['News_ID']; ?>" method="POST">
						<label>التعليق</label>
						<textarea type="text" name="Comment_textarea" id="Comment_textarea" class="form-control"></textarea>
						<div class="alert alert-danger Add_Comment_error">
							<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> يجب أن تكتب شيأً في الحقل لأرسال التعليق.
						</div>
						<input type="submit" name="Add_Comment" value="أضف تعليق" class="btn btn-success btn-block">
					</form>
				</div>
			</div>
						<?php 

				$Get_All_Comments = $con-> prepare("SELECT comments.*, users.User_Name AS UserName FROM comments JOIN users ON users.ID = comments.Com_Sender WHERE Con_In = ? ORDER BY Com_ID DESC;");
				$Get_All_Comments-> execute(array($News_ID));
				$Comments_Count = $Get_All_Comments-> rowCount();
				$Comment_Info = $Get_All_Comments-> fetchAll();


			?>
			<div class="news_Comments" id="news_Comments">
				<h3 class="Com_Title text-center">التعليقات: <?php echo $Comments_Count; ?></h3>
				<hr>
				<?php 

					foreach($Comment_Info as $Comments) {

							echo '<div class="users_messages">';
								echo '<div class="col-lg-2">';
									echo '<b>' . $Comments["UserName"] .':</b><br>';
								echo '</div>';
								echo '<div class="col-lg-8">';
									echo '<span>' . $Comments["Com_Comment"] .'</span>';
									echo '<br>';
								echo '</div>';
								echo '<div class="col-lg-2">';
									echo '<small class="msg_time pull-left">' . $Comments["Com_Date"] . '</small>';
								echo '</div>';
							echo '</div>';

					}

				?>
			</div>
		</div>

<?php
	} else {

		echo '<div class="Page-First alert alert-danger">لا يوجد صفحة بهذا الأسم</div>';

	}

ob_end_flush();
?>

<?php include $TempDir . 'footer.php'; ?>
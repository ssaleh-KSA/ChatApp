<?php 

	ob_start();

	session_start();

	if(isset($_SESSION['User_Admin']) && $_SESSION['User_Admin'] == 1) {

		include 'init.php'; 

		date_default_timezone_set('Asia/Riyadh');
		$time_Now = date('h:i');

		?>

		<div class="container">
			<div class="Page-First text-center">التحكم - الأخبار</div>
			<div class="text-center">
				<a href="Add_News.php"> <button class="btn btn-success btn-block">أضف خبر</button> </a>
			</div>
			<hr>
			<table class="table table-striped text-center">
			   <tr>
			   		<td>رقم الخبر</td>
			   		<td>عنوان الخبر</td>
			   		<td>كاتب الخبر</td>
			   		<td>تاريخ الخبر</td>
			   		<td>الساعة</td>
			   		<td>التفاصيل</td>
			   		<td>التحكم</td>
			   </tr>
					<?php 

						$Get_All_News = $con-> prepare("SELECT * FROM news ORDER BY News_ID DESC");
						$Get_All_News-> execute();
						$Count = $Get_All_News-> rowCount();
						if($Count > 0) {

							$News_Art = $Get_All_News-> fetchAll();
							foreach($News_Art as $news) {
								if($news['News_Time'] == $time_Now) {

									echo '<tr class="news_News_Now" id="N_ID_'. $news['News_ID'] .'">';
											echo '<td>'. $news['News_ID'] .'</td>';
											echo '<td>'. $news['News_Title'] .'</td>';
											echo '<td>'. $news['News_Write'] .'</td>';
											echo '<td>'. $news['News_Date'] .'</td>';
											echo '<td>'. $news['News_Time'] .'</td>';
											echo '<td><a href="../news.php?News_ID='. $news['News_ID'] .'">التفاصيل</td>';
											echo '<td> <a class="btn btn-danger News_Delete News_ID_'. $news['News_ID'] .'" id="'.$news['News_ID'] .'"> حذف </a></td>';
									echo '</tr>';

								} else {

									echo '<tr id="N_ID_'. $news['News_ID'] .'">';
											echo '<td>'. $news['News_ID'] .'</td>';
											echo '<td>'. $news['News_Title'] .'</td>';
											echo '<td>'. $news['News_Write'] .'</td>';
											echo '<td>'. $news['News_Date'] .'</td>';
											echo '<td>'. $news['News_Time'] .'</td>';
											echo '<td><a href="../news.php?News_ID='. $news['News_ID'] .'">التفاصيل</td>';
											echo '<td> <a class="btn btn-danger News_Delete News_ID_'. $news['News_ID'] .'" id="'.$news['News_ID'] .'"> حذف </a></td>';
									echo '</tr>';

								}

							}

						} else {

							echo '<div class="alert alert-warning text-center"> لا يوجد أخبار </div>';

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
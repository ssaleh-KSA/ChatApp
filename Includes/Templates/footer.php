<?php 

	include 'connect.php'; 

	$Get_All_Rooms = $con-> prepare("SELECT * FROM chat_rooms ORDER BY Room_ID DESC");
	$Get_All_Rooms-> execute();
	$Info = $Get_All_Rooms-> fetchAll();


?>
<footer>
	<div class="block-footer">
		<div class="container">
			<div class="col-lg-3">
				<h3 class="h3_footer">عن محادثات</h3>
				<div class="footer_info">
					محادثات هو موقع ترفيهي يقدم لكم العديد من الخدمات الترفيهية والأجتماعية والثقافية, منها خدمة الكتابية, وأيضاً يمكنك التنقل بين صفحات الموقع لقراءة الأخبار.
				</div>
			</div>
			<div class="col-lg-3">
				<h3 class="h3_footer">غرف محادثات</h3>
				<div class="col-lg-12">
					<div class="footer_info">
						<?php 

							foreach($Info as $Rooms) {

								echo '<h5> <a href="Caht.php">'. $Rooms['Room_Name'] .'</a> </h5>';

							}

						?>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<h3 class="h3_footer">القوانين والدعم الفني</h3>
				<div class="col-lg-6">
					<div class="footer_info">
							<a href="Terms.php"><h4>شروط الأستخدام </h4></a>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="footer_info">
							<a href="privacy.php"><h5>سياسة الخصوصية </h5></a>
							<a href="Complaints.php"><h4>شكاوى </h4></a>
					</div>
				</div>
			</div>
			<div class="col-lg-2">
				<h3 class="h3_footer"3>تواصل معنا</h3>
				<div class="footer_info">
					<a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
					<a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
					<a href="#"></a>
					<a href="#"></a>
				</div>
			</div>
		</div>
	</div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="<?php echo $JSDir; ?>jquery-1.12.4.min.js"></script>
<script src="<?php echo $JSDir; ?>jquery-ui.min.js"></script>
<script src="<?php echo $JSDir; ?>bootstrap.min.js"></script>
<script src="<?php echo $JSDir; ?>FrontEnd.js"></script>
<script src="<?php echo $JSDir; ?>jquery.nicescroll.min.js"></script> 
</body>
</html>
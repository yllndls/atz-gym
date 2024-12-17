            </div>
		</section >
		
		<!--Footer-->
		<footer class="page-footer">
			<section>
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-12 infomation">
							<div class="copy-right">
								<div class="footer-right">
									<div class="line1">Copyright &copy; 2024<a href="#"> Athlete Fitness</a></div>
									<div class="line2">Designed and development by ATZ Fitness Gym</div>
								</div>
							</div>
							<div class="social_icon">
								<a href="#"><i class="fa fa-facebook"></i></a>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12 location">							
							<div class="footer-title">
								<h4>Our location</h4>			
							</div>
							<div class="address">
								<p>Bldg 03&nbsp; Santa fe, Daan Bantayan, Cebu<br>Phone : +63 9826517483<br>Email : <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="51383f263027342539343c342211363c30383d7f323e3c">[email&#160;protected]</a></p>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12 send-mail">							
							<div class="footer-title">
								<h4>Keep in touch</h4>			
							</div>
							<form name="" method="post"  id="send-mail">												
								<div class="info">Facebook, Instagram, & Twitter</div>						
								<div class="email">
									<input type="text" title="E-mail" name="user[email]" class="inputbox" placeholder="Your email" >
									<button class="button" title="Submit" type="submit"><i class="fa fa-arrow-right"></i></button>
								</div>
							</form>
						</div>						
					</div>
				</div>
			</section>
		</footer>
		<!--End Footer-->
		<!--To Top-->
		<div id="copyright">
			<div class="container">

				<div class="back-to-top"><a title="BACK_TO_TOP" href="#top"><i class="fa fa-chevron-up"></i></a></div>

				<div class="clrDiv"></div>
			</div>
		</div>
		<!--End To Top-->
	</div>
	<script data-cfasync="false" src="public/assets/js/front/email-decode.min.js"></script>
    <script type="text/javascript" src="public/assets/js/front/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="public/assets/js/front/bootstrap.min.js"></script>
	<script type="text/javascript" src="public/assets/js/front/jquery.min.js"></script>
	<script type="text/javascript" src="public/assets/js/front/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="public/assets/js/front/jquery.parallax-1.1.3.js"></script>
    <script type="text/javascript" src="public/assets/js/front/jquery.transform2d.js"></script>
    <script type="text/javascript" src="public/assets/js/front/script.js"></script>
    <script type="text/javascript" src="public/assets/js/front/parallax.js"></script>
	<script type="text/javascript" src="public/assets/js/front/waypoints.js"></script>
	<script type="text/javascript" src="public/assets/js/front/template.js"></script>
	<script type="text/javascript" src="public/assets/js/front/masterslider.min.js"></script>
	<script type="text/javascript" src="public/assets/js/front/banner.js"></script>
	<script type="text/javascript" src="public/assets/js/front/owl.carousel.min.js"></script>
	<script type="text/javascript" src="public/assets/js/front/theme.js"></script>
	<script type="text/javascript" src="public/assets/js/front/dropdown.js"></script>
	<script type="text/javascript" src="public/assets/js/front/classie.js"></script>
	<script type="text/javascript" src="public/assets/js/front/main.js"></script>
	<script type="text/javascript" src="public/assets/js/front/jquery.custombox.js"></script>
	<script type="text/javascript" src="public/assets/js/front/jquery-ui.js"></script>
	<script type="text/javascript" src="public/assets/js/front/sweetalert2.all.min.js"></script>

	<script>
		function previewImage(event) {
			const file = event.target.files[0];
			const reader = new FileReader();

			if (file && file.type.match('image.*')) {
				reader.onload = function(e) {
					const preview = document.getElementById('imagePreview');
					const previewImg = document.getElementById('previewImg');
					
					previewImg.src = e.target.result;
					preview.style.display = 'block';
				};
				
				reader.readAsDataURL(file);
			} else {
				document.getElementById('imagePreview').style.display = 'none';
			}
		}
	</script>
</body>
</html>


<div class="modal fade" id="myModal" tabindex="-1" autocomplete="off" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Login to OpenLearn&nbsp;(For Instructors Only)</h4>
				</div>

				<div class="modal-body">
					<form id="login-form" method="POST" autocomplete="off">
						<div class="form-group">
								<b>Email address</b>
								<input type="email" name="instEmail" class="form-control" id="instEmail" placeholder="Enter email">
								<span class="help-block" id="error"></span>
							</div>

							<div class="form-group">
								<b>Password</b>
								<input type="password" name="instPassword" class="form-control" id="instPassword" placeholder="Password">
								<span class="help-block" id="error"></span>
							</div>

							<div class="form-check">
								<label class="form-check-label">
									<input type="checkbox" id="rememberMe"class="form-check-input">&nbsp;Remember me
								</label>
							</div>
							<div id="errorDiv"></div> 
				</div>

				<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" id="btn-login" class="btn btn-primary">Login</button>
				</form>
				</div>
			</div>
		</div>
	</div>
	<!--Modal for login ends-->

	<br><br>
	<div class="container">
			<div class="row animate-box">
				<div class="col-md-6 col-md-offset-3 text-center fh5co-heading">
					<h1>Our Courses</h1>
					<p>Choose what you want to pursue from the plethora of courses we offer—all for free!</p>
				</div>
			</div>

			<div class="table-responsive animate-box">  
                     <table id="messages-table" class="table table-hover table-bordered">  
                          <thead>  
                               <tr>  
							   		<td><b>Course Name</b></td>
							   		<td><b>Course Info</b></td>
							   		<td><b>Course Category</b></td>
									<td><b>Instructor</b></td>
									<td><b>View</b></td>
                               </tr>  
                          </thead>  

						 <tbody>

						  <?php  
						  
							$query_join = "SELECT courses.course_id, courses.course_name, courses.course_info, courses.course_category, instructor.name, instructor.id
							FROM courses
							INNER JOIN instructor ON courses.instructor_id=instructor.id;";
						  	$execute_course_query = mysqli_query($link, $query_join);
						  
							while ($course_row = mysqli_fetch_assoc($execute_course_query)) {
						  		echo "
								  <tr> 
									  <td>{$course_row['course_name']}</td>
									  <td>{$course_row['course_info']}</td>
									  <td>{$course_row['course_category']}</td>
									  <td><a href='profile.php?inst_id=".$course_row['id']."'>".$course_row['name']."</a></td>
									  <td><a target='_blank' href='view-course.php?course_id=".$course_row['course_id']."'><button class='btn btn-primary'><i class='fa fa-eye'></i>&nbsp;&nbsp; View</button></a></td>
								  </tr>
						
						  		";
							}

						  ?>
						   
						</tbody>
                     </table>  
                </div>  

	</div>
	

	<br><br><br><br><br><br>


	<footer id="fh5co-footer" role="contentinfo" style="background-image: url(images/mountain.jpg);">
		<div class="overlay"></div>
		<div class="container">
			<div class="row row-pb-md">
				<div class="col-md-3 fh5co-widget">
					<h3>About OpenLearn</h3>
					<p>OpenLearn is a global marketplace for learning and teaching online where students are mastering new skills and achieving their goals by learning from an extensive library of over 55,000 courses taught by expert instructors.</p>
				</div>
				<div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1 fh5co-widget">
					<h3>Learning</h3>
					<ul class="fh5co-footer-links">
						<li><a href="#">Course</a></li>
						<li><a href="#">Blog</a></li>
						<li><a href="#">Contact</a></li>
						<li><a href="#">Terms</a></li>
						<li><a href="#">Meetups</a></li>
					</ul>
				</div>

				<div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1 fh5co-widget">
					<h3>Learn &amp; Grow</h3>
					<ul class="fh5co-footer-links">
						<li><a href="#">Blog</a></li>
						<li><a href="#">Privacy</a></li>
						<li><a href="#">Testimonials</a></li>
						<li><a href="#">Handbook</a></li>
						<li><a href="#">Held Desk</a></li>
					</ul>
				</div>

				<div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1 fh5co-widget">
					<h3>Engage us</h3>
					<ul class="fh5co-footer-links">
						<li><a href="#">Marketing</a></li>
						<li><a href="#">Visual Assistant</a></li>
						<li><a href="#">System Analysis</a></li>
						<li><a href="#">Advertise</a></li>
					</ul>
				</div>

				<div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1 fh5co-widget">
					<h3>Legal</h3>
					<ul class="fh5co-footer-links">
						<li><a href="#">Find Designers</a></li>
						<li><a href="#">Find Developers</a></li>
						<li><a href="#">Teams</a></li>
						<li><a href="#">Advertise</a></li>
						<li><a href="#">API</a></li>
					</ul>
				</div>
			</div>

			<div class="row copyright">
				<div class="col-md-12 text-center">
					<p>
						<small class="block">&copy; 2017 OpenLearn, Inc.&nbsp;&nbsp;All Rights Reserved.</small>
						<small class="block">Designed by <a href="https://www.iproject.com.ng" target="_blank">eCuzzy</a>.</small>
					</p>
				</div>
			</div>

		</div>
	</footer>
	</div>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
	</div>

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
	<script src="assets/jquery.validate.min.js"></script>
	<script src="js/additional-methods.js"></script>
	<script src="js/extension.js"></script> <!--Message is validated and sent-->
	<script src="login.js"></script>

	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Stellar Parallax -->
	<script src="js/jquery.stellar.min.js"></script>
	<!-- Carousel -->
	<script src="js/owl.carousel.min.js"></script>
	<!-- Flexslider -->
	<script src="js/jquery.flexslider-min.js"></script>
	<!-- countTo -->
	<script src="js/jquery.countTo.js"></script>
	<!-- Magnific Popup -->
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/magnific-popup-options.js"></script>
	<!-- Count Down -->
	<script src="js/simplyCountdown.js"></script>
	<!-- Main -->
	<script src="js/main.js"></script>

	<!--DataTables plugin -->
	<script>  
 		$(document).ready(function(){  
      	$('#messages-table').DataTable();  
 		});  
	 </script>


<?php include('header.php'); ?>
	
<div class="about-us">
	<h3><strong>BOARD OF DIRECTORS</strong></h3>
	<div class="row">
	<?php for ($i=0;$i<4;$i++) { ?>
		<div class="col-md-6 col-sm-6 col-lg-3">
			<div class="member-details">
				<div class="porfile-pic">
					<img src="assets/img/content/team-member-5.jpg" alt="">
					<ul class="list-inline">
						<li><a href="#"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#"><i class="fa fa-twitter"></i></a></li>
						<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
						<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
					</ul>
				</div>
			<h3><a href="#">John Doe</a></h3>
			<p class="title">Co-Founder</p>
			<p class="title"><i class="fa fa-mobile"></i> +91-9998972498</p>
		</div>
	</div>
	<?php } ?>
</div>

<div class="row">
	<div class="col-md-12">
	&nbsp;
	</div>
</div>
<?php include('footer.php'); ?>
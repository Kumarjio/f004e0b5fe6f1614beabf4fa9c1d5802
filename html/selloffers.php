<?php include('header.php'); ?>

<div class="col-md-12">
	<div class="company-events">
  		<h2 class="text-uppercase mb30">Sell Offers</h2>
      	
      	<?php for ($i=0;$i<5;$i++) { ?>
	      	<div class="post-with-image">
	  			<div class="date-month">
	              	<a href="#">
	                    <span class="date">25</span>
	                	<span class="month">May</span>
	              	</a>
	            </div>

	            <div class="post-image">
	              <img src="assets/img/content/sell-p1.jpg" alt="">
	            </div>

	            <h3 class="title"><a href="blog-post.html">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</a></h3>

	            <p class="tag">
					<i class="fa fa-tag"></i>
					<a href="#">Rice</a>
				</p>

	            <p class="post">
	              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue,
	              suscipit a, scelerisque sed, lacinia in, mi..
	            </p>

				<p class="event-place">
	        		<a href="#"><i class="fa fa-user"></i> Rana Traders</a>
	              	<a href="#"><i class="fa fa-globe"></i> Hathikhana</a>
	              	<a href="#"><i class="fa fa-calendar"></i> 25 May, 2015</a>
	            </p>

	            <a class="post-read-more" href="selloffer_details.php"><i class="fa fa-angle-right"></i>Read More</a>
	      	</div>
      	<?php } ?>
    </div>
</div>

<?php include('ads-rotator.php'); ?>

<?php include('footer.php'); ?>
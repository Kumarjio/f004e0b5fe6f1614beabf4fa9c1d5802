<?php include('header.php'); ?>

<div class="col-md-12">
	<div class="company-product">
		<h2 class="text-uppercase">Our Product Categories</h2>
		<div class="row">
			<?php $products = array('Grains', 'Oils', 'Pulses', 'Vegetables', 'Furits', 'Disposable Items'); ?>
			<?php $markets = array('Hathikhana', 'Sayajipura'); ?>
			<?php for ($i=0; $i<15; $i++) { ?>
				<div class="col-sm-4 col-xs-6">
				  <div class="single-product">
				    <figure>

				      <img src="assets/img/content/whole-grains.jpg" alt="">
				      <figcaption>
				        <div class="read-more">
				          <a href="#"><i class="fa fa-angle-right"></i> Read More</a>
				        </div>
				      </figcaption>
				    </figure>
				    <h4><a href="#"><?php echo $products[rand(0,5)]; ?></a></a></h4>
				    <h5><a href="#"><?php echo $markets[rand(0,1)]; ?></a></h5>
				  </div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>

<?php include('footer.php'); ?>
<?php include('header.php'); ?>
	<div class="col-md-8">
		<h3>Tenders</h3>
		<table class="table-hover tender-table">
          <thead>
            <tr>
              <th>Title</th>
              <th width="15%">Start Date</th>
              <th width="15%">End Date</th>
              <th width="10%">Download</th>
              <th width="10%">Detials</th>
            </tr>
          </thead>

          <tbody>
          	<?php for ($i=0;$i<10;$i++) { ?>
	            <tr>
	              <td>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...</td>
	              <td>25-01-2015</td>
	              <td>28-02-2015</td>
	              <td class="text-center"><a href="#" title="Download"><i class="fa fa-download"></i></a></td>
	              <td class="text-center"><a href="tender_details.php" title="view"><i class="fa fa-share"></i></a></td>
	            </tr>
            <?php } ?>
          </tbody>
        </table>
	</div>

<?php include('sidebar.php'); ?>
<?php include('footer.php'); ?>
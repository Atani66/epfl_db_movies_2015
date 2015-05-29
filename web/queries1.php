<!DOCTYPE html>
<html lang="en">
  <?php include('head.php'); ?>
  
  <body>
	<style>
			body {
				padding-top: 150px;
			}
			.bodyOfPage {
				padding: 40px 15px;
			}
	</style>
	
	<?php include("menu.php"); ?>
    				
	
	<div class="col-md-8 col-md-offset-2" style="background-color:white">
		
		<h4>Deliverable queries</h4>
	
		<form action="#.php" method="get">
			<div class="form-group">
				<!-- <label for="deliverable" class="col-sm-2 control-label">Deliverable queries</label> -->
				<div class="col-md-10">
					<select name="query" class="form-control">
						<option value="1">Compute the number of movies per year</option>
						<option value="2">Compute the ten countries with most production companies</option>
						<option value="3">Compute the min, max and average career duration</option>
						<option value="4">Compute the min, max and average number of actors in a production</option>
						<option value="5">Compute the min, max and average height of female persons</option>
						<option value="6">List all pairs of persons and movies where the person has both directed the movie and acted in the movie</option>
						<option value="7">List the three most popular character names</option>
					</select>
				</div>
				
			</div>
			<div class="col-md-2">
					<button type="submit" class="btn btn-success">Execute</button>
			</div>
		</form>

	</div>
				
	<!-- /.container -->


    <!-- Bootstrap core JavaScript

    ================================================== -->

    <!-- Placed at the end of the document so the pages load faster -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <script src="../../dist/js/bootstrap.min.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->

    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

  </body>
</html>
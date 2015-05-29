<!DOCTYPE html>
<html lang="fr">
  <?php include('head.php'); ?>
  <body>
	<style>
			body {
				padding-top: 100px;
			}
			.bodyOfPage {
				padding: 40px 15px;
			}
	</style>
	<?php include("menu.php"); ?>


			<h4>Add a new Character</h4>
				<form action="insert-character.php" method="get" class="form-horizontal">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name" name="name" placeholder="Character name">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Insert</button>
						</div>
					</div>
				</form>

				<br/>

				<h4>Add a new Company</h4>
				<form action="insert-company.php" method="get" class="form-horizontal">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name" name="name" placeholder="Company name">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Insert</button>
						</div>
					</div>
				</form>

				<br/>

				<h4>Add a new Person</h4>
				<form action="insert-person.php" method="get" class="form-horizontal">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name" name="name" placeholder="Person name">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Insert</button>
						</div>
					</div>
				</form>

				<br/>

				<h4>Add a new Production</h4>
				<form action="insert-production.php" method="get" class="form-horizontal">
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Title</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="title" name="title" placeholder="Production title">
						</div>
					</div>
					<div class="form-group">
						<label for="type" class="col-sm-2 control-label">Type</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="type" name="type" placeholder="Production type">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Insert</button>
						</div>
					</div>
				</form>

				
				</div>
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
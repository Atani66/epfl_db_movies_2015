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


				
				<h4>Remove a person</h4>
					<div class="form-group">
				
					
						<label for="type" class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<form>
						<input type="radio" name="sex" value="male" checked>ID
						<br />
						<input type="radio" name="sex" value="female">Name
					</form> 
							<input type="text" class="form-control" id="valuePerson" name="valuePerson" >
						</div>
					</div>
						

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Remove</button>
						</div>
					</div>
				</form>
				
						
				<h4>Remove a Production</h4>
					<div class="form-group">
				
					
						<label for="type" class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<form>
						<input type="radio" name="sex" value="male" checked>ID
						<br />
						<input type="radio" name="sex" value="female">Title
					</form> 
							<input type="text" class="form-control" id="valuePerson" name="valuePerson" >
						</div>
					</div>
						

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Remove</button>
						</div>
					</div>
				</form>
				
						
				<h4>Remove a company</h4>
					<div class="form-group">
				
					
						<label for="type" class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<form>
						<input type="radio" name="sex" value="male" checked>ID
						<br />
						<input type="radio" name="sex" value="female">Name
					</form> 
							<input type="text" class="form-control" id="valuePerson" name="valuePerson" >
						</div>
					</div>
						

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Remove</button>
						</div>
					</div>
				</form> 
			<br /><br/><br /> <br /><br /> <br /><br /> 

				<h4>Remove a production-company affiliation</h4>
					<div class="form-group">
				
					
						<label for="type" class="col-sm-2 control-label"> Production ID</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="valuePerson" name="valuePerson" >
						</div>
					</div>
					
						<label for="type" class="col-sm-2 control-label"> Company ID</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="valuePerson" name="valuePerson" >
						</div>
					</div>
						

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Remove</button>
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
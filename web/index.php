<!DOCTYPE html>
<html lang="fr">
  <?php include('head.php'); ?>
  <body>
	<style>
			body {
				padding-top: 100px;
				margin-bottom: 60px;
			}
			.bodyOfPage {
				padding: 40px 15px;
			}
			.footer {
			  position: absolute;
			  bottom: 0;
			  width: 100%;
			  
			  height: 60px;
			  background-color: #f5f5f5;
			}
			
	</style>
    <?php include("menu.php"); ?>

    <div class="container">
		<div class="starter-template">
		   <!-- <h1>Starter</h1> -->
		   
			
			<div class="bodyOfPage">
					<div class="row">
						<div class="col-md-8 col-md-offset-2" style="background-color:white">
							<h4>Search</h4>
							<form action="search.php" method="post" class="form-inline">
								<input type="text" style="width:85%" class="form-control" id="search" name="search" 
									placeholder="Search an actor, a movie or anything you want... =)">
								<button type="submit" class="btn btn-success">Search</button>
								<!-- <button type="button" class="btn btn-default btn-lg">
									<span class="glyphicon glyphicon-film" aria-hidden="true"></span> Search
								</button> -->
							</form>
						</div>
					</div>
					<br />
					

			</div>
		</div>
    </div>
	
	<!--<footer class="footer">
		<div class="container">
			
			<p>
				Example courtesy and 
			</p>
		</div>
	</footer> -->
	
	<footer class="footer">
		<div class="container">
			<p>
				<?php 
					try{
						/*$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');*/
						$dbc = new PDO('oci:dbname=diassrv2.epfl.ch:1521/orcldias.epfl.ch;charset=CL8MSWIN1251', 'db2015_g18', '18db2015');					
						echo "Connected to Oracle =)";
						
						} 
						/*('db2015_g18', '18db2015', "diassrv2.epfl.ch:1521/orcldias.epfl.ch" )*/
					catch (Exception $e){
						die('Erreur : ' . $e->getMessage());}
				?>
			</p>
		</div>
	</footer>
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
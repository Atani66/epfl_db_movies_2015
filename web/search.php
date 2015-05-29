<!DOCTYPE html>
<html lang="fr">
  <?php include('head.php'); ?>
  
  <?php /*
		try{
			$bdd = new PDO('oci:dbname=diassrv2.epfl.ch:1521/orcldias.epfl.ch;charset=CL8MSWIN1251', 'db2015_g18', '18db2015');					
			echo "Connected to Oracle =)";
			
			} 
			catch (Exception $e){
			die('Erreur : ' . $e->getMessage());}
	*/?>
			
  <body>
  <style>
			body {
				padding-top: 100px;
			}
			.bodyOfPage {
				padding: 40px 15px;
			}
	</style>
	
	<?php include('menu.php'); ?>
		
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
							</form>
						
							<div style="padding-top: 50px;">
								<?php
									if (!isset($_POST['search']) || empty($_POST['search'])) {
										echo "<h4>Please enter something valid !</h4>\n";
									} else {
										try{
										$bdd = new PDO('oci:dbname=diassrv2.epfl.ch:1521/orcldias.epfl.ch;charset=CL8MSWIN1251', 'db2015_g18', '18db2015');} 
										catch (Exception $e){ die('Erreur : ' . $e->getMessage());}
										
										$_POST['search'] = htmlspecialchars($_POST['search']);
										echo "<p>Content of the search : \"" . $_POST['search'] . "\"</p>";
										
										$req = $bdd->query('SELECT * FROM TESTASD');
										
										while($donnees = $req->fetch()){
										?>
											<p> <?php echo $donnees['ID'] . " " . $donnees['TITLLE']; ?> <br />
											<?php
											}
											$req->closeCursor();
										
										/*searchPerson($_POST['search']);
										searchProduction($_POST['search']);
										searchCompany($_POST['search']);
										searchCaracter($_POST['search']);*/
									}
									
									function searchPerson() {
										echo "hey";
										$req = $dbb->query("SELECT COUNT(*) FROM Person");
										
									}

									function searchProduction() {

									}
									function searchCompany() {

									}
									function searchCaracter() {

									}
								?>
							</div>
						</div>
					</div>
					<br />
					
			
				
			
			
			</div>
		</div>
	</div>

    <!-- Bootstrap core JavaScript

    ================================================== -->

    <!-- Placed at the end of the document so the pages load faster -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <script src="../../dist/js/bootstrap.min.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->

    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

  </body>
</html>
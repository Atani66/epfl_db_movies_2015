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
						
							<div style="padding-top: 25px;">
								<?php
								
									if (!isset($_GET['id']) || empty($_GET['id'])) {
										echo "<h4>Wrong ID!</h4>\n";
									} else {
										try{
										$charId = $_GET['id'];
										$bdd = new PDO('oci:dbname=diassrv2.epfl.ch:1521/orcldias.epfl.ch;charset=CL8MSWIN1251', 'db2015_g18', '18db2015');} 
										catch (Exception $e){ die('Erreur : ' . $e->getMessage());}
										
										$charId = htmlspecialchars($_GET['id']);

										/* CHAR BLOCK */
										$req = $bdd->query('SELECT * FROM CHARACTERS WHERE id=\'' . $charId . '\'');
										$data = $req->fetch();
										echo "<h1>" . $data["NAME"] . " : </h1>";
										
										$reqProdid = $bdd->query('SELECT * FROM PROD_CAST WHERE CHARACTER_ID=\'' . $charId . '\'');
										$prodData = $reqProdid->fetch();
										
										$person_id = $prodData['PERSON_ID'];
										$persReq = $bdd->query('SELECT NAME FROM PERSON WHERE id=\'' . $person_id . '\'');
										$persData = $persReq->fetch();
										
										echo "<h3> <em>Interpreted by </em> <a href=\"person.php?id=".$person_id."\"> ".$persData["NAME"]." </a>";
										
										$prodId = $prodData['PRODUCTION_ID'];
										
										$reqProdName = $bdd->query('SELECT ID, TITLLE FROM PRODUCTION WHERE ID=\'' . $prodId . '\'');
										$prodDataName = $reqProdName->fetch();
										
										echo " in <a href=\"production.php?id=".$prodDataName['ID']."\"> ".$prodDataName['TITLLE']." </a>";
										
										
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
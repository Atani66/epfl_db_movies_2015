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
										$productionId = $_GET['id'];
										
										$bdd = new PDO('oci:dbname=diassrv2.epfl.ch:1521/orcldias.epfl.ch;charset=CL8MSWIN1251', 'db2015_g18', '18db2015');} 
										catch (Exception $e){ die('Erreur : ' . $e->getMessage());}
										$productionId = htmlspecialchars($_GET['id']);

										/* PRODUCTION BLOCK */
										$req = $bdd->query('SELECT * FROM PRODUCTION WHERE id=\'' . $productionId . '\'');
										$prodData = $req->fetch();
										
										$prodName = $prodData['TITLLE'];
										if ($prodData["PROD_YEAR"] != null) {
											echo "<h1>" . $prodName . " - " . $prodData["PROD_YEAR"] . ": </h1>";
										} else {
											echo "<h1>" . $prodName . ": </h1> <br />";
										}
										
										if ($prodData['PRODUCTION_YEAR'] != null) {
											echo "<strong>Production Year: </strong> " .  date("d/m/Y", strtotime($prodData['PRODUCTION_YEAR'])) . " <br />";
										} else {
											echo "Production Year: Unknown <br />";
										}

										if ($prodData['SERIES_YEARS_START'] != null) {
										  echo  "<strong> Start of the series :</strong> <em> <p> " . date("d/m/Y", strtotime($prodData['SERIES_YEARS_START'])) . " </em> </p> "; 
										}
										
										if ($prodData['SERIES_YEARS_END'] != null) {
											echo  "<strong> End of the series :</strong> <em> <p> " . date("d/m/Y", strtotime($prodData['SERIES_YEARS_END'])) . " </em> </p> "; 
										}

										if ($prodData['SEASON_NUMBER'] != null) {
										  echo  "<strong> Season number :</strong> <em> " .$prodData['SEASON_NUMBER'] . " </em> <br /> "; 
										}

										if ($prodData['GENRE'] != null) {
										  echo  " <strong> Genre :</strong> <em> " . $prodData['GENRE'] . " </em> <br />"; 
										}
										
										if ($prodData['KIND'] != null) {
										  echo  " <strong> Kind :</strong> <em> " . $prodData['KIND'] . " </em> <br />"; 
										}
										
										/* RELATION BLOCK */
										//CAST RELATION
										$reqProdCast = $bdd->query('SELECT * FROM PROD_CAST WHERE PRODUCTION_ID=\'' . $productionId . '\'');
										echo "<br /> <h2> Main Cast: </h2><br /> ";
										while($dataProdCast = $reqProdCast->fetch()){
											$char_id = $dataProdCast["CHARACTER_ID"];
											$person_id = $dataProdCast["PERSON_ID"];
											$role = $dataProdCast["ROLE"];
											
											if ($person_id != null) {
												$reqPersName = $bdd->query('SELECT ID, NAME FROM PERSON WHERE ID=\'' . $person_id . '\'');
												$persName = $reqPersName->fetch();
												echo "<h3> <a href=\"../person.php?id=" . $persName["ID"] . " \">" . $persName["NAME"] . ": </a> </h3> <br />";
											} 
											
											if ($char_id != null) {
												$reqCharName = $bdd->query('SELECT name FROM CHARACTERS WHERE ID=\'' . $char_id . '\'');
												$charName = $reqCharName->fetch();
												echo "<strong>Character named: <strong>" . $charName["NAME"] . "  <br />";
											}
											
											if ($role != null) {
												echo "<strong>Role: <strong>" . $role . "  <br />";
											} else {
												echo "<strong>Role: <strong> Unknown <br />";
											}
											
											echo "<hr>";
											
										}
										
										//COMPANY RELATION
										$reqProdComp = $bdd->query('SELECT * FROM PRODUCTION_COMPANY WHERE PRODUCTION_ID=\'' . $productionId . '\'');
										echo "<br /> <h2> Affiliated Companies: </h2><br /> ";
										
										while($dataProdComp = $reqProdComp->fetch()){
											$comp_id = $dataProdComp["COMPANY_ID"];
											$kind = $dataProdComp["KIND"];
											
											if ($comp_id != null) {
												$reqComp = $bdd->query('SELECT * FROM COMPANY WHERE ID=\'' . $comp_id . '\'');
												$compData = $reqComp->fetch();
												
												echo "<h3><a href=\"../company.php?id= ' . $comp_id . ' \"> " . $compData["NAME"] ." </a></h3> <br /> ";
												echo "Country Code : " . $compData["COUNTRY_CODE"] . " <br />";
												echo "Affiliation : " . $kind ." <br />";
												
											}
											echo "<hr>";
										}
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
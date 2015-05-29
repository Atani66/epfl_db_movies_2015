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
										$personId = $_GET['id'];
										$bdd = new PDO('oci:dbname=diassrv2.epfl.ch:1521/orcldias.epfl.ch;charset=CL8MSWIN1251', 'db2015_g18', '18db2015');} 
										catch (Exception $e){ die('Erreur : ' . $e->getMessage());}
										
										$personId = htmlspecialchars($_GET['id']);

										/* PERSON BLOCK */
										$req = $bdd->query('SELECT * FROM PERSON WHERE id=\'' . $personId . '\'');
										
										$data = $req->fetch();
										
										echo "<em><h2> " . $data['NAME'] . " : </h2></em></p> <br /> <br />";
										
										if ($data['GENDER'] != null) {
											echo "<strong>Gender:</strong> [" . $data['GENDER'] . "] <br />";
										} else {
											echo "<strong>Gender:</strong> [?] <br />";
										}

										if ($data['TRIVIA'] != null) {
										  echo  "<p> <strong> Trivia :</strong> <em> " .$data['TRIVIA'] . " </em> </p> "; 
										}

										if ($data['MINI_BIOGRAPHY'] != null) {
										  echo  " <p><strong> Biography :</strong> <em> " . $data['MINI_BIOGRAPHY'] . " </em> </p> "; 
										}

										if ($data['QUOTES'] != null) {
										  echo  "<strong> Quotes :</strong> <em> <p> " . $data['QUOTES'] . " </em> </p> "; 
										}
										
										if ($data['BIRTH_DATE'] != null) {
										  echo  "<strong> Birth Date :</strong> <em> <p> " . date("d/m/Y", strtotime($data['BIRTH_DATE'])) . " </em> </p> "; 
										}
										
										if ($data['DEATH_DATE'] != null) {
											echo  "<strong> Death Date :</strong> <em> <p> " . date("d/m/Y", strtotime($data['DEATH_DATE'])) . " </em> </p> "; 
										}

										if ($data['BIRTH_NAME'] != null) {
											echo  "<strong> Birth Name :</strong> <em> <p> " . $data['BIRTH_NAME'] . " </em> </p> "; 
										}

										if ($data['SPOUSE'] != null) {
											echo  "<strong> Spouse Name :</strong> <em> <p> " . $data['SPOUSE'] . " </em> </p> "; 
										}
										
										if ($data['HEIGHT'] != null) {
											echo  "<strong> Height :</strong> <em> <p> " . $data['HEIGHT'] . " cm </em> </p> "; 
										}

										
										/* RELATION BLOCK */
										//ALT NAME
										$reqAltName = $bdd->query('SELECT * FROM ALTERNATIVE_NAME WHERE PERSON_ID=\'' . $personId . '\'');
										if ($reqAltName->rowCount() > 0) {
											echo "<br /> <p> Alternative Names: <ul> ";
											while($dataAltName = $reqAltName->fetch()){
												echo "<li> " . $dataAltName['NAME'] . " </li> <br />";
											}
											echo "</ul>";
										}
										
										//PRODUCTON CAST MEMBERSHIP 
										$reqProdCast = $bdd->query('SELECT * FROM PROD_CAST WHERE PERSON_ID=\'' . $personId . '\'');
										echo "<br /> <h2> Cast participation: </h2><br /> ";
										while($dataProdCast = $reqProdCast->fetch()){
											
											$char_id = $dataProdCast["CHARACTER_ID"];
											$prod_id = $dataProdCast["PRODUCTION_ID"];
											$role = $dataProdCast["ROLE"];
											
											if ($prod_id != null) {
												$reqProdName = $bdd->query('SELECT TITLLE FROM PRODUCTION WHERE ID=\'' . $prod_id . '\'');
												$prodName = $reqProdName->fetch();
												echo "<h3><a href=\"production.php?id=" . $prod_id . "\"> " . $prodName["TITLLE"] . ": </a> </h3> <br />";
											} else {
												echo "<strong>Production named: <strong> Unknown <br />";
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
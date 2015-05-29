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
								
									function searchPerson($bdd, $textQuery) {
										echo "<h2>In Persons: </h2> <br />";

										$cleanedQuery = preg_replace('/\s+/', ', ', trim($textQuery) );
										$reversedQuery = null;
										
										$teststr = explode(" ", trim($textQuery));
										
										if (count($teststr) > 1) {
											$reversedQuery = "" . $teststr[1] . " " . $teststr[0] . "";
										}

										$reversedQuery = preg_replace('/\s+/', ', ', $reversedQuery);
										if ($reversedQuery != null) {
											$req = $bdd->query('SELECT * FROM PERSON WHERE REGEXP_LIKE(NAME,  \'^' . $cleanedQuery . '\') OR REGEXP_LIKE(NAME,  \'^' . $reversedQuery . '\') OR REGEXP_LIKE(NAME,  \'^' . $textQuery . '\') ');
										} else {
											$req = $bdd->query('SELECT * FROM PERSON WHERE REGEXP_LIKE(NAME,  \'^' . $cleanedQuery . '\') OR REGEXP_LIKE(NAME,  \'^' . $textQuery . '\') ');
										}
										
										while($donnees = $req->fetch()){
											  echo "<p>" . $donnees['NAME'] . ", ";
											  
											  if ($donnees['GENDER'] != null) {
												  
												  echo "[" . $donnees['GENDER'] . "]";
											  } else {
												  echo "[?]";
											  }
											  
											  if ($donnees['MINI_BIOGRAPHY'] != null) {
												  echo  "<strong> Bio :</strong> <em> " . mb_substr($donnees['MINI_BIOGRAPHY'], 0, 50) . "... "; 
											  }
											  echo " </em> <a href=\"person.php/?id=". $donnees['ID'] ."\"> More </a><br /> ";
										}
										$req->closeCursor();
										echo "<hr>";
									}

									function searchProduction($bdd, $textQuery) {
										echo "<h2>In Production: </h2> <br />";
										
										$cleanedQuery = trim($textQuery);
										$req = $bdd->query('SELECT * FROM PRODUCTION WHERE REGEXP_LIKE(TITLLE, \'' . $cleanedQuery . '\')  ');

										//$req = $dbb->query("SELECT COUNT(*) FROM Person");

										while($donnees = $req->fetch()){ 
												echo "<p>" . $donnees['TITLLE'] . ", ";
												if ($donnees['KIND'] != null) {
												  echo " <strong>Kind</strong>: [" . $donnees['KIND'] . "]";
												} 
												if ($donnees['GENRE'] != null) {
												  echo " <strong>Genre</strong>: [" . $donnees['GENRE'] . "]";
												} 
										}
										$req->closeCursor();
										echo "<hr>";
									}
									
									function searchCompany($bdd, $textQuery) {
										echo "<h2>In Comapnies: </h2> <br />";
										
										$req = $bdd->query('SELECT * FROM COMPANY WHERE NAME=\'' . $textQuery . '\'');

										//$req = $dbb->query("SELECT COUNT(*) FROM Person");

										while($donnees = $req->fetch()){ 
												echo "<p>" . $donnees['NAME'] . "  " . $donnees['COUNTRY_CODE'] . " <br /> ";
										}
										$req->closeCursor();
										echo "<hr>";

									}
									function searchCaracter($bdd, $textQuery) {
										echo "<h2>In Characters: </h2> <br />";
										
										$req = $bdd->query('SELECT * FROM CHARACTERS WHERE NAME=\'' . $textQuery . '\'');

										//$req = $dbb->query("SELECT COUNT(*) FROM Person");

										while($donnees = $req->fetch()){ 
												echo "<p>" . $donnees['NAME'] . " <br /> ";
										}
										$req->closeCursor();
										echo "<hr>";

									}

								
									if (!isset($_POST['search']) || empty($_POST['search'])) {
										echo "<h4>Please enter something valid !</h4>\n";
									} else {
										try{
										$bdd = new PDO('oci:dbname=diassrv2.epfl.ch:1521/orcldias.epfl.ch;charset=CL8MSWIN1251', 'db2015_g18', '18db2015');} 
										catch (Exception $e){ die('Erreur : ' . $e->getMessage());}
										
										$textQuery = htmlspecialchars($_POST['search']);
										echo "<p>Content of the search : \"" . $textQuery . "\"</p>";
										
										searchPerson($bdd, $textQuery);
										searchProduction($bdd, $textQuery);
										searchCompany($bdd, $textQuery);
										searchCaracter($bdd, $textQuery);

										
										/*searchPerson($_POST['search']);
										searchProduction($_POST['search']);
										searchCompany($_POST['search']);
										searchCaracter($_POST['search']);*/
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
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
				<label for="value" class="col-sm-2 control-label">ID if needed :</label>
						<div class="col-sm-10">
							<input type="number" class="form-control" id="value" name="value" placeholder="1349754" min=0>
						</div>
					<select name="query" class="form-control">
						<option value="1">Find the actors and actresses (and report the productions) who played in a production 
						where they were 55 or more year older than the youngest actor/actress playing.</option>
						<option value="2">Actor's most productive year.</option>
						<option value="3">Companies with the highest number of productions in each genre.</option>
						<option value="4">Compute who worked with spouses/children/potential relatives on the same production.</option>
						<option value="5">Average number of actors per production per year</option>
						<option value="6">Average number of episodes per season.</option>
						<option value="7">Average number of seasons per series.</option>
						<option value="8">Top ten tv-series (by number of seasons).</option>
						<option value="9">Top ten tv-series (by number of episodes per season).</option>
						<option value="9">Find actors, actresses and directors who have movies (including tv movies and video movies) 
						released after their death.</option>
						<option value="9">For each year, show three companies that released the most movies.	</option>
						<option value="9">List all living people who are opera singers ordered from youngest to oldest.</option>
						<option value="9">List 10 most ambiguous credits (pairs of people and productions) ordered by the degree of ambiguity. 
						A credit is ambiguous if either a person has multiple alternative names or a production has multiple alternative titles. 
						The degree of ambiguity is a product of the number of possible names (real name + all alternatives) 
						and the number of possible titles (real + alternatives).</option>
						<option value="9">For each country, list the most frequent character name that appears 
						in the productions of a production company (not a distributor) from that country.</option>
						<option value="9"></option>
					</select>
					<br /> <br />
					
					
					<?php
					try{
						$bdd = new PDO('oci:dbname=diassrv2.epfl.ch:1521/orcldias.epfl.ch;charset=CL8MSWIN1251', 'db2015_g18', '18db2015');
								
						if (!isset($_GET['query']) || empty($_GET['query'])) {
							//echo "<h3>Please select a query!</h>\n";
						} else {
						$query = $_GET['query'];
							
							//Query a
							if ($query == 1) { 
									echo "<h2> Older actor playing with younger ones  </h2> <br />";
									
									$req = $bdd->query('With innerQ as (
													SELECT production_id, name, anni
													FROM (
														SELECT production_id, 
															name, 
															EXTRACT(YEAR FROM birth_date) as anni, 
															ROW_Number() Over (PARTITION BY production_id order by birth_date) as rownb,
															count(*) over(PARTITION BY production_id) CNT 
														FROM production prod, prod_cast prodCast, person p
														WHERE prod.id=prodCast.production_id 
															AND p.id = prodCast.person_id
															AND birth_date is not null
													) tmp
													WHERE (ROWNB = 1 OR ROWNB = CNT))
												SELECT p.titlle, p.id, b.name as Who, b.anni, a.anni-b.anni as AgeDiff
												FROM innerQ a, innerQ b, production p
												WHERE a.production_id = b.production_id 
													AND a.name != b.name 
													AND a.anni-b.anni >= 55
													AND a.production_id = p.id');
														
									while($data = $req->fetch()){
										echo "<em>".$data["WHO"] . "</em> in : <strong>". $data["TITLLE"] ." </strong> <br />" ;
									}
								
							}
							
							//Query b
							if ($query == 2) {
									$val = null;
									if ($_GET['value'] == NULL) {
										$val = 1349754;
									} else {
										$val = $_GET['value'];
									}
									echo "<h2> Actor's most productive year </h2> <br />";
									
									$req = $bdd->query('SELECT *
														FROM
														  (
														  SELECT prod_year, count(*) as productivity
														  FROM production prod, prod_cast pc, person p
														  WHERE  prod.id=pc.production_id AND pc.person_id=p.id AND p.id = '. $val .'
														  AND prod_year <> 0
														  GROUP BY prod_year
														  ORDER BY productivity DESC
														  ) tmp
														WHERE ROWNUM = 1');
														
									while($data = $req->fetch()){
										echo "In <em>".$data["PROD_YEAR"] . "</em> <a href=\"person.php?id=".$val."\"> he/she</a> made <strong>". $data["PRODUCTIVITY"] ." </strong> movies  <br />" ;
									}
								
							}
							
							//Query b
							if ($query == 3) {
								
									echo "<h2> Highest number of productions in each genre by companies </h2> <br />";
									$req = $bdd->query('SELECT COUNT(*) as nbreProd, c.name, p.genre
														FROM production p, production_company pComp, company c
														WHERE p.id = pComp.production_id 
														 AND p.prod_year = 2015 
														AND pComp.company_id = c.id
														GROUP BY c.name, p.genre
														ORDER BY p.genre, nbreProd DESC');
														
									while($data = $req->fetch()){
										if ($data["GENRE"] != NULL) {
											echo "<em>".$data["NBREPROD"] . "</em> Productions by <strong>". $data["NAME"] ." </strong> of ". $data["GENRE"]."  <br />" ;
										} else {
											echo "<em>".$data["NBREPROD"] . "</em> Productions by <strong>". $data["NAME"] ." </strong> (No genre specified) <br />" ;
										}
									}
								
							}
							
						}

						
					} catch (Exception $e){ die('Erreur : ' . $e->getMessage());}
					
					?>
					
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
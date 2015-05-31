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
					
					<?php
					try{
						$bdd = new PDO('oci:dbname=diassrv2.epfl.ch:1521/orcldias.epfl.ch;charset=CL8MSWIN1251', 'db2015_g18', '18db2015');
								
						if (!isset($_GET['query']) || empty($_GET['query'])) {
							echo "<h3>Please select a query!</h>\n";
						} else {
						$query = $_GET['query'];
							
							//Query a
							if ($query == 1) { 
									echo "<h2> Number of movies per year </h2> <br />";
									
									$req = $bdd->query("SELECT prod_year as yearOfProd, COUNT(*) 
														FROM PRODUCTION 
														WHERE prod_year != 0 
														GROUP BY prod_year
														ORDER BY prod_year");
														
									while($data = $req->fetch()){
										echo "<strong>".$data["YEAROFPROD"] . ": </strong> ". $data["COUNT(*)"] ."<br />" ;
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
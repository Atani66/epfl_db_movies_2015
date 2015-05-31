/*a) Compute the number of movies per year. Make sure to include tv and video movies.*/

SELECT COUNT(*) 
FROM Production 
WHERE production_year = TO_DATE(.$i.'/04/01','yy/mm/dd');
--à intégrer dans une boucle for qui gere $i comme désiré...

--autre solution :
SELECT EXTRACT (YEAR from production_year) as yearOfProd, COUNT(*)
FROM Production
GROUP BY yearOfProd
ORDER BY yearOfProd

--version finale :
SELECT prod_year as yearOfProd, COUNT(*) 
FROM test_Production 
WHERE prod_year != 0 
GROUP BY prod_year
ORDER BY prod_year


/*b) Compute the ten countries with most production companies.*/
SELECT country_code, COUNT(*) as nombreProd
FROM test_Production_company pComp, test_Company comp
WHERE pComp.company_id = comp.id AND country_code is not null
GROUP BY country_code
ORDER BY nombreProd DESC
OFFSET 0 ROWS FETCH NEXT 10 ROWS ONLY

--c) Compute the min, max and average career duration. (A career length is implied by the first and last production of a person)
SELECT MIN(duree) as mini, MAX(duree) as maxi, ROUND(AVG(duree)) as moyenne
FROM (SELECT MAX(prod_year)-MIN(prod_year)+1 duree
		FROM test_person p, test_prod_cast prodCast, test_production prod
		WHERE prod_year is not null and p.id=prodCast.person_id and prod.id=prodCast.production_id 
		GROUP BY p.id ) tableDuree

--d) Compute the min, max and average number of actors in a production.
SELECT MIN(people) as mini, MAX(people) as maxi, ROUND(AVG(people)) as moyenne
FROM (
	SELECT COUNT(*) as people
	FROM test_person p, test_prod_cast prodCast, test_production prod
	WHERE p.id=prodCast.person_id 
		AND prod.id=prodcast.production_id
		AND (prodCast.role LIKE 'actor' OR prodCast.role LIKE 'actress') 
	GROUP BY prod.id 
	) peopleInProd

--e) Compute the min, max and average height of female persons.
SELECT MIN(taille) as mini, MAX(taille) as maxi, AVG(taille) as moyenne
FROM person(SELECT height as taille
		FROM person 
		WHERE gender LIKE 'f') as tailleDesFemmes
		
-- easier...:
SELECT MIN(height), MAX(height), AVG(height)
from person
WHERE gender LIKE 'f'

--f) List all pairs of persons and movies where the person has both directed the movie and acted in the movie. 
--Do not include tv and video movies.
Select name,titlle
FROM test_production prod, test_person p,
	(SELECT pc1.production_id, pc1.person_id
		FROM test_prod_cast pc1, test_prod_cast pc2
		WHERE pc1.production_id=pc2.production_id
			AND pc1.person_id = pc2.person_id
			AND pc1.role LIKE 'actor'
			AND pc2.role LIKE 'director'
	) dbles
WHERE prod.id = dbles.production_id
AND p.id = dbles.person_id


--autre début de solution:
Select title
FROM production, production_cast as pc,
	(SELECT production_id, role
     FROM production_cast
    GROUP BY production_id, person_id
    Having count(*) >= 2) as dbles
WHERE pc.production_id = dbles.production_id AND 

/*g) List the three most popular character names.*/
SELECT COUNT(*) as appearances, c.name
FROM test_prod_cast prodCast
INNER JOIN characters c
ON prodCast.character_id=c.id
GROUP BY character_id, c.name
ORDER BY appearances DESC
OFFSET 0 ROWS FETCH NEXT 3 ROWS ONLY

--avec le détail :
SELECT COUNT(*) as appearances, prodCast.character_id, c.name
FROM test_prod_cast prodCast
INNER JOIN characters c
ON prodCast.character_id=c.id
GROUP BY character_id, c.name
ORDER BY appearances DESC
OFFSET 0 ROWS FETCH NEXT 3 ROWS ONLY
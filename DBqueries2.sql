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
SELECT production_year as yearOfProd, COUNT(*)
FROM Production
WHERE production_year IS NOT NULL AND production_year != 0
GROUP BY yearOfProd
ORDER BY yearOfProd


/*b) Compute the ten countries with most production companies.*/
SELECT country_code, COUNT(*) as nombreProd
FROM Production_company AS pc, Company AS c
WHERE pc.company_id = c.id AND country_code is not null
GROUP BY country_code
ORDER BY nombreProd DESC
LIMIT 0,10


--c) Compute the min, max and average career duration. (A career length is implied by the first and last production of a person)
SELECT MIN(duree) as mini, MAX(duree) as maxi, 
ROUND(AVG(duree)) as moyenne
FROM (SELECT MAX(production_year)-MIN(production_year) as duree
		FROM person, production_cast, production 
		WHERE production_year != 0 and person.id=production_cast.person_id and production.id=production_cast.production_id 
		GROUP BY person.id ) as tableDuree

--d) Compute the min, max and average number of actors in a production.
SELECT MIN(people) as mini, MAX(people) as maxi, 
ROUND(AVG(people)) as moyenne

FROM (SELECT COUNT(*) as people

FROM person, production_cast, production 

WHERE person.id=production_cast.person_id and production.id=production_cast.production_id 
      
GROUP BY production.id ) as peopleInProd

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
Select name,title
FROM production, person,
	(SELECT pc1.production_id, pc1.person_id
		FROM production_cast as pc1, production_cast as pc2
		WHERE pc1.production_id=pc2.production_id
		AND pc1.role LIKE 'actor'
		AND pc2.role LIKE 'director'
	) as dbles
WHERE production.id = dbles.production_id
AND person.id = dbles.person_id


--autre début de solution:
Select title
FROM production, production_cast as pc,
	(SELECT production_id, role
     FROM production_cast
    GROUP BY production_id, person_id
    Having count(*) >= 2) as dbles
WHERE pc.production_id = dbles.production_id AND 

/*g) List the three most popular character names.*/
SELECT COUNT(*) as appearances, pCast.character_id, c.name
FROM production_cast as pCast
INNER JOIN characters as c
ON pCast.character_id=c.id
GROUP BY character_id
ORDER BY appearances DESC
LIMIT 3
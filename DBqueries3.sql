--a) Find the actors and actresses (and report the productions) who played in a production 
--where they were 55 or more year older than the youngest actor/actress playing.


--b)(OK) Given an actor, compute his most productive year.
SELECT *
FROM
  (
  SELECT prod_year, count(*) as productivity
  FROM production prod, prod_cast pc, person p
  WHERE  prod.id=pc.production_id AND pc.person_id=p.id AND p.id = 3429434 -- id of person is given in request
  AND prod_year <> 0
  GROUP BY prod_year
  ORDER BY productivity DESC
  ) tmp
WHERE ROWNUM = 1

SELECT production_year, count(*) as productivity
FROM production p, prod_cast pc, person
WHERE  p.id=pc.production_id AND pc.person_id=person.id AND person.name LIKE '%Bruce Willis%' -- name given...
AND rownum = 1
GROUP BY production_year
ORDER BY productivity DESC

--autre essai :
SELECT name, production_year y
FROM production prod, production_cast pc, person
WHERE prod.id=pc.production_id AND pc.person_id=person.id 
AND prod.production_year != 0

-- pas mal :
SELECT name, y, count(*) as c
FROM
(SELECT name, production_year y
FROM production prod, production_cast pc, person
WHERE prod.id=pc.production_id AND pc.person_id=person.id 
AND prod.production_year != 0) as tmp

GROUP BY name, y
ORDER BY name, c DESC


--c)(OK) Given a year, list the company with the highest number of productions in each genre.
SELECT COUNT(*) as nbreProd, c.name, p.genre
    FROM production p, production_company pComp, company c
    WHERE p.id = pComp.production_id 
     AND p.prod_year = 2015 
    AND pComp.company_id = c.id
    GROUP BY c.name, p.genre
    ORDER BY p.genre, nbreProd DESC
	
--> CORRECT MAIS MOCHE
SELECT *
FROM
    (
    SELECT nbreProd, id, genre, Row_number() over (partition by genre order by genre, nbreProd DESC) as rownb
    FROM
        (
        SELECT COUNT(*) as nbreProd, c.id, p.genre
        FROM test_production p, test_production_company pComp, test_company c
        WHERE p.id = pComp.production_id 
         AND p.prod_year = 2015 
        AND pComp.company_id = c.id
        GROUP BY c.id, p.genre
        ) tmp
    ) tmp2
WHERE rownb = 1

--autre solution qui devrait marcher mais pas vraiment juste... :
SELECT nbreProd, name, genre
FROM 
    (SELECT COUNT(*) as nbreProd, c.name, p.genre
    FROM production p, production_company pComp, company c
    
     WHERE p.id = pComp.production_id 
    AND p.production_year = 2015 
    AND pComp.company_id = c.id
    
     GROUP BY c.id
    ORDER BY genre, nbreProd DESC ) as tmp
GROUP BY genre


--d) Compute who worked with spouses/children/potential relatives on the same production. 
--(You can assume that the same real surname implies a relation)


--e) (PAS OK) Compute the average number of actors per production per year
SELECT AVG() as MoyAct/annee,

SELECT production_id, person_ID, role, production_year
FROM production_cast pc, production
WHERE role LIKE 'actor' 
AND production.id = pc.production_id
AND production_year != 0


--f)(OK) Compute the average number of episodes per season.
SELECT AVG(nbre) as NumberOfEpisodes, season
FROM (
    SELECT COUNT(*) as nbre, series_id,
    season_number as season
    FROM production
    WHERE season_number is not null
    GROUP BY series_id, season ) as tmp
GROUP BY season


--g)(OK) Compute the average number of seasons per series. -> query un peu compliqué.... à améliorer avec un Rank over je pense
SELECT AVG(nbreSeason)
FROM
	(SELECT COUNT(*) as nbreSeason, series_id
    FROM(
        SELECT COUNT(*), series_id, season_number
        FROM production
        WHERE kind LIKE 'episode'
        GROUP BY series_id, season_number ) as tmp
    GROUP BY series_id ) as tmp2



--h) (pas fini) Compute the top ten tv-series (by number of seasons).
SELECT COUNT(*) as nbreSeason, series_id
FROM(
	SELECT COUNT(*), series_id, season_number
	FROM production
	WHERE kind LIKE 'episode'
	GROUP BY series_id, season_number ) as tmp
GROUP BY series_id
	
	
--i) Compute the top ten tv-series (by number of episodes per season).

--j) (OK) Find actors, actresses and directors who have movies (including tv movies and video movies) released after their death.
SELECT Name, prod_year as ProductionYear, EXTRACT(YEAR from death_date) as deathYear
FROM person p, production_cast prodCast, production prod
WHERE p.id = prodCast.person_id
AND prodCast.production_id = prod.id
AND (prodCast.role LIKE 'actor' or prodCast.role LIKE 'actress' or prodCast.role LIKE 'director')
AND EXTRACT(YEAR from death_date) < prod_year
GROUP BY name

--k) (OK) For each year, show three companies that released the most movies.

--magnifique requete qui fonctionne parfaitement
SELECT prod_year, rownb as ranking, name
FROM
    (
    SELECT company_id, prod_year, 
    ROW_NUMBER() over (PARTITION by prod_year order by count(*) DESC ) as rownb
    FROM production_company prodComp, production p
    WHERE p.id = prodComp.production_id
    AND prod_year != 0
    GROUP BY company_id, prod_year
    ) tmp, company
where rownb <= 3
AND company.id = company_id

-- this one gives the total result. We should then keep only the 3 most productive for each year
SELECT COUNT(*) as nbreProd, company_id, prod_year
    FROM production_company prodComp, production
    WHERE production.id = prodComp.production_id
    AND prod_year != 0
    GROUP BY company_id
    ORDER BY prod_year, nbreProd DESC
	    

--l) List all living people who are opera singers ordered from youngest to oldest.
-- Maybe we should there are other fields to check with the key word "opera singer" 
SELECT * FROM PERSON WHERE REGEXP_LIKE(TRIVIA, 'opera singer') OR
        REGEXP_LIKE(MINI_BIOGRAPHY, 'opera singer')
	ORDER BY EXTRACT(YEAR from BIRTH_DATE);
	
--m) List 10 most ambiguous credits (pairs of people and productions) ordered by the degree of ambiguity. 
--A credit is ambiguous if either a person has multiple alternative names or a production has multiple alternative titles. 
--The degree of ambiguity is a product of the number of possible names (real name + all alternatives) and the number of possible titles (real + alternatives).
--n) For each country, list the most frequent character name that appears in the productions of a production company (not a distributor) from that country.

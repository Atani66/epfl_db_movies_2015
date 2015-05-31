--a) Find the actors and actresses (and report the productions) who played in a production 
--where they were 55 or more year older than the youngest actor/actress playing.

With innerQ as (
    SELECT production_id, name, anni
    FROM (
		SELECT production_id, 
			name, 
			EXTRACT(YEAR FROM birth_date) as anni, 
			ROW_Number() Over (PARTITION BY production_id order by birth_date) as rownb,
			count(*) over(PARTITION BY production_id) CNT 
		FROM test_production prod, test_prod_cast prodCast, test_person p
		WHERE prod.id=prodCast.production_id 
			AND p.id = prodCast.person_id
			AND birth_date is not null
    ) tmp
    WHERE (ROWNB = 1 OR ROWNB = CNT))
SELECT p.titlle, p.id, b.name as Who, b.anni, a.anni-b.anni as AgeDiff
FROM innerQ a, innerQ b, test_production p
WHERE a.production_id = b.production_id 
	AND a.name != b.name 
	AND a.anni-b.anni >= 55
	AND a.production_id = p.id



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


--d) (OK : manque l'ajout d'une regexp pour prendre que le surname)Compute who worked with spouses/children/potential relatives on the same production. 
--(You can assume that the same real surname implies a relation)

SELECT pid, p1.name, p1id, p2.name, p2id
FROM test_person p1, test_person p2, (
    SELECT pc1.production_id as pid, pc1.person_id as p1id, pc2.person_id as p2id
    FROM test_prod_cast pc1, test_prod_cast pc2
    WHERE pc1.person_id < pc2.person_id AND pc1.production_id = pc2.production_id
    ) tmp
WHERE p1id = p1.id AND p2id = p2.id AND p1.name = p2.name


--e) (OK) Compute the average number of actors per production per year
SELECT prod_year, avg(cnt)
FROM (
    SELECT production_id, prod_year, count(*) as cnt
    FROM test_prod_cast prodCast, test_production prod
    WHERE prodCast.production_id = prod.id and prod_year <> 0
        AND (role LIKE 'actor' or role like 'actress')
    GROUP BY prod_year, production_id
    ORDER BY prod_year
    ) tmp
GROUP BY prod_year
ORDER BY prod_year


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



--h) (OK) Compute the top ten tv-series (by number of seasons).
SELECT COUNT(*) as nbreSeason, series_id
FROM(
	SELECT series_id, season_number
	FROM test_production
	WHERE kind LIKE 'episode'
	GROUP BY series_id, season_number ) tmp
GROUP BY series_id
ORDER BY nbreSeason DESC
OFFSET 0 ROWS FETCH NEXT 10 ROWS ONLY
	
	
--i) Compute the top ten tv-series (by number of episodes per season).
SELECT series_id, avg(cnt) as episodesPerSeason
FROM (
    SELECT *
    FROM (
      SELECT series_id, COUNT(*) OVER (PARTITION BY series_id, season_number ORDER BY series_id) as cnt
      FROM test_production
      WHERE kind LIKE 'episode'
      ) tmp
    GROUP BY series_id, CNT
    ORDER BY series_id
    ) tmp2
GROUP BY series_ID
ORDER BY episodesPerSeason DESC



--j) (OK) Find actors, actresses and directors who have movies (including tv movies and video movies) released after their death.
SELECT p.name, prod.titlle, prod_year as ProductionYear, EXTRACT(YEAR from death_date) as deathYear
FROM test_person p, test_prod_cast prodCast, test_production prod
WHERE p.id = prodCast.person_id
AND prodCast.production_id = prod.id
AND (prodCast.role LIKE 'actor' or prodCast.role LIKE 'actress' or prodCast.role LIKE 'director')
AND EXTRACT(YEAR from death_date) < prod_year
GROUP BY p.name, prod.titlle, prod_year, EXTRACT(YEAR from death_date)

--k) (OK) For each year, show three companies that released the most movies.

--magnifique requete qui fonctionne parfaitement
SELECT prod_year, rownb as ranking, name
FROM company,
    (
    SELECT company_id, prod_year, 
    ROW_NUMBER() over (PARTITION by prod_year order by count(*) DESC ) as rownb
    FROM production_company prodComp, production p
    WHERE p.id = prodComp.production_id
    AND prod_year != 0
    GROUP BY company_id, prod_year
    ) tmp
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
SELECT * 
FROM PERSON 
WHERE REGEXP_LIKE(TRIVIA, 'opera singer') OR
        REGEXP_LIKE(MINI_BIOGRAPHY, 'opera singer')
ORDER BY EXTRACT(YEAR from BIRTH_DATE);
	
--m) List 10 most ambiguous credits (pairs of people and productions) ordered by the degree of ambiguity. 
--A credit is ambiguous if either a person has multiple alternative names or a production has multiple alternative titles. 
--The degree of ambiguity is a product of the number of possible names (real name + all alternatives) and the number of possible titles (real + alternatives).

--n) For each country, list the most frequent character name that appears in the productions of a production company (not a distributor) from that country.
-- first for each company, most frequent character name

WITH innerQ as (
SELECT character_id, company_id, cnt, country_code
FROM company c, (
    SELECT character_id, company_id, cnt, row_number() over (PARTITION BY company_id order by cnt desc) as rang
    FROM(
        SELECT character_id, company_id, count(*) as cnt
        FROM (
            SELECT DISTINCT pCast.production_id, character_id, company_id
            FROM test_prod_cast pCast, test_production_company pComp
            WHERE pCast.production_id = pComp.production_id AND character_id is not null
            ORDER BY company_id, production_id
            ) tmp
        GROUP BY company_id, character_id
        ORDER BY company_id, CNT DESC
        ) tmp2
    ) tmp3
WHERE RANG = 1 AND c.id = company_id
)
SELECT character_id, company_id, country_code
FROM (
  SELECT character_id, company_id, country_code, cnt, row_number() over (partition by country_code order by cnt DESC) as rang
  FROM innerQ
  ) tmp
WHERE rang = 1

--autres essais :
SELECT pCast.production_id, character_id, count(*) OVER (partition by pCast.production_id ORDER BY pCast.production_id) as cnt
FROM test_prod_cast pCast, test_production_company pComp
WHERE character_id is not null 
  AND pCast.production_id = pComp.production_id
  
  
SELECT character_id, company_id, 
count(*) OVER (PARTITION BY company_id, character_id) as cnt
FROM (
    SELECT DISTINCT pCast.production_id, character_id, company_id
    FROM test_prod_cast pCast, test_production_company pComp
    WHERE pCast.production_id = pComp.production_id
      AND character_id is not null
    ORDER BY company_id, production_id
    ) tmp
ORDER BY cnt desc
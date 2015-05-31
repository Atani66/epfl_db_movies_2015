
--a) 17.3 minutes
With innerQ as (
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
	AND a.production_id = p.id
	
--b) 11.9 secondes
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

--c) 3 secondes
SELECT COUNT(*) as nbreProd, c.name, p.genre
    FROM production p, production_company pComp, company c
    WHERE p.id = pComp.production_id 
     AND p.prod_year = 2015 
    AND pComp.company_id = c.id
    GROUP BY c.name, p.genre
    ORDER BY p.genre, nbreProd DESC
	
--d) 22.8 minutes
SELECT pid, p1.name, p1id, p2.name, p2id
FROM person p1, person p2, (
    SELECT pc1.production_id as pid, pc1.person_id as p1id, pc2.person_id as p2id
    FROM prod_cast pc1, prod_cast pc2
    WHERE pc1.person_id < pc2.person_id AND pc1.production_id = pc2.production_id
    ) tmp
WHERE p1id = p1.id AND p2id = p2.id AND p1.name = p2.name

--e) 60 secondes
SELECT prod_year, avg(cnt)
FROM (
    SELECT production_id, prod_year, count(*) as cnt
    FROM prod_cast prodCast, production prod
    WHERE prodCast.production_id = prod.id and prod_year <> 0
        AND (role LIKE 'actor' or role like 'actress')
    GROUP BY prod_year, production_id
    ORDER BY prod_year
    ) tmp
GROUP BY prod_year
ORDER BY prod_year

--f) 1.5 secondes
SELECT AVG(nbre) as NumberOfEpisodes, season
FROM (
    SELECT COUNT(*) as nbre, series_id, season_number as season
    FROM production
    WHERE season_number is not null
    GROUP BY series_id, season ) as tmp
GROUP BY season

--g) 1.22 secondes
SELECT AVG(nbreSeason)
FROM
	(SELECT COUNT(*) as nbreSeason, series_id
    FROM(
        SELECT COUNT(*), series_id, season_number
        FROM production
        WHERE kind LIKE 'episode'
        GROUP BY series_id, season_number ) as tmp
    GROUP BY series_id ) as tmp2

--h) 1.06 secondes
SELECT COUNT(*) as nbreSeason, series_id
FROM(
	SELECT series_id, season_number
	FROM production
	WHERE kind LIKE 'episode'
	GROUP BY series_id, season_number ) tmp
GROUP BY series_id
ORDER BY nbreSeason DESC
OFFSET 0 ROWS FETCH NEXT 10 ROWS ONLY

--i) 51 secondes
SELECT series_id, avg(cnt) as episodesPerSeason
FROM (
    SELECT *
    FROM (
      SELECT series_id, COUNT(*) OVER (PARTITION BY series_id, season_number ORDER BY series_id) as cnt
      FROM production
      WHERE kind LIKE 'episode'
      ) tmp
    GROUP BY series_id, CNT
    ORDER BY series_id
    ) tmp2
GROUP BY series_ID
ORDER BY episodesPerSeason DESC

--j) 44.7 secondes
SELECT p.name, prod.titlle, prod_year as ProductionYear, EXTRACT(YEAR from death_date) as deathYear
FROM person p, prod_cast prodCast, production prod
WHERE p.id = prodCast.person_id
AND prodCast.production_id = prod.id
AND (prodCast.role LIKE 'actor' or prodCast.role LIKE 'actress' or prodCast.role LIKE 'director')
AND EXTRACT(YEAR from death_date) < prod_year
GROUP BY p.name, prod.titlle, prod_year, EXTRACT(YEAR from death_date)

--k) 8.2 secondes
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
ORDER BY prod_year

--l) 21.9 secondes
SELECT * 
FROM PERSON 
WHERE REGEXP_LIKE(TRIVIA, 'opera singer') OR
        REGEXP_LIKE(MINI_BIOGRAPHY, 'opera singer')
ORDER BY EXTRACT(YEAR from BIRTH_DATE);

--m) 
???
 
--n)
WITH innerQ as (
SELECT character_id, company_id, cnt, country_code
FROM company c, (
    SELECT character_id, company_id, cnt, row_number() over (PARTITION BY company_id order by cnt desc) as rang
    FROM(
        SELECT character_id, company_id, count(*) as cnt
        FROM (
            SELECT DISTINCT pCast.production_id, character_id, company_id
            FROM prod_cast pCast, production_company pComp
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
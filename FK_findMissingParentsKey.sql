
/* Ce bout de code est utile pour trouver quelles parent keys sont manquantes dans la table de reference */


select * 
from alternative_name 
where person_id not in (select id from person)
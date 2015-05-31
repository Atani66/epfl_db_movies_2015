

CREATE TABLE Person
(	
	id VARCHAR2(20) NOT NULL,
	Name VARCHAR2(300),
	Gender VARCHAR2(5),
	Trivia VARCHAR2(2000),
	Quotes VARCHAR2(2000),
	Birth_date DATE,
	Death_date DATE,
	Birth name VARCHAR2(300),
	Mini biography VARCHAR2(2000),
	Spouse VARCHAR2(300),
	Height FLOAT,

	PRIMARY KEY(id)
)

CREATE TABLE Characters
(	
	id VARCHAR2(20) NOT NULL,
	name VARCHAR2(200),

	PRIMARY KEY(id)
)

CREATE TABLE Company
(	
	id VARCHAR2(20) NOT NULL,
	country_code VARCHAR2(20),
	name VARCHAR2(210),
	
	PRIMARY KEY(id)
)

CREATE TABLE Production
(	
	id VARCHAR2(20) NOT NULL,
	title VARCHAR2(370),
	production_year DATE,
	series_id CHAR(9), -- Here we fix the length to 9. No id will be > than 999 999 999. And it's faster than VARCHAR
	season_number CHAR(5),
	episode_number CHAR(10),
	series_years_start DATE
	series_years_end DATE
	kind VARCHAR2(30),
	genre VARCHAR2(30),
	PROD_YEAR VARCHAR2(20) -- When we don't want to extract the date for the year
	
	PRIMARY KEY(id)
)


CREATE TABLE Alternative_title
(	
	id VARCHAR2(20) NOT NULL,
	title VARCHAR2(330),
	prod_id VARCHAR2(20) NOT NULL,
	
	PRIMARY KEY (id, prod_id),
	FOREIGN KEY (prod_id) REFERENCES Production(id),
		ON DELETE CASCADE
)

CREATE TABLE Alternative_name
(	
	id VARCHAR2(20) NOT NULL,
	Name VARCHAR2(300),
	person_id VARCHAR2(20) NOT NULL,
	
	PRIMARY KEY (id, person_id),
	FOREIGN KEY (person_id) REFERENCES Person(id),
		ON DELETE CASCADE
)

CREATE TABLE Production_cast
(	
	ID NUMBER NOT NULL, --auto increments and is our SURROGATE KEY for this table
	production_id VARCHAR2(20) NOT NULL,
	person_id VARCHAR2(20) NOT NULL
	character_id VARCHAR2(20),
	role VARCHAR2(20) NOT NULL,
	
	PRIMARY KEY (ID),
	FOREIGN KEY (production_id) REFERENCES Production,
	FOREIGN KEY (person_id) REFERENCES Person,
	FOREIGN KEY (character_id) REFERENCES Characters
)

CREATE TABLE Production_company
(	
	production_id VARCHAR2(20) NOT NULL,
	company_id VARCHAR2(20) NOT NULL,
	kind VARCHAR2(50),
	ID VARCHAR2(20) NOT NULL
	
	PRIMARY KEY (ID),
	FOREIGN KEY (production_id) REFERENCES Production,
	FOREIGN KEY (company_id) REFERENCES Company	
	
)

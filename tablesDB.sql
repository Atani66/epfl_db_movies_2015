

CREATE TABLE Person
(	
	id VARCHAR(20) NOT NULL,
	Name VARCHAR(100),
	Gender VARCHAR(5),
	Trivia VARCHAR(255),
	Quotes VARCHAR(255),
	Birth_date DATE,
	Death_date DATE,
	Birth name VARCHAR(255),
	Mini biography TEXT,
	Spouse VARCHAR(100),
	Height VARCHAR(5),

	PRIMARY KEY(id)
)

CREATE TABLE Characters
(	
	id VARCHAR(20) NOT NULL,
	name VARCHAR(100),

	PRIMARY KEY(id)
)

CREATE TABLE Company
(	
	id VARCHAR(20) NOT NULL,
	country_code VARCHAR(10),
	name VARCHAR(50),
	
	PRIMARY KEY(id)
)

CREATE TABLE Production
(	
	id VARCHAR(20) NOT NULL,
	title VARCHAR(100),
	production_year CHAR(4),
	series_id CHAR(9), -- Here we fix the length to 9. No id will be > than 999 999 999. And it's faster than VARCHAR
	season_number CHAR(2),
	episode_number CHAR(4),
	series_years VARCHAR(10),
	kind CHAR(10),
	genre VARCHAR(20),
	
	PRIMARY KEY(id)
)


CREATE TABLE Alternative_title
(	
	id VARCHAR(20) NOT NULL,
	title VARCHAR(50),
	prod_id VARCHAR(20) NOT NULL,
	
	PRIMARY KEY (id, prod_id),
	FOREIGN KEY (prod_id) REFERENCES Production(id),
		ON DELETE CASCADE
)

CREATE TABLE Alternative_name
(	
	id VARCHAR(20) NOT NULL,
	Name VARCHAR(50),
	person_id VARCHAR(20) NOT NULL,
	
	PRIMARY KEY (id, person_id),
	FOREIGN KEY (person_id) REFERENCES Person(id),
		ON DELETE CASCADE
)

CREATE TABLE Production_cast
(	
	production_id VARCHAR(20) NOT NULL,
	person_id VARCHAR(20),
	character_id VARCHAR(20),
	role VARCHAR(20),
	
	PRIMARY KEY (production_id, person_id, character_id),
	FOREIGN KEY (production_id) REFERENCES Production,
	FOREIGN KEY (person_id) REFERENCES Person,
	FOREIGN KEY (character_id) REFERENCES Characters
)

CREATE TABLE Production_company
(	
	production_id VARCHAR(20),
	company_id VARCHAR(20),
	kind VARCHAR(50),
	
	PRIMARY KEY (production_id, company_id),
	FOREIGN KEY (production_id) REFERENCES Production,
	FOREIGN KEY (company_id) REFERENCES Company	
	
)
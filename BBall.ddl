-- #Drop and Create the database
DROP DATABASE IF EXISTS cpsc431_final;
CREATE DATABASE IF NOT EXISTS cpsc431_final;

-- #Drop and create user
DROP USER IF EXISTS 'db_admin'@'localhost';
GRANT SELECT, INSERT, DELETE, UPDATE, EXECUTE ON cpsc431_final.* TO 'db_admin'@'localhost' IDENTIFIED BY 'password123';

USE cpsc431_final;

-- #Create Teams Table
CREATE TABLE teams(
	Team_ID			INT 					NOT NULL 		AUTO_INCREMENT 		PRIMARY KEY,
	Team_Name 	VARCHAR(100) 	UNIQUE
);

-- #Create People Table
CREATE TABLE people(
	Person_ID		INT 					NOT NULL 	  AUTO_INCREMENT 	PRIMARY KEY,
	Name_First 	VARCHAR(100),
	Name_Last 	VARCHAR(100) 	NOT NULL,
	Email 			VARCHAR(100) 	UNIQUE,
	Street 			VARCHAR(250),
	City 				VARCHAR(100),
	State 			VARCHAR(100),
	Country 		VARCHAR(100),
	ZipCode 		CHAR(10),

	CONSTRAINT CHECK(ZipCode REGEXP '(?!0{5})(?!9{5})\d{5}(-(?!0{4})(?!9{4})\d{4})?')
);

-- #Create Games TABLE
CREATE TABLE games(
	Game_ID				INT						NOT NULL 		 	AUTO_INCREMENT 		PRIMARY KEY,
	Date_Played		DATE					NOT NULL,
	Team_One 			INT,
	Team_Two			INT,

	FOREIGN KEY (Team_One) REFERENCES teams(Team_ID),
	FOREIGN KEY (Team_Two) REFERENCES teams(Team_ID)
);

-- #Create Scores Table
CREATE TABLE scores(
	Game_ID				INT,
	Team_ID				INT,
	Score					INT,

	FOREIGN KEY (Team_ID) REFERENCES teams(Team_ID),
	FOREIGN KEY (Game_ID) REFERENCES games(Game_ID)
);

-- #Create Statistics TABLE
CREATE TABLE statistics(
	Player_ID				INT,
	Game_ID					INT,
	Points	 				TINYINT(3) 			DEFAULT 0,
	Assists 				TINYINT(3) 			DEFAULT 0,
	Rebounds 				TINYINT(3) 			DEFAULT 0,
	PlayingTimeMin 	TINYINT(2)			DEFAULT 0,
	PlayingTimeSec 	TINYINT(2)			DEFAULT 0,

	CHECK((PlayingTimeMin < 40 AND PlayingTimeSec < 60) OR (PlayingTimeMin = 40 AND PlayingTimeSec = 0 )),
	FOREIGN KEY (Player_ID) REFERENCES people(Person_ID),
	FOREIGN KEY (Game_ID) REFERENCES games(Game_ID)
);

-- #Create Player Table
CREATE TABLE players(
	Player_ID INT,
	Team_ID	  INT,

	FOREIGN KEY (Player_ID) REFERENCES people(Person_ID),
	FOREIGN KEY (Team_ID) REFERENCES teams(Team_ID)
);

-- #Create Coach Table
CREATE TABLE coaches(
	Coach_ID INT,
	Team_ID	 INT,

	FOREIGN KEY (Coach_ID) REFERENCES people(Person_ID),
	FOREIGN KEY (Team_ID) REFERENCES teams(Team_ID)
);

-- #Create Accounts TABLE
CREATE TABLE accounts(
	Account_ID 		INT						NOT NULL			AUTO_INCREMENT 			PRIMARY KEY,
	Person_ID			INT,
	Password			VARCHAR(100)	NOT NULL,
	Hash					VARCHAR(32)		NOT NULL,
	Role					ENUM('Observer', 'User', 'Manager', 'Admin'),

	FOREIGN KEY (Person_ID) REFERENCES people(Person_ID)
);

CREATE TABLE CourseRecords
(
	CourseRecordId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	CourseCode CHAR(7) NOT NULL,
	CourseIdRecord TEXT,
	PRIMARY KEY (CourseRecordId),
	CONSTRAINT OneRecordPerCourse UNIQUE (CourseCode)
);
CREATE TABLE DepartmentRecords
(
  DeptRecordId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  DeptId INT UNSIGNED NOT NULL,
  DeptCourseNameRecord TEXT,
  DeptCourseCodeRecord TEXT,
  PRIMARY KEY (DeptRecordId)
);
CREATE TABLE Departments
(
	DeptId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	Abbr CHAR(3),
	DeptCode CHAR(4) NOT NULL,
	ChName VARCHAR(255) CHARSET utf8 NOT NULL,
	EnName VARCHAR(255),
	PRIMARY KEY (DeptId)
);
CREATE INDEX SearchDeptCode ON Departments(DeptCode);
CREATE TABLE Teachers
(
  TeacherId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  DeptId INT UNSIGNED NOT NULL,
  ChName VARCHAR(255) CHARSET utf8,
  EnName VARCHAR(255),
  Description TEXT,
  PRIMARY KEY (TeacherId),
  FOREIGN KEY (DeptId) REFERENCES Departments(DeptId)
);
CREATE TABLE Courses
(
	CourseId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	SerialNo SMALLINT UNSIGNED NOT NULL,
	CourseCode CHAR(7) NOT NULL,
	AcadmYear TINYINT UNSIGNED NOT NULL,
	AcadmTerm TINYINT UNSIGNED NOT NULL,
	ChName VARCHAR(255) CHARSET utf8 NOT NULL,
	EnName VARCHAR(255) NOT NULL,
	TeacherId INT UNSIGNED NOT NULL,
	CourseGroup CHAR(1) NOT NULL,
	ClassCode CHAR(1) NOT NULL,
	Duration CHAR(1) NOT NULL,
	Credit FLOAT NOT NULL,
	DeptId INT UNSIGNED NOT NULL,
	DeptGroup CHAR(1) NOT NULL,
	IsEngTeach BOOL DEFAULT 0 NOT NULL,
	Grade CHAR(1) NOT NULL,
	GenderRestrict CHAR(1) NOT NULL,
	IsMOOC BOOL DEFAULT 0 NOT NULL,
	IsElective CHAR(1) NOT NULL,
	RestrictInfo VARCHAR(255) CHARSET utf8,
	RemoteTeach BOOL DEFAULT 0 NOT NULL,
	selfTeachName VARCHAR(255) CHARSET utf8,
	ChLocation VARCHAR(255) CHARSET utf8 NOT NULL,
	EnLocation VARCHAR(255) CHARSET utf8,
	TimeInfo VARCHAR(255) CHARSET utf8 NOT NULL,
	StatusInfo BOOL DEFAULT 0 NOT NULL,
	ChComment VARCHAR(255) CHARSET utf8,
	EnComment  VARCHAR(255),
	AuthMaxSize TINYINT UNSIGNED NOT NULL,
	AuthRate FLOAT NOT NULL,
	NTAMaxSize TINYINT UNSIGNED NOT NULL,
	TotalMaxSize TINYINT UNSIGNED NOT NULL,

	Hour TINYINT UNSIGNED,
	Description TEXT,

	FmReserve TINYINT UNSIGNED,
	Enrolled TINYINT UNSIGNED,
	Assigned TINYINT UNSIGNED,
	Unassigned TINYINT UNSIGNED,
	AuthAssigned TINYINT UNSIGNED,
	ExAssigned TINYINT UNSIGNED,
	PtAssigned TINYINT UNSIGNED,

	PRIMARY KEY (CourseId),
	FOREIGN KEY (TeacherId) REFERENCES Teachers(TeacherId),
	FOREIGN KEY (DeptId) REFERENCES Departments(DeptId)
);
CREATE INDEX SearchCode ON Courses(CourseCode);
CREATE INDEX SearchSerial ON Courses(SerialNo);
CREATE INDEX SearchYear ON Courses(AcadmYear);
CREATE INDEX SearchTerm ON Courses(AcadmTerm);
CREATE TABLE Users
(
  UserId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  FBId BIGINT UNSIGNED NOT NULL,
  UserName VARCHAR(255) CHARSET utf8 NOT NULL,
  Gender VARCHAR(255) NOT NULL,
  Locale VARCHAR(255) NOT NULL,
  PRIMARY KEY (UserId)
);
CREATE UNIQUE INDEX SearchFBId ON Users(FBId);
CREATE TABLE Votes
(
	VoteId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	CourseId INT UNSIGNED NOT NULL,
	Decision BOOL NOT NULL,
	UserId INT UNSIGNED NOT NULL,
	VoteTime TIMESTAMP NOT NULL,
	PRIMARY KEY (VoteId),
	FOREIGN KEY (CourseId) REFERENCES Courses(CourseId),
	FOREIGN KEY (UserId) REFERENCES Users(UserId),
	CONSTRAINT OneVotePerUser UNIQUE (CourseId, UserId)
);
CREATE UNIQUE INDEX SearchCourse ON Votes(CourseId);
CREATE UNIQUE INDEX SearchUser ON Votes(UserId);

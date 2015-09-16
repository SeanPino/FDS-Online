CREATE TABLE Jobs
(	JobId int PRIMARY KEY,
	UploadedFileName varchar(200) NOT NULL,
	UploadedTime text NOT NULL,
	Status int NOT NULL,
	FOREIGN KEY(status) references Statuses(StatusId)
)

CREATE TABLE Statuses
(
	StatusId int PRIMARY KEY,
	StatusName varchar(50) UNIQUE NOT NULL,
	StatusDescription varchar(200) NOT NULL
)


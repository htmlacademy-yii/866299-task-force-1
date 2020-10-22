CREATE DATABASE taskforce
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE taskforce;

/*
Таблица с прекрипленными к задаче файлами
*/
CREATE TABLE TaskFiles (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    FilePath VARCHAR(128) NOT NULL,
    FileTitle VARCHAR(128) NOT NULL 
);

/*
Таблица содержит все доступные для задач категории
*/
CREATE TABLE AvailableСategories (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Category VARCHAR(128) NOT NULL,
    CategoryIcon VARCHAR(128) NOT NULL
);

/*
Все доступные города
*/
CREATE TABLE Cities (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    City VARCHAR(128) NOT NULL
);

/*
Содержит фото работ исполнителей
*/
CREATE TABLE Portfolios (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    PortfolioPath VARCHAR(128) NOT NULL
);


/*
Таблица пользователей, содержит информацию о пользователях
*/
CREATE TABLE Users (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    RegistrationDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    Email VARCHAR(128) NOT NULL,
    UserName VARCHAR(128) NOT NULL,
    UserCityID INT UNSIGNED NOT NULL,
    UserPassword VARCHAR(128) NOT NULL,
    UserAvatar VARCHAR(128),
    UserDescription VARCHAR(512),
    UserBirthday DATETIME,
    UserPhone VARCHAR(128),
    UserSkype VARCHAR(128),
    UserTelegram VARCHAR(128),
    ShowProfile BOOLEAN DEFAULT 0,
    NewMessageNotification BOOLEAN DEFAULT 1,
    TaskActionsNotification BOOLEAN DEFAULT 1,
    NewFeedbackNotification BOOLEAN DEFAULT 1,
    ShowProfileOnlyToClien BOOLEAN DEFAULT 0,

    FOREIGN KEY (UserCityId) REFERENCES Cities (Id)
);

/*
Таблица с задчами, содержит всю информацию о задаче.
*/
CREATE TABLE tasks (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    CreationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Title VARCHAR(128) NOT NULL,
    TaskDescription VARCHAR(256),
    Budget INT UNSIGNED,
    Deadline TIMESTAMP,
    CategotyId INT UNSIGNED NOT NULL,
    OwnerId INT UNSIGNED NOT NULL,
    CityId INT UNSIGNED,
    Coordinates VARCHAR(128),

    FOREIGN KEY (CategotyId) REFERENCES AvailableСategories (Id),
    FOREIGN KEY (OWnerId) REFERENCES Users (Id),
    FOREIGN KEY (CityId) REFERENCES Cities (Id)
);

/*
Таблица содержит отношение прикрепленных файлов к задаче
*/
CREATE TABLE FilesToTask (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    FileId INT UNSIGNED NOT NULL,
    TaskId INT UNSIGNED NOT NULL,

    FOREIGN KEY (FileId) REFERENCES TaskFiles (Id),
    FOREIGN KEY (TaskId) REFERENCES tasks (Id)
);

/*
Таблица содержит все доступные специализации для пользователей
*/
CREATE TABLE AvailableSpecialization (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Specialization VARCHAR(128) NOT NULL
);

/*
Таблица содержит информацию о том какие специализации выбрали исполнители
*/
CREATE TABLE SpecializationToUser (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    SpecializationId INT UNSIGNED NOT NULL,
    UserId INT UNSIGNED NOT NULL,

    FOREIGN KEY (SpecializationId) REFERENCES AvailableSpecialization (Id),
    FOREIGN KEY (UserId) REFERENCES Users (Id)
);


/*
Определяет соответствие фото выполненой работы с пользовотелем
*/
CREATE TABLE PortfolioToUser (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    PortfolioId INT UNSIGNED NOT NULL,
    UserId INT UNSIGNED NOT NULL,

    FOREIGN KEY (PortfolioId) REFERENCES Portfolios (Id),
    FOREIGN KEY (UserId) REFERENCES Users (Id)
);

/*
Таблица с отзывами о проделаной работе
*/

CREATE TABLE Feedbacks (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Feedback VARCHAR(256) NOT NULL,
    Rate INT UNSIGNED NOT NULL,
    UserWhoId INT UNSIGNED NOT NULL,
    UserToId INT UNSIGNED NOT NULL,

    FOREIGN KEY (UserWhoId) REFERENCES Users (Id),
    FOREIGN KEY (UserToId) REFERENCES Users (Id) 
);


/*
Таблица содержит отклик на задачу
*/
CREATE TABLE Responses (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ResponseDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ResponseDescription VARCHAR(256),
    ResponsePrice INT UNSIGNED,
    UserWhoId INT UNSIGNED NOT NULL,
    TaskId INT UNSIGNED NOT NULL,

    FOREIGN KEY (UserWhoId)  REFERENCES Users (id),
    FOREIGN KEY (TaskId)  REFERENCES tasks (id)
);

/*
Таблица сообщений
*/
CREATE TABLE Messages (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    message_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    content VARCHAR(512) NOT NULL,

    UserWhoId INT UNSIGNED NOT NULL,
    UserToId INT UNSIGNED NOT NULL,

    FOREIGN KEY (UserWhoId) REFERENCES Users (Id),
    FOREIGN KEY (UserToId) REFERENCES Users (Id) 
);
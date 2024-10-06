-- drop database mb_v1;

CREATE DATABASE mb_v1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

use mb_v1; 

create table accounts(
	id int unsigned primary key auto_increment,
    fullName varchar(50),
    email varchar(100) unique,
    pass varchar(50),
    roles TINYINT unsigned,
    createdAt timestamp default current_timestamp,
    statuss tinyint unsigned,
    avatar text
);

create table courses(
	id int unsigned primary key auto_increment,
    courseName varchar(255),
	createdAt timestamp default current_timestamp
);

create table lessons(
	id int unsigned primary key auto_increment,
    lessonName text,
    idCourses int unsigned,
    createdAt timestamp default current_timestamp,
    foreign key(idCourses) references courses(id)
);

create table quizzesCMS(
	id int unsigned primary key auto_increment,
    title varchar(255),
    createdAt timestamp default current_timestamp,
    idLessons int unsigned,
    foreign key(idLessons) references lessons(id)
);

create table mediaCMS(
	id int unsigned primary key auto_increment,
    title varchar(255),
    idQuizzesCMS int unsigned unique,
    type TINYINT,
    content text,
    foreign key(idQuizzesCMS) references quizzesCMS(id) on delete cascade
);

create table questionsCMS(
	id int unsigned primary key auto_increment,
    questionName text,
    typeAnswers TINYINT,
    idQuizzesCMS int unsigned,
    foreign key(idQuizzesCMS) references quizzesCMS(id) on delete cascade
);

create table answersCMS(
	id int unsigned primary key auto_increment,
    answerName text,
    isCorrect Boolean default false,
    idQuestionsCMS int unsigned,
    foreign key(idQuestionsCMS) references questionsCMS(id) on delete cascade
);

create table classes(
	id int unsigned primary key auto_increment,
    className varchar(255),
    statuss tinyint unsigned,
    idCourses int unsigned,
    foreign key(idCourses) references courses(id)
);

create table accounts_classes(
	idAccounts int unsigned,
    idClasses int unsigned,
    statuss tinyint,
    primary key(idAccounts,idClasses),
    foreign key(idAccounts) references accounts(id) on delete cascade,
    foreign key(idClasses) references classes(id) on delete cascade
);

create table resultsCMS(
	id int unsigned primary key auto_increment,
    score float,
    idAccounts int unsigned,
    idQuizzesCMS int unsigned,
    idClasses int unsigned, 
    foreign key(idAccounts) references accounts(id) on delete cascade,
    foreign key(idQuizzesCMS) references quizzesCMS(id) on delete cascade,
    foreign key(idClasses) references classes(id) on delete cascade
);

create table results_details_CMS(
id int unsigned primary key auto_increment,
userAnswer varchar(255),
isCorrect Boolean default false,
idResultsCMS int unsigned,
idQuestionsCMS int unsigned,
idAnswersCMS int unsigned,
foreign key(idResultsCMS) references resultsCMS(id) on delete cascade,
foreign key(idQuestionsCMS) references questionsCMS(id) on delete cascade,
foreign key(idAnswersCMS) references answersCMS(id) on delete cascade
);












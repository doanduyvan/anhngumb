
-- insert tài khoản 
use mb_v1;
insert into accounts (fullName,email,pass,roles,statuss) values
( 'nguyen van a', 'nguyenvana@gmail.com', '123',0,1 ),
( 'nguyen van b', 'nguyenvanb@gmail.com', '123',0,1 ),
( 'nguyen van c', 'nguyenvanc@gmail.com', '123',1,1 ),
( 'nguyen van d', 'nguyenvand@gmail.com', '123',0,1 ),
( 'nguyen van e', 'nguyenvane@gmail.com', '123',0,0 ),
( 'nguyen van f', 'nguyenvanf@gmail.com', '123',0,0 ),
( 'Duy Van', 'duyvan@gmail.com', '123',2,1 ),
( 'Ngoc Tam', 'tam@gmail.com', '123',2,1 );

-- insert khoa hoc 
insert into courses(courseName) values 
('Nền Tảng A1'),
('Nền Tảng A2'),
('Nền Tảng A3'),
('Trung Cấp A1'),
('Trung Cấp A2'),
('Trung Cấp A3');

-- insert lassons ( unit cua khoa hoc );

insert into lessons(lessonName,idCourses) values
('Unit 1: nen tang a1',1),
('unit 2: nen tang a1',1 ),
('Unit 3: nen tang a1',1),
('unit 4: nen tang a1',1 ),
('Unit 1: nen tang a1',2),
('unit 2: nen tang a2',2 ),
('Unit 3: nen tang a2',2),
('unit 4: nen tang a2',2 );

-- insert class

insert into classes(className,statuss,idCourses) values
('K198',1,1),
('K199',1,1),
('F198',1,2),
('F199',1,2),
('V198',0,1),
('V199',0,1);

-- insert thanh vien lop hoc va giang vien

insert into accounts_classes (idAccounts,idClasses,statuss) values
(1,1,0),
(2,1,1),
(3,1,1),
(3,2,1),
(3,5,1);



select * from courses;










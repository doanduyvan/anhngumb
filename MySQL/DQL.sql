use mb_v1;
-- select * from accounts where id = 3;

-- select * from classes as cl
-- inner join accounts_classes on idclasses = cl.id where cl.id = ;


insert into accounts(fullname,email,pass,roles,statuss) values
('duyvan12355555','duyvan123123@gmail.com','123','0',0);

insert into courses(courseName) values 
('Nền Tảng A1'),
('Nền Tảng A2'),
('Nền Tảng A3'),
('Trung Cấp A1'),
('Trung Cấp A2'),
('Trung Cấp A3');


select * from accounts limit 20 offset 2;
SELECT COUNT(*) FROM accounts;
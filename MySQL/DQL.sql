use mb_v1;
-- select * from accounts where id = 3;

-- select * from classes as cl
-- inner join accounts_classes on idclasses = cl.id where cl.id = ;





select * from accounts; 
SELECT COUNT(*) FROM accounts;


-- lọc tài khoản tất cả lớp
select acc.id, acc.fullName, acc.roles, acc.statuss, acc.createdAt,  acc.avatar, cl.statuss as clstt, cl.className from accounts as acc
left join accounts_classes as accl on acc.id = accl.idAccounts
left join classes cl on cl.id = accl.idClasses limit 5 offset;

select * from accounts_classes;


SELECT 
    acc.id, 
    acc.fullName, 
    acc.roles, 
    acc.statuss, 
    acc.createdAt,  
    acc.avatar, 
    GROUP_CONCAT(CASE WHEN cl.statuss = 1 THEN cl.className END SEPARATOR ', ') AS className
FROM 
    accounts AS acc
LEFT JOIN 
    accounts_classes AS accl ON acc.id = accl.idAccounts
LEFT JOIN 
    classes cl ON cl.id = accl.idClasses
GROUP BY 
    acc.id;

-- tim kiem bang email 

select acc.id, acc.fullName, acc.email, acc.roles, acc.statuss, acc.createdAt,  acc.avatar, GROUP_CONCAT(CASE WHEN cl.statuss = 1 THEN cl.className END SEPARATOR ', ') AS className from accounts as acc
        left join accounts_classes as accl on acc.id = accl.idAccounts
        left join classes cl on cl.id = accl.idClasses
        where email like "%ta%"
        group by acc.id order by id desc;
        
        
-- lay bai hoc theo khoa hoc

select * from lessons where idCourses = 1;
        
        
-- sql quiz

select * from quizzescms
left join mediacms on quizzescms.id = mediacms.idQuizzescms
join questionscms as qtcms on qtcms.idQuizzescms = quizzescms.id
join answersCMS as ans on qtcms.id = ans.idQuestionsCMS order by quizzescms.id desc;

select * from accounts_classes as ac
inner join accounts a on a.id = ac.idAccounts;


select acc.id, acc.fullName, acc.email, acc.roles, acc.statuss, acc.createdAt,  acc.avatar, GROUP_CONCAT(CASE WHEN cl.statuss = 1 AND accl.statuss = 1 THEN cl.className END SEPARATOR ', ') AS className from accounts as acc
        left join accounts_classes as accl on acc.id = accl.idAccounts
        left join classes cl on cl.id = accl.idClasses 
        GROUP BY acc.id 
        ORDER BY acc.id DESC 
        LIMIT 20 
        OFFSET 0;


select * from accounts_classes;
select * from accounts;
select * from classes;

insert into accounts_classes (idAccounts,idClasses,statuss) values (11,2,1);

-- lấy danh sách class của 1 người dùng

select c.className, c.idCourses as idCourse from classes c 
inner join accounts_classes ac on c.id = ac.idClasses
where ac.idAccounts = 11 and ac.statuss = 1;

-- lấy danh sách các unit của 1 người dùng và của 1 class

select le.lessonName, le.id as idLesson from lessons as le
inner join courses as co on co.id = le.idCourses
inner join classes as cl on co.id = cl.idCourses
inner join accounts_classes as ac on cl.id = ac.idClasses
where ac.idAccounts = 11 and ac.statuss = 1 and cl.id = 1;
        
        
-- lấy các quiz và điểm số
-- đầu vào, id lesson
        
select cl.className, le.lessonName, qu.title, qu.id as idQuiz, re.score from quizzescms as qu
inner join lessons as le on le.id = qu.idLessons
inner join courses as co on co.id = le.idCourses
inner join classes as cl on co.id = cl.idCourses
inner join accounts_classes as ac on ac.idClasses = cl.id
left join resultscms as re on re.idClasses = cl.id and re.idQuizzesCMS = qu.id
where ac.idAccounts = 11 and cl.id = 2 and qu.idLessons = 1;

select * from resultscms;

-- lấy quiz và điểm

select
 cla.id as idClass,
 cla.className, 
 les.id as idLesson, 
 les.lessonName, 
 qui.id as idQuiz,
 qui.title as quizName, 
 res.score, 
med.title as medtitle,
med.type as medtype,
med.content as medcontent
 from quizzescms as qui
inner join questionscms as que on que.idQuizzesCMS = qui.id
inner join answerscms as ans on ans.idQuestionsCMS = que.id
inner join lessons as les on les.id = qui.idLessons
inner join courses as cou on cou.id = les.idCourses
inner join classes as cla on cla.idCourses = cou.id
inner join accounts_classes as ac on ac.idClasses = cla.id
left join resultscms as res on res.idClasses = cla.id
left join mediacms as med on med.idQuizzesCMS = qui.id
where qui.id = 148 and les.id = 1 and cla.id = 2 and ac.idAccounts = 11;

select * from quizzescms;


select
cla.id as idClass,
cla.className,
les.id as idLesson,
les.lessonName,
qui.id as idQuiz,
qui.title as quizName	
from quizzescms as qui
inner join lessons as les on les.id = qui.idLessons
inner join courses as cou on cou.id = les.idCourses
inner join classes as cla on cla.idCourses = cou.id
inner join accounts_classes as ac on ac.idClasses = cla.id
where qui.id = 148 and les.id = 1 and cla.id = 2 and ac.idAccounts = 11;

select m.title, m.type, m.content from mediacms as m where idQuizzesCMS = 148;

-- lấy tổng số quiz của 1 lesson

select count(qui.id) as totalQuiz from quizzescms as qui where qui.idLessons = 1;

select sum(res.score) as totalScore from resultscms as res 
inner join quizzescms as qui on qui.id = res.idQuizzesCMS
inner join lessons as les on les.id = qui.idLessons
where res.idAccounts = 11 and res.idClasses = 2 and les.id = 1 ;

-- truy vấn câu hỏi và câu trả lời 

select que.id as idQuestion,
 que.questionName,
 que.typeAnswers as type,
 ans.id as idAnswer,
 ans.answerName,
 ans.isCorrect
 from questionscms as que
inner join answerscms as ans on ans.idQuestionsCMS = que.id
where que.idQuizzesCMS = 148;

-- lấy tất cả các lớp đang hoạt động bởi khóa học

select * from classes where idCourses = 1 and statuss = 1 order by id desc;

-- lấy class detail

select co.courseName, cl.className, cl.id as idClass, ac.* from classes as cl
inner join courses as co on co.id = cl.idCourses
left join accounts_classes as ac on cl.id = ac.idClasses
where cl.statuss = 1 and co.id = 1;

-- kiểm tra đã có trong lớp chưa

select * from accounts_classes as ac 
where ac.idAccounts = 11;

-- lấy class 1 người đã join vào

select co.courseName, cl.className, cl.id as idClass from classes as cl
inner join courses as co on co.id = cl.idCourses
left join accounts_classes as ac on cl.id = ac.idClasses
where ac.idAccounts = 11 and ac.statuss = 1;

-- đếm số lượng thành viên của mỗi lớp

select count(ac.idAccounts) as members from accounts_classes as ac
where ac.idClasses = 1 and ac.statuss = 1;

select * from resultscms;



update accounts_classes as ac set statuss = 1
where ac.idAccounts in (4,4,5) and ac.idClasses in (4,6,6);

        
        
        
        
        


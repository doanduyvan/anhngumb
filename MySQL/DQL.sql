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

select * from quizzescms order by id desc;



        
        
        
        
        
        
        
        


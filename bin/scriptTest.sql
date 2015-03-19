#Quincy Schurr

Create database StudyNetwork;
Use StudyNetwork;

Create table StudyGroups (gid int, cid int, creator_id int, gname varchar(30), time1 TIME, loc varchar (20), num_members int);
Create table Classes (cid int, dept varchar(6), class_num int, time2 TIME, professor varchar(30));
Create table ClassEnroll (cid int, uid int);
Create table GroupEnroll (uid int, gid int, role varchar(20));
Create table Users (uid int, f_name varchar(30), l_name varchar(30), email varchar(45), passwd varchar(64));
Create table Profile (uid int, org_id int, gid int, cid int);
Create table OrgEnroll (org_id int, uid int);
Create table Organizations (org_id int, org_name varchar (50));

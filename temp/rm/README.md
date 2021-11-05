# Jan Framework
$ php -S localhost:8000 -t public -d display_errors=1

GIT
echo "# janklodev" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin git@github.com:jeandev84/janklodev.git
git push -u origin main


MYSQL
$ mysql -uroot
$ create database janklodev;
$ use mysql;
$ select * from  user;

Fix the permission setting of the root user ;
mysql> use mysql;
Database changed
mysql> select * from  user;
Empty set (0.00 sec)
mysql> truncate table user;
Query OK, 0 rows affected (0.00 sec)
mysql> flush privileges;
Query OK, 0 rows affected (0.01 sec)
mysql> grant all privileges on *.* to root@localhost identified by 'YourNewPassword' with grant option;
Query OK, 0 rows affected (0.01 sec)


*if you don`t want any password or rather an empty password
mysql> grant all privileges on *.* to root@localhost identified by '' with grant option;
Query OK, 0 rows affected (0.01 sec)*
mysql> flush privileges;
Query OK, 0 rows affected (0.00 sec)

mysql> select host, user from user;


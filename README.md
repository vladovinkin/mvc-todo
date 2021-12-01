# php-framework
Simple PHP OOP framework based on mvc

small run project guide:

(I hope you already have an php, mysql, composer, nginx (or apache) installed)

1. unpack project

2. in your database create schema 'mvc'

3. change the settings in application/config/db.php to yours

4. go to root project folder

5. run 'composer update' for install libraries

6. run 'php migrate/run.php' for initialize database

7. set up nginx or apache to this folder, and put host name to hosts file

8. enjoy!
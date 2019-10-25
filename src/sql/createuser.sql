create user 'taskforce'@'localhost' identified with mysql_native_password by 'taskforce';

grant all on taskforce.* to 'taskforce'@'localhost';

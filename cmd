# 启动mysql容器
docker run --name mysql-server -v "$PWD"/dbdata:/var/lib/mysql -d -e MYSQL_ROOT_PASSWORD=root hub.c.163.com/library/mysql
# 启动php-apache容器
docker run --name apache --link mysql-server -v "$PWD"/server:/var/www/html -p 80:80 -d hub.c.163.com/library/php:7.1.7-apache
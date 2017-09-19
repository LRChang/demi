# 启动mysql容器
# docker run --name mysql-server -v "$PWD"/dbdata:/var/lib/mysql -d -e MYSQL_ROOT_PASSWORD=root hub.c.163.com/library/mysql:5.7.18
# 启动php-apache容器
# docker run --name apache --link mysql-server -v "$PWD"/server:/var/www/html -p 80:80 -d hub.c.163.com/library/php:7.1.7-apache
# 启动带xdebug的php-apache容器
# docker run --name server-dev -v "$PWD"/server:/var/www/html -p 80:80  -e XDEBUG_CONFIG="remote_host=192.168.1.102" --link mysql-server -d server-dev

# 获取镜像
docker pull hub.c.163.com/library/mysql:5.7.18
docker pull hub.c.163.com/library/php:7.1.7-apache

# 请切换到当前目录

# 构建镜像
docker build -t webserver ./docker/
docker build -t database ./docker/mysql/

# 启动mysql
docker run --name mydata -v "$PWD"/mysql:/var/lib/mysql -p 3306:3306 -d -e MYSQL_ROOT_PASSWORD=root database

# 启动php-apache
docker run --name myserver -v "$PWD"/src:/var/www/html -p 8080:80  -e XDEBUG_CONFIG="remote_host=192.168.1.102" -d webserver


# ============================================================ # Dockerfile — PHP Employee Management System # Beginner Version — Every line explained below # ============================================================       # LINE 1 — START FROM A READY-MADE BASE # Instead of installing PHP and Apache from scratch, # we start from an image that already has both. # php:8.1-apache = PHP version 8.1 + Apache web server included. FROM php:8.1-apache       # LINE 2 — ADD MYSQL SUPPORT TO PHP # PHP cannot talk to MySQL by default. # This command installs the mysqli extension # which is the PHP plugin your db.php file uses. RUN docker-php-ext-install mysqli       # LINE 3 — COPY YOUR PHP FILES INTO THE CONTAINER # Your PHP files need to be inside the container. # COPY takes files from your server and puts them inside. # # Left side  ( . )  = current folder on your EC2 server # Right side ( /var/www/html/ ) = where Apache looks for files inside the container COPY . /var/www/html/
 
FROM php:8.1-apache
RUN docker-php-ext-install mysqli
COPY . /var/www/html/
EXPOSE 80

# PHP-Store-Website

## Overview
This project is a mock bookstore website I created around 2019 to learn PHP and web development. It reflects my early coding skills and was a hands-on way to explore some concepts.

### Note
This code is not indicative of my current standards or practices; it was developed when I was new to PHP. Despite the code quality, the website has a simple yet cool design.

## Getting Started
Follow these instructions to get the project up and running on an Ubuntu 20.04 system.

### Prerequisites
- Ubuntu 20.04
- MySQL Server
- Apache2
- PHP

### Installation
1. Update your package list and install the necessary packages:
    ```sh
    sudo apt update && sudo apt -y install mysql-server apache2 php php-mysqli
    ```

2. Configure MySQL root user with a new password:
    ```sh
    sudo mysql -u root -p -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH caching_sha2_password BY 'NEW_MYSQL_ROOT_PASSWORD';"
    ```

3. Configure MySQL database:
    ```sh
    sudo mysql -u root -pNEW_MYSQL_ROOT_PASSWORD < Store.sql
    ```

4. Upload the contents of the 'Store' folder to the web server's root directory:
    ```sh
    sudo rm /var/www/html/index.html && sudo cp -r Store/* /var/www/html/
    ```

5. Set the correct permissions for the web server to access the files:
    ```sh
    sudo chown -R www-data:www-data /var/www/html
    ```

6. Edit the configuration file to set up your environment (e.g., database settings):
    ```sh
    sudo nano /var/www/html/configarray.php
    ```

7. Access the admin panel to manage the bookstore:
    ```sh
    http://<server-ip>/admin.php
    ```

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

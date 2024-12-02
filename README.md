# Laravel Application Deployment Instructions

## Overview
This guide outlines the steps to deploy a Laravel application on an Amazon Linux 2023 instance with Nginx and MariaDB. It ensures proper initialization, installation of dependencies, and configuration for the Laravel application.

---

## Prerequisites
1. **Amazon Linux 2023 Instance**:
    - Ensure the EC2 instance is running Amazon Linux 2023.
    - Attach a security group that allows access to HTTP (port 80), HTTPS (port 443), and SSH (port 22).

2. **Domain Configuration**:
    - Point the domain’s DNS to the public IP of the EC2 instance.

3. **Access**:
    - SSH into the instance using the appropriate key pair.

---

## Deployment Steps

### Step 1: Update System Packages
```bash
sudo yum update -y
```

---

### Step 2: Install Required Software

#### Install Nginx
```bash
sudo amazon-linux-extras enable nginx1
sudo yum install nginx -y
```

#### Install PHP and Extensions
```bash
sudo amazon-linux-extras enable php8.2
sudo yum install php php-cli php-mbstring php-xml php-common php-mysqlnd php-curl php-bcmath unzip -y
```

#### Install MariaDB Server
```bash
sudo yum install mariadb-server -y
sudo systemctl start mariadb
sudo systemctl enable mariadb
```

---

### Step 3: Configure Database

#### Secure MariaDB Installation
```bash
sudo mysql_secure_installation
```
- Set the root password.
- Remove anonymous users.
- Disallow remote root login.
- Remove the test database.

#### Create Database and User
```bash
sudo mysql -u root -p
```
Run the following SQL commands:
```sql
CREATE DATABASE boomtown;
CREATE USER 'boomtown_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON boomtown.* TO 'boomtown_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

### Step 4: Initialize Laravel Application

#### Define Installation Path Variable
```bash
export LARAVEL_PATH=/var/www/html/boomtown2
```

#### Create Laravel Base Structure
Run the following commands to initialize the Laravel project structure:
```bash
mkdir -p $LARAVEL_PATH/storage/framework/cache
mkdir -p $LARAVEL_PATH/storage/framework/views
mkdir -p $LARAVEL_PATH/storage/framework/sessions
```

#### Upload Custom Files
1. Upload the `final_custom_files_with_db.zip` to the server.
2. SSH into the server and extract the files:
   ```bash
   unzip final_custom_files_with_db.zip -d $LARAVEL_PATH
   ```

#### Set Permissions
```bash
sudo chmod -R 775 $LARAVEL_PATH/storage $LARAVEL_PATH/bootstrap/cache
sudo chown -R nginx:nginx $LARAVEL_PATH
```

#### Install Composer
```bash
cd $LARAVEL_PATH
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer install
```

---

### Step 5: Configure Environment

#### Copy `.env` File
```bash
cp $LARAVEL_PATH/.env.example $LARAVEL_PATH/.env
```

#### Update Database Credentials
```env
DB_DATABASE=boomtown
DB_USERNAME=boomtown_user
DB_PASSWORD=secure_password
```

#### Generate Application Key
```bash
php artisan key:generate
```

---

### Step 6: Run Migrations and Seeders
```bash
php artisan migrate --seed
```

---

### Step 7: Configure Nginx

#### Create Nginx Configuration File
```bash
sudo nano /etc/nginx/conf.d/boomtown.conf
```
Add the following configuration:
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root $LARAVEL_PATH/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include /etc/nginx/fastcgi_params;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~* \.(jpg|jpeg|gif|css|png|js|ico|html|xml|txt)$ {
        access_log off;
        log_not_found off;
        expires max;
    }
}
```

#### Restart Nginx
```bash
sudo systemctl restart nginx
sudo systemctl enable nginx
```

---

### Step 8: Test the Application
1. Open a browser and navigate to your domain (e.g., `http://yourdomain.com`).
2. Verify the Laravel site is working correctly.

---

### Optional: Set Up HTTPS with Certbot

#### Install Certbot
```bash
sudo yum install certbot python3-certbot-nginx -y
```

#### Obtain SSL Certificate
```bash
sudo certbot --nginx -d yourdomain.com
```

#### Test Certificate Renewal
```bash
sudo certbot renew --dry-run
```

---

## Maintenance Commands

- **Clear Cache**:
  ```bash
  php artisan cache:clear
  php artisan config:clear
  php artisan route:clear
  ```

- **Restart Services**:
  ```bash
  sudo systemctl restart nginx
  sudo systemctl restart php-fpm
  ```

---

## Notes

- Always ensure that your `.env` file contains accurate credentials and configurations.
- Keep the server updated and secure by regularly applying system updates and patches.

With these steps, your Laravel application should be fully deployed and operational.


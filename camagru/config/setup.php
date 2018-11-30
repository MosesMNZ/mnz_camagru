<?php

require_once 'database.php';

    try {
        $conn = new PDO("mysql:host=localhost", $DB_USER, $DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE if NOT EXISTS db_camagru";
        $conn->exec($sql);
        echo "SETUP PROCESS<br> <br>";
        echo "1. Database created successfully<br>";
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "2. Connection to database succeeded<br>";
        
        $sql =  "DROP TABLE IF EXISTS `users`";
        $conn->exec($sql);
        echo "3. Table Users deleted if existed<br>";
        $sql = "CREATE TABLE if NOT EXISTS `users`
        (
            `user_id`   INTEGER AUTO_INCREMENT PRIMARY KEY,
            `firstname` VARCHAR(45) NOT NULL ,
            `lastname`  VARCHAR(45) NOT NULL ,
            `email`     VARCHAR(45) NOT NULL ,
            `username`  VARCHAR(45) NOT NULL ,
            `passwd`  VARCHAR(255) NOT NULL ,
            `user_activation_code` VARCHAR(255) NOT NULL,
            `user_reset_passwd_code` VARCHAR(255) NOT NULL,
            `user_email_status` enum('not verified', 'verified'),
            `notif_comment` varchar(255) DEFAULT 'yes',
            `profile_pic_url` varchar(255) DEFAULT 'http://via.placeholder.com/280x260',
            `theme` varchar(255) DEFAULT 'Default'
        );"; 
        $conn->exec($sql);
        echo "4. Table Users created successfully<br>";
        
        $sql =  "DROP TABLE IF EXISTS gallery";
        $conn->exec($sql);
        echo "5. Table Gallery deleted if existed<br>";
        $sql = "CREATE TABLE `gallery`
        (
            `image_id`  INTEGER AUTO_INCREMENT PRIMARY KEY,
            `image_url` VARCHAR(255) NOT NULL,
            `date_time_photo` VARCHAR(255) NOT NULL,
            `likes` INTEGER NOT NULL,
            `liked_id` INTEGER NOT NULL,
            `comments` INTEGER NOT NULL,
            `user_id` INTEGER NOT NULL
        );";
        $conn->exec($sql);
        echo "6. Table Gallery successfully created<br>";
        
        $sql =  "DROP TABLE IF EXISTS comments";
        $conn->exec($sql);
        echo "7. Table Comments deleted if existed<br>";
        $sql = "CREATE TABLE if NOT EXISTS `comments`
        (
            `comment_id`  INTEGER AUTO_INCREMENT PRIMARY KEY,
            `comment_content` VARCHAR(255) NOT NULL ,
            `date_time_comment` VARCHAR(255) NOT NULL,
            `image_id` INTEGER NOT NULL,
            `user_id` INTEGER NOT NULL
        );";
        $conn->exec($sql);
        echo "7. Table Comments created successfully<br><br><br>";
        $conn = null;
    }
    catch(PDOException $e){
        echo $sql . "<br> " . $e->getMessage();
    }
    echo "<br><br>Do you know what to do next right?<br>Let's do it!!!";
?>

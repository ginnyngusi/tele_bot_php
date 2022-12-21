<?php
const HOST = 'localhost';
const USERNAME = 'phpmyadmin';
const PASSWORD = 'telebot@123';
const DATABASE = 'bot';
$tokenBot = '5659975975:AAEIpO7Gwz3L8VHPcMT70DdEjFjkbH8gbvU'; // Put token here. We don't need to update this file anymore

$conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
if ($conn->connect_error) {
    echo 'Cannot establish connection to database.';
} else {
    mysqli_set_charset($conn, 'UTF8');
}

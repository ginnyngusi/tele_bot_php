<?php
const HOST = 'localhost';
const USERNAME = '';
const PASSWORD = '';
const DATABASE = '';
$tokenBot = ''; // Put token here. We don't need to update this file anymore

$conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
if ($conn->connect_error) {
    echo 'Cannot establish connection to database.';
} else {
    mysqli_set_charset($conn, 'UTF8');
}

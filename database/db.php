<?php

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'tutor_connect';

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($connection->connect_error) {
    die("DATABASE CONNECTION FAILED: " . "</br>" . mysqli_error($connection));
}

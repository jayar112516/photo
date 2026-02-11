<?php
$conn = new mysqli("localhost", "root", "", "photobook");

if ($conn->connect_error) {
    die("DB Failed: " . $conn->connect_error);
}
session_start();

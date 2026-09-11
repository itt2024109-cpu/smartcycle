<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartcycle";

// Connection එක සෑදීම
$conn = new mysqli($servername, $username, $password, $dbname);

// Connection එක Check කිරීම
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
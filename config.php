<?php
$link = mysqli_connect("localhost", "db_username", "db_password", "db_name");
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
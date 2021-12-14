<?php
    $servername = "localhost";
    $database = "Escuela";
    $username = "root";
    $password = "GEHgio1012";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . $conn->error());
    }
?>
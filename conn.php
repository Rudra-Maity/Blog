<?php
 $conn = new mysqli('localhost', 'root', '', 'test',16999);

 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
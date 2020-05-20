<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=cmsg2b', 'root', '');
} catch (PDOException $e) {
   die($e->getMessage());
}
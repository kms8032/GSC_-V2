<?php
$host = "localhost";
$username = "root";
$pw = "young223!!";
$dbname = "gsc_v2";
$port = 3307;

// MySQLi 연결
$conn = new mysqli($host, $username, $pw, $dbname, $port);

// 연결 테스트
if ($conn->connect_error) {
    die("MySQL 연결 실패: " . $conn->connect_error);
}

?>

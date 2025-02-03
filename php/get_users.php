<?php
session_start();
require 'db.php'; // 데이터베이스 연결

// 관리자만 접근 가능
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "관리자") {
    echo json_encode(["error" => "unauthorized"]);
    exit();
}

$sql = "SELECT student_id, username, role FROM users";
$result = $conn->query($sql);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
?>

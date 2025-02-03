<?php
session_start();
require 'db.php';

// 관리자 확인
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "관리자") {
    echo json_encode(["error" => "unauthorized"]);
    exit();
}

// JSON 요청 데이터 받기
$data = json_decode(file_get_contents("php://input"), true);
$student_id = $data["student_id"] ?? "";

// 사용자 삭제 SQL 실행
if ($student_id) {
    $sql = "DELETE FROM users WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "삭제 실패"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "잘못된 요청"]);
}
?>

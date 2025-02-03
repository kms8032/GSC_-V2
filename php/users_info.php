<?php
session_start();

// 로그인 여부 확인
if (!isset($_SESSION["user_id"])) {
    echo json_encode(["error" => "unauthorized"]);
    exit();
}

// JSON 형식으로 사용자 정보 반환
echo json_encode([
    "user_id" => $_SESSION["user_id"],
    "username" => $_SESSION["username"],
    "role" => $_SESSION["role"]
]);
?>

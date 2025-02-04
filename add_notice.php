<?php
require 'db.php';
require 'admin_header.php';

$data = json_decode(file_get_contents("php://input"), true);
$title = trim($data['title']);
$content = trim($data['content']);

if (empty($title) || empty($content)) {
    echo json_encode(["success" => false, "error" => "제목과 내용을 입력하세요."]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO notices (title, content) VALUES (?, ?)");
$stmt->bind_param("ss", $title, $content);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "DB 오류 발생"]);
}

$stmt->close();
?>

<?php
require 'db.php';
require 'admin_header.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data['id']);
$title = trim($data['title']);
$content = trim($data['content']);

if (empty($title) || empty($content)) {
    echo json_encode(["success" => false, "error" => "제목과 내용을 입력하세요."]);
    exit;
}

$stmt = $conn->prepare("UPDATE notices SET title = ?, content = ? WHERE id = ?");
$stmt->bind_param("ssi", $title, $content, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "DB 오류 발생"]);
}

$stmt->close();
?>

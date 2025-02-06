<?php
require 'db.php';
require 'admin_header.php';

$stmt = $conn->prepare("SELECT id, title, content, created_at FROM notices ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();

$notices = [];
while ($row = $result->fetch_assoc()) {
    $notices[] = $row;
}

header('Content-Type: application/json');
echo json_encode($notices, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

$stmt->close();
?>

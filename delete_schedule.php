<?php
require 'db.php';
require 'admin_header.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM timetable WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "시간표가 삭제되었습니다.";
        header("refresh:2; url=manage_timetable.php");
    } else {
        echo "삭제 실패.";
    }

    $stmt->close();
}
?>

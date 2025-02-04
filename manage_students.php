<?php
require 'db.php';
require 'admin_header.php';

$stmt = $conn->prepare("SELECT student_id, username, email, grade FROM users WHERE role = '학생' ORDER BY grade, student_id");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>학생 관리</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="container">
        <h2>학생 관리</h2>
        <table border="1">
            <tr>
                <th>학번</th>
                <th>이름</th>
                <th>이메일</th>
                <th>학년</th>
                <th>삭제</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['student_id']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['grade']) ?></td>
                    <td><a href="delete_student.php?id=<?= $row['student_id'] ?>">❌</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

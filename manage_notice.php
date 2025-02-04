<?php
require 'db.php';
require 'admin_header.php';

$stmt = $conn->prepare("SELECT id, title, created_at FROM notices ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항 관리</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="container">
        <h2>공지사항 관리</h2>
        <a href="add_notice.html">📢 새 공지 추가</a>
        <table border="1">
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성일</th>
                <th>삭제</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    <td><a href="delete_notice.php?id=<?= $row['id'] ?>">❌</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

<?php $stmt->close(); ?>

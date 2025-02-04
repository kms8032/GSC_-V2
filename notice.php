<?php
require 'db.php';
require 'header.php'; // 로그인 상태 유지

$grade = $_SESSION['grade']; // 로그인한 사용자의 학년

// 전체 공지 + 사용자의 학년 공지만 표시
$stmt = $conn->prepare("SELECT id, title, target_grade, created_at FROM notices WHERE target_grade IS NULL OR target_grade = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $grade);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>공지사항</h2>
        <table border="1">
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>대상 학년</th>
                <th>작성일</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><a href="notice_detail.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></a></td>
                    <td><?= $row['target_grade'] ? "{$row['target_grade']}학년" : "전체" ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

<?php $stmt->close(); ?>

<?php
require 'db.php';
require 'admin_header.php';

$stmt = $conn->prepare("SELECT id, subject, day_of_week, start_time, end_time, grade FROM timetable ORDER BY FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'), start_time");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>시간표 관리</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="container">
        <h2>시간표 관리</h2>
        <a href="add_schedule.php">➕ 새 시간표 추가</a>
        <table border="1">
            <tr>
                <th>과목명</th>
                <th>요일</th>
                <th>시간</th>
                <th>학년</th>
                <th>삭제</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= htmlspecialchars($row['day_of_week']) ?></td>
                    <td><?= htmlspecialchars($row['start_time']) ?> - <?= htmlspecialchars($row['end_time']) ?></td>
                    <td><?= htmlspecialchars($row['grade']) ?></td>
                    <td><a href="delete_schedule.php?id=<?= $row['id'] ?>">❌</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

<?php $stmt->close(); ?>

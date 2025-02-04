<?php
require 'db.php';
require 'header.php'; // 로그인 상태 유지

if (!isset($_GET['id'])) {
    die("잘못된 접근입니다.");
}

$id = intval($_GET['id']);
$grade = $_SESSION['grade']; // 로그인한 사용자의 학년

$stmt = $conn->prepare("SELECT title, content, target_grade, created_at FROM notices WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    die("공지사항을 찾을 수 없습니다.");
}

$stmt->bind_result($title, $content, $target_grade, $created_at);
$stmt->fetch();

// 학년 제한 확인
if ($target_grade !== null && $target_grade != $grade) {
    die("이 공지사항을 볼 수 있는 권한이 없습니다.");
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2><?= htmlspecialchars($title) ?></h2>
        <p><strong>작성일:</strong> <?= htmlspecialchars($created_at) ?></p>
        <p><strong>대상 학년:</strong> <?= $target_grade ? "{$target_grade}학년" : "전체" ?></p>
        <p><?= nl2br(htmlspecialchars($content)) ?></p>
        <a href="notice.php">공지사항 목록으로</a>
    </div>
</body>
</html>

<?php $stmt->close(); ?>

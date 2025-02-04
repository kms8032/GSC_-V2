<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST['student_id']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $grade = $_POST['grade'] ?? null;
    $role = $_POST['role'];

    if (empty($student_id) || empty($username) || empty($email) || empty($password) || empty($role)) {
        die("모든 필드를 입력해주세요.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("유효한 이메일을 입력하세요.");
    }

    // 학번 또는 이메일 중복 체크 (MySQLi 방식)
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR student_id = ?");
    $stmt->bind_param("ss", $email, $student_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("이미 등록된 학번 또는 이메일입니다.");
    }
    $stmt->close();

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // 데이터 삽입 (MySQLi 방식)
    $stmt = $conn->prepare("INSERT INTO users (student_id, username, email, password, grade, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $student_id, $username, $email, $hashed_password, $grade, $role);

    if ($stmt->execute()) {
        echo "회원가입 성공! 로그인 페이지로 이동하세요.";
        header("refresh:2; url=login.html");
    } else {
        echo "회원가입 실패. 다시 시도해주세요.";
    }

    $stmt->close();
    $conn->close();
}
?>

<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 입력값 가져오기 및 필터링
    $student_id = trim($_POST["student_id"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $role = trim($_POST["role"]);

    // 입력값이 비어있는지 확인
    if (empty($student_id) || empty($username) || empty($email) || empty($password) || empty($role)) {
        echo "<script>alert('모든 필드를 입력해야 합니다.'); window.location.href='../html/register.html';</script>";
        exit();
    }

    // 이메일 유효성 검사
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('올바른 이메일 형식을 입력하세요.'); window.location.href='../html/register.html';</script>";
        exit();
    }

    // 비밀번호 해싱
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 중복 학번 또는 이메일 확인
    $check_sql = "SELECT student_id, email FROM users WHERE student_id = ? OR email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $student_id, $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<script>alert('이미 등록된 학번 또는 이메일입니다.'); window.location.href='../html/register.html';</script>";
        exit();
    }
    $check_stmt->close();

    // 회원정보 저장 (승인 상태 기본값 0)
    $sql = "INSERT INTO users (student_id, username, email, password, role, approved) VALUES (?, ?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $student_id, $username, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "<script>alert('회원가입이 완료되었습니다. 관리자 승인 후 로그인 가능합니다.'); window.location.href='../html/login.html';</script>";
    } else {
        echo "<script>alert('회원가입 실패: 데이터 저장 중 오류 발생.'); window.location.href='../html/register.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

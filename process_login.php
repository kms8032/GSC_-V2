<?php
session_start(); // 세션 시작
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST['student_id']);
    $password = trim($_POST['password']);

    if (empty($student_id) || empty($password)) {
        die("학번과 비밀번호를 입력해주세요.");
    }

    // 학번 확인
    $stmt = $conn->prepare("SELECT student_id, username, password, role FROM users WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($student_id, $username, $hashed_password, $role);
        $stmt->fetch();

        // 비밀번호 검증
        if (password_verify($password, $hashed_password)) {
            $_SESSION['student_id'] = $student_id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            
            if ($role === "관리자") {
                echo "관리자 로그인 성공! 관리자 페이지로 이동합니다.";
                header("refresh:2; url=admin_dashboard.html");
            } else {
                echo "로그인 성공! 메인 페이지로 이동합니다.";
                header("refresh:2; url=index.html");
            }
        } else {
            echo "비밀번호가 올바르지 않습니다.";
        }
    } else {
        echo "등록되지 않은 학번입니다.";
    }

    $stmt->close();
    $conn->close();
}
?>

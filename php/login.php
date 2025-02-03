<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST["student_id"];
    $password = $_POST["password"];

    $sql = "SELECT student_id, username, password, role, approved FROM users WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($student_id, $username, $hashed_password, $role, $approved);
        $stmt->fetch();
        
        // 승인되지 않은 사용자 로그인 차단
        if ($approved == 0) {
            echo "<script>alert('관리자의 승인이 필요합니다.'); window.location.href='../html/login.html';</script>";
            exit();
        }

        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $student_id;
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;

            if ($role == "학생") {
                header("Location: student_dashboard.html");
            } elseif ($role == "교수") {
                header("Location: professor_dashboard.html");
            } elseif ($role == "관리자") {
                header("Location: admin_dashboard.html");
            }
            exit();
        } else {
            echo "<script>alert('비밀번호가 틀렸습니다.'); window.location.href='../html/login.html';</script>";
        }
    } else {
        echo "<script>alert('아이디가 존재하지 않습니다.'); window.location.href='../html/login.html';</script>";
    }
}
?>

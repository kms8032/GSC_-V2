<?php
session_start();
session_unset();
session_destroy();
header("Location: ../html/login.html"); // 로그인 페이지로 이동
exit();
?>

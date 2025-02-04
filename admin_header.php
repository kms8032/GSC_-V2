<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== '관리자') {
    die("관리자만 접근할 수 있습니다.");
}
?>

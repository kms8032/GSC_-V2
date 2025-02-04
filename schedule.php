<?php
require 'db.php';
require 'header.php'; // 로그인 유지

$grade = $_SESSION['grade']; // 로그인한 사용자의 학년

// 사용자의 학년과 일치하는 시간표 조회
$stmt = $conn->prepare("SELECT subject, professor, day_of_week, start_time, end_time, location FROM timetable WHERE grade = ? ORDER BY FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'), start_time");
$stmt->bind_param("i", $grade);
$stmt->execute();
$result = $stmt->get_result();

$schedule = [];
while ($row = $result->fetch_assoc()) {
    $schedule[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>시간표</title>
    <link rel="stylesheet" href="css/schedule.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const scheduleData = <?php echo json_encode($schedule); ?>;
            renderSchedule(scheduleData);
        });

        function renderSchedule(schedule) {
            const days = { "Monday": 1, "Tuesday": 2, "Wednesday": 3, "Thursday": 4, "Friday": 5 };
            schedule.forEach(item => {
                const gridColumn = days[item.day_of_week]; // 요일에 맞는 칸
                const startHour = parseInt(item.start_time.split(':')[0]);
                const endHour = parseInt(item.end_time.split(':')[0]);
                const gridRow = startHour - 8; // 9시 기준으로 줄 배치
                const spanRows = endHour - startHour;

                const div = document.createElement("div");
                div.className = "event";
                div.style.gridColumn = gridColumn;
                div.style.gridRow = `${gridRow} / span ${spanRows}`;
                div.innerHTML = `<strong>${item.subject}</strong><br>${item.location}`;

                document.querySelector(".timetable").appendChild(div);
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>📅 시간표</h2>
        <div class="timetable">
            <div class="time-label"></div>
            <div class="day">Monday</div>
            <div class="day">Tuesday</div>
            <div class="day">Wednesday</div>
            <div class="day">Thursday</div>
            <div class="day">Friday</div>

            <?php for ($hour = 9; $hour <= 18; $hour++): ?>
                <div class="time-label"><?= $hour ?></div>
            <?php endfor; ?>
        </div>
        <a href="index.html">⬅ 메인으로</a>
    </div>
</body>
</html>

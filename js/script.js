// 학년 선택
function selectGrade(grade) {
    const role = document.getElementById("roleSelect").value;
    
    if (role === "학생") {
        document.getElementById("selectedGrade").value = grade;
        document.getElementById("gradeDisplay").innerText = "선택된 학년: " + grade + "학년";
    }
}

// 역할 선택 시 학년 표시 여부 변경
function checkRole() {
    const role = document.getElementById("roleSelect").value;
    const gradeSection = document.getElementById("gradeSection");

    if (role === "교수" || role === "관리자") {
        gradeSection.style.display = "none"; // 학년 선택 숨기기
        document.getElementById("selectedGrade").value = ""; 
        document.getElementById("gradeDisplay").innerText = "선택된 학년: 없음";
    } else {
        gradeSection.style.display = "block"; // 학년 선택 보이기
    }
}

// 비밀번호 확인 기능
function checkPasswordMatch() {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    const errorText = document.getElementById("passwordError");

    if (password === confirmPassword) {
        errorText.innerText = ""; // 에러 메시지 지움
    } else {
        errorText.innerText = "비밀번호가 일치하지 않습니다.";
        errorText.style.color = "red";
    }
}

// 최종 회원가입 제출 전 검증
function validateForm() {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    if (password !== confirmPassword) {
        alert("비밀번호가 일치하지 않습니다. 다시 확인해주세요.");
        return false;
    }
    return true;
}

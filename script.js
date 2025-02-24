document.getElementById("signupForm").addEventListener("submit", function(event) {
    let email = document.getElementById("email").value;
    let phone = document.getElementById("phone").value;
    let emailError = document.getElementById("emailError");
    let phoneError = document.getElementById("phoneError");
    let isValid = true;

    // Kiểm tra email
    if (!email.includes("@") || !email.match(/^[^@]+@[^@]+\.[a-zA-Z]{2,6}$/)) {
        emailError.textContent = "Email không hợp lệ!";
        isValid = false;
    } else {
        emailError.textContent = "";
    }

    // Kiểm tra số điện thoại (chỉ số, ít nhất 10 ký tự)
    if (!phone.match(/^\d{10,}$/)) {
        phoneError.textContent = "Số điện thoại không hợp lệ!";
        isValid = false;
    } else {
        phoneError.textContent = "";
    }

    if (!isValid) event.preventDefault();
});

document.addEventListener("DOMContentLoaded", function () {
    console.log("Trang đặt phòng đã sẵn sàng!");
    
    // Thêm sự kiện khi nhấn nút đặt phòng
    document.querySelector("form").addEventListener("submit", function (event) {
        let name = document.getElementById("name").value;
        let email = document.getElementById("email").value;

        if (name.trim() === "" || email.trim() === "") {
            alert("Vui lòng điền đầy đủ thông tin!");
            event.preventDefault(); // Ngăn chặn gửi form nếu có lỗi
        }
    });
});

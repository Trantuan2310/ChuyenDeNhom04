<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Đặt Phòng Khách Sạn</title>
    <link rel="stylesheet" href="index.css"> <!-- Liên kết file CSS -->
</head>
<body>

    <div class="container">
        <h2>Đặt Phòng Khách Sạn</h2>
        <form action="process.php" method="POST">
            <label for="name">Họ và tên:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="checkin">Ngày nhận phòng:</label>
            <input type="date" id="checkin" name="checkin" required>

            <label for="checkout">Ngày trả phòng:</label>
            <input type="date" id="checkout" name="checkout" required>

            <label for="room">Loại phòng:</label>
            <select id="room" name="room">
                <option value="single">Phòng đơn</option>
                <option value="double">Phòng đôi</option>
                <option value="suite">Phòng hạng sang</option>
            </select>

            <button type="submit">Đặt phòng</button>
        </form>
    </div>

    <script src="index.js"></script> <!-- Liên kết file JavaScript -->
</body>
</html>

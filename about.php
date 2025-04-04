
<?php
// Kết nối đến cơ sở dữ liệu MySQL
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'homestay';

// Kết nối đến cơ sở dữ liệu

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Tạo bảng nếu chưa tồn tại
$tableSql = "CREATE TABLE IF NOT EXISTS page_clicks (
                id INT AUTO_INCREMENT PRIMARY KEY,
                clicks INT DEFAULT 0
            )";

// Thực thi câu lệnh SQL tạo bảng
if ($conn->query($tableSql) === TRUE) {
    // Bảng đã tồn tại hoặc đã được tạo thành công
} else {
    echo "Lỗi tạo bảng: " . $conn->error;
}

// Lấy giá trị hiện tại của biến 'clicks'
$sql = "SELECT clicks FROM page_clicks WHERE id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Cập nhật số lần nhấn
    $row = $result->fetch_assoc();
    $newClickCount = $row['clicks'] + 1;

    // Cập nhật lại giá trị trong cơ sở dữ liệu
    $updateSql = "UPDATE page_clicks SET clicks = $newClickCount WHERE id = 1";
    if ($conn->query($updateSql) === TRUE) {
        $clicks = $newClickCount;
    } else {
        $clicks = $row['clicks'];
    }
} else {
    // Nếu không có bản ghi, tạo mới với giá trị ban đầu là 1
    $insertSql = "INSERT INTO page_clicks (clicks) VALUES (1)";
    if ($conn->query($insertSql) === TRUE) {
        $clicks = 1;
    } else {
        $clicks = 0;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link  rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
  <?php require('inc/links.php'); ?>
  <title><?php echo $settings_r['site_title'] ?> - GIỚI THIỆU</title>
  <style>
    .box{
      border-top-color: var(--teal) !important;
    }
  </style>
</head>
<body class="bg-light">

  <?php require('inc/header.php'); ?>



  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">GIỚI THIỆU</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">
    Homestay cam kết mang đến cho khách hàng những trải nghiệm<br>
    tuyệt vời nhất trong một không gian sang trọng và đẳng cấp.
    </p>
  </div>

  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
        <h3 class="mb-3">Homestay</h3>
        <p>
        Homestay là hình thức lưu trú cho phép du khách sống cùng với các gia đình địa phương, 
        mang đến trải nghiệm văn hóa phong phú và gần gũi. Tại đây, du khách không chỉ được nghỉ 
        ngơi mà còn tham gia vào các hoạt động hàng ngày, thưởng thức bữa ăn đặc sản do gia đình 
        chuẩn bị và giao lưu với người dân địa phương. Hình thức này không chỉ giúp tiết kiệm chi 
        phí mà còn hỗ trợ kinh tế cho cộng đồng, tạo ra những kỷ niệm đáng nhớ trong hành trình khám phá.
        </p>
      </div>
      <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
        <img src="images/about/ht.webp" class="w-100">
      </div>
    </div>
  </div>

  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/about/hotel.svg" width="70px">
          <h4 class="mt-3">100+ PHÒNG</h4>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/about/customers.svg" width="70px">
          <h4 class="mt-3">200+ KHÁCH HÀNG</h4>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/about/rating.svg" width="70px">
          <h4 class="mt-3">150+ ĐÁNH GIÁ</h4>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/about/staff.svg" width="70px">
          <h4 class="mt-3"><?php echo $clicks; ?>+ LƯỢT TRUY CẬP</h4>
        </div>
      </div>
    </div>
  </div>

  <h3 class="my-5 fw-bold h-font text-center">ĐỘI NGŨ</h3>

  <div class="container px-4">
    <div class="swiper mySwiper">
      <div class="swiper-wrapper mb-5">
        <?php 
          $about_r = selectAll('team_details');
          $path=ABOUT_IMG_PATH;
          while($row = mysqli_fetch_assoc($about_r)){
            echo<<<data
              <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                <img src="$path$row[picture]" class="w-100">
                <h5 class="mt-2">$row[name]</h5>
              </div>
            data;
          }
        
        ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>


  
  <?php require('inc/footer.php'); ?>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

  <script>
    var swiper = new Swiper(".mySwiper", {
      spaceBetween: 40,
      pagination: {
        el: ".swiper-pagination",
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
        },
        640: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 3,
        },
        1024: {
          slidesPerView: 3,
        },
      }
    });
  </script>


</body>
</html>
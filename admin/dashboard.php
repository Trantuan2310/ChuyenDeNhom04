<?php
  require('inc/essentials.php');
  require('inc/db_config.php');
  adminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>THỐNG KÊ</title>
  <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

  <?php 
  
    require('inc/header.php'); 
    
    $is_shutdown = mysqli_fetch_assoc(mysqli_query($con,"SELECT `shutdown` FROM `settings`"));

    $current_bookings = mysqli_fetch_assoc(mysqli_query($con,"SELECT 
      COUNT(CASE WHEN booking_status='Đã Thanh Toán' AND arrival=0 THEN 1 END) AS `new_bookings`,
      COUNT(CASE WHEN booking_status='Đã Huỷ' AND refund=0 THEN 1 END) AS `refund_bookings`
      FROM `booking_order`"));

    $unread_queries = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count`
      FROM `user_queries` WHERE `seen`=0"));

    $unread_reviews = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count`
      FROM `rating_review` WHERE `seen`=0"));
    
    $current_users = mysqli_fetch_assoc(mysqli_query($con,"SELECT 
      COUNT(id) AS `total`,
      COUNT(CASE WHEN `status`=1 THEN 1 END) AS `active`,
      COUNT(CASE WHEN `status`=0 THEN 1 END) AS `inactive`,
      COUNT(CASE WHEN `is_verified`=0 THEN 1 END) AS `unverified`
      FROM `user_cred`"));  
  
  ?>
  <?php
      $query = "SELECT COUNT(*) AS total_rooms FROM rooms";
      $result = mysqli_query($con, $query);
      if ($result) {
          $row = mysqli_fetch_assoc($result);
          $total_rooms = $row['total_rooms'];
      }
      $query = "SELECT COUNT(*) AS kh_datphong FROM booking_order  WHERE `booking_status` = 'Đã Đặt'";
      $result1 = mysqli_query($con, $query);
      if ($result1) {
          $row = mysqli_fetch_assoc($result1);
          $kh_datphong = $row['kh_datphong'];
        }
      $query = "SELECT SUM(trans_amt) AS tong_doanhthu FROM booking_order";
      $result2 = mysqli_query($con, $query);

      if ($result2) {
          $row = mysqli_fetch_assoc($result2);
          $tong_doanhthu = $row['tong_doanhthu'];
      }

       $query = "SELECT COUNT(*) AS total_rating FROM rating_review";
       $result3 = mysqli_query($con, $query);
       if ($result3) {
           $row = mysqli_fetch_assoc($result3);
           $total_rating = $row['total_rating'];
       }
       $query = "SELECT COUNT(*) AS total_khachhang FROM user_cred";
       $result4 = mysqli_query($con, $query);
       if ($result4) {
           $row = mysqli_fetch_assoc($result4);
           $total_khachhang = $row['total_khachhang'];
       }
       $query = "SELECT COUNT(*) AS total_phanhoi FROM user_queries";
       $result5 = mysqli_query($con, $query);
       if ($result5) {
           $row = mysqli_fetch_assoc($result5);
           $total_phanhoi = $row['total_phanhoi'];
       }
       $query = "SELECT COUNT(*) AS total_phonghuy FROM booking_order WHERE `booking_status` = 'Đã Huỷ'";
       $result6 = mysqli_query($con, $query);
       if ($result6) {
           $row = mysqli_fetch_assoc($result6);
           $total_phonghuy = $row['total_phonghuy'];
       }

      $query = "SELECT SUM(quantity) AS tong_sophong FROM rooms";
      $result7 = mysqli_query($con, $query);
      if ($result7) {
          $row = mysqli_fetch_assoc($result7);
          $tong_sophong = $row['tong_sophong'];
      }

      $query = "SELECT COUNT(*) AS total_bookings FROM booking_order WHERE `booking_status` = 'Đã Xác Nhận Đặt Phòng'";
      $result8 = mysqli_query($con, $query);
      $row = mysqli_fetch_assoc($result8);
      $total_phongdat = $row['total_bookings'];


  ?>
  <div class="container-fluid" id="main-content">
    <div class="row" >
      <div class="col-lg-10 ms-auto p-4 overflow-hidden">
        
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h3>THỐNG KÊ</h3>
          <?php 
            if($is_shutdown['shutdown']){
              echo<<<data
                <h6 class="badge bg-danger py-2 px-3 rounded">Chế độ tắt máy đang hoạt động!</h6>
              data;
            }
          ?>
        </div>

        <div class="row mb-4">
          <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-success p-3">
                <h6>Tổng Số Loại Phòng</h6>
                <h1 class="mt-2 mb-0"><?php echo $total_rooms ?></h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-info p-3">
                <h6>Tổng Số Phòng</h6>
                <h1 class="mt-2 mb-0"><?php echo $tong_sophong ?></h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-info p-3">
                <h6>Khách Hàng Mới Đặt</h6>
                <h1 class="mt-2 mb-0"><?php echo $kh_datphong ?></h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-info p-3">
                <h6>Phòng Đang Đặt</h6>
                <h1 class="mt-2 mb-0"><?php echo $total_phongdat ?></h1>
              </div>
            </a>
          </div>



        </div>
        <div class="row mb-3">
        <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-info p-3">
                <h6>Phòng Đang Trống</h6>
                <h1 class="mt-2 mb-0"><?php  echo $p_trong = $tong_sophong - $total_phongdat ?></h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-primary p-3">
                <h6>Xếp hạng và đánh giá</h6>
                <h1 class="mt-2 mb-0"><?php echo $total_rating ?></h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-info p-3">
                <h6>Khách Hàng Đăng Ký</h6>
                <h1 class="mt-2 mb-0"><?php echo $total_khachhang ?></h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-warning p-3">
                <h6>Phản Hồi Và Góp Ý</h6>
                <h1 class="mt-2 mb-0"><?php echo $total_phanhoi ?></h1>
              </div>
            </a>
          </div>

          <div class="row mb-4" >
            <div class="col-md-3 mb-4">
              <a href="" class="text-decoration-none">
                <div class="card text-center text-danger p-3">
                  <h6>Phòng Bị Huỷ</h6>
                  <h1 class="mt-2 mb-0"><?php echo $total_phonghuy ?></h1>
                </div>
              </a>
            </div>
            <div class="col-md-3 mb-4">
              <a href="" class="text-decoration-none">
                <div class="card text-center text-success p-3">
                  <h6>Tổng Doanh Thu</h6>
                  <h2 class="mt-2 mb-0"><?php echo $tong_doanhthu ?> vnđ</h2>
                </div>
              </a>
            </div>
          </div>
      </div>
    </div>
  </div>
  

  <?php require('inc/scripts.php'); ?>

  <script>
    function booking_analytics(period=1)
    {
      let xhr = new XMLHttpRequest();
      xhr.open("POST","ajax/dashboard.php",true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
      xhr.onload = function(){
        let data = JSON.parse(this.responseText);
        document.getElementById('total_bookings').textContent = data.total_bookings;
        document.getElementById('total_amt').textContent = ''+data.total_amt;
    
        document.getElementById('active_bookings').textContent = data.active_bookings;
        document.getElementById('active_amt').textContent = ''+data.active_amt;
        
        document.getElementById('cancelled_bookings').textContent = data.cancelled_bookings;
        document.getElementById('cancelled_amt').textContent = ''+data.cancelled_amt;
      }
    
      xhr.send('booking_analytics&period='+period);
    }
    
    function user_analytics(period=1)
    {
      let xhr = new XMLHttpRequest();
      xhr.open("POST","ajax/dashboard.php",true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
      xhr.onload = function(){
        let data = JSON.parse(this.responseText);
    
        document.getElementById('total_new_reg').textContent = data.total_new_reg;
        document.getElementById('total_queries').textContent = data.total_queries;
        document.getElementById('total_reviews').textContent = data.total_reviews;
      }
    
      xhr.send('user_analytics&period='+period);
    }
    
    
    window.onload = function(){
      booking_analytics();
      user_analytics();
    }
  </script>
</body>
</html>
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
  <title>Admin - Đặt Phòng</title>
  <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

  <?php require('inc/header.php'); ?>

  <div class="container-fluid" id="main-content">
    <div class="row">
      <div class="col-lg-10 ms-auto p-4 overflow-hidden">
        <h3 class="mb-4">Phòng Mới Đặt</h3>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">

            <div class="text-end mb-4">
              <input type="text" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Nhập để tìm kiếm...">
            </div>

            <div class="table-responsive">
              <table class="table table-hover border" style="min-width: 1200px;">
                <thead>
                  <tr class="bg-dark text-light">
                    <th scope="col">#</th>
                    <th scope="col">Thông Tin Khách Hàng</th>
                    <th scope="col">Phòng</th>
                    <th scope="col">Thông Tin Phòng Đặt</th>
                    <th scope="col">Hành Động</th>
                  </tr>
                </thead>
                <tbody id="table-data">                 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <?php require('inc/scripts.php'); ?>
  
  <script>
    function get_bookings(search = '') {
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/khdatphong.php", true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
      xhr.onload = function () {
        document.getElementById('table-data').innerHTML = this.responseText;
      }
    
      xhr.send('get_bookings&search=' + search);
    }
    
    function kh_booking(id) {
      if (confirm("Bạn có chắc chắn, bạn muốn xác nhận đặt phòng này?")) {
        let data = new FormData();
    
        data.append('booking_id', id);
        data.append('kh_booking', '');
    
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/khdatphong.php", true);
    
        xhr.onload = function () {
          console.log(this.responseText)
          if (this.responseText == 1) {
            alert('success', 'Xác nhận thành công!');
            get_bookings();
          }
          else {
            alert('error', 'Lỗi!');
            get_bookings();
          }
        }
    
        xhr.send(data);
      }
    }
    
    function huy_booking(id) {
      if (confirm("Bạn có chắc chắn, bạn muốn hủy đặt phòng này?")) {
        let data = new FormData();
        data.append('booking_id', id);
        data.append('huy_booking', '');
    
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/khdatphong.php", true);
    
        xhr.onload = function () {
          if (this.responseText == 1) {
            alert('success', 'Hủy thành công!');
            get_bookings();
          }
          else {
            alert('error', 'Server Down!');
          }
        }
    
        xhr.send(data);
      }
    }
    
    window.onload = function () {
      get_bookings();
    }
  </script>
</body>
</html>
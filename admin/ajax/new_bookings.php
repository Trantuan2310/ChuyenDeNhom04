<?php

require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if (isset($_POST['get_bookings'])) {
  $frm_data = filteration($_POST);

  $query = "SELECT bo.*, bd.* FROM `booking_order` bo
      INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
      WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) 
      AND (bo.booking_status = ? AND bo.arrival = ?) ORDER BY bo.booking_id ASC";

  $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", 'Đã Xác Nhận Đặt Phòng', 0], 'ssssi');

  $i = 1;
  $table_data = "";

  if (mysqli_num_rows($res) == 0) {
    echo "<b>Không tìm thấy dữ liệu nào!</b>";
    exit;
  }

  while ($data = mysqli_fetch_assoc($res)) {
    $date_now = date("d-m-Y", strtotime(date("d-m-Y")));
    $date = date("d-m-Y", strtotime($data['datentime']));
    $checkin = date("d-m-Y", strtotime($data['check_in']));
    $checkout = date("d-m-Y", strtotime($data['check_out']));
    $count_days = date_diff(new DateTime($checkin), new DateTime($checkout))->days;
    $time_out = date_diff(new DateTime($date_now), new DateTime($checkout))->days;
    if(new DateTime($date_now) >= new DateTime($checkout)){
      $han_phong = "<span class='badge bg-warning'>Đã Hết Hạn</span>";
    }
    else{
      $han_phong = $time_out .' '."ngày";
    }

    $table_data .= "
        <tr>
          <td>$i</td>
          <td>
            <span class='badge bg-primary'>
              ID Đặt Phòng: $data[order_id]
            </span>
            <br>
            <b>Tên:</b> $data[user_name]
            <br>
            <b>Điện Thoại:</b> $data[phonenum]
          </td>
          <td>
            <b>Phòng:</b> $data[room_name]
            <br>
            <b>Giá:</b> $data[price] vnđ
            <br>
            <b>Tổng:</b> $data[total_pay] vnđ
          </td>
          <td>
            <b>Ngày Vào:</b> $checkin
            <br>
            <b>Ngày Trả:</b> $checkout
            <br>
            <b>Thời Gian:</b> $count_days ngày
            <br>
            <b>Thời Gian Còn Lại:</b> $han_phong

          </td>
          <td>
            <button type='button' onclick='payment_booking($data[booking_id], $data[price], $count_days)' class='mb-2 btn btn-outline-success btn-sm fw-bold shadow-none'>
              <i class='bi bi-check2-square'></i> Xác Nhận Thanh Toán
            </button>
            <br>
            <button type='button' onclick='cancel_booking($data[booking_id])' class='mt-2 btn btn-outline-danger btn-sm fw-bold shadow-none'>
              <i class='bi bi-trash'></i> Huỷ Đặt Phòng
            </button>
          </td>
        </tr>
      ";

    $i++;
  }

  echo $table_data;
}

if (isset($_POST['payment_booking'])) {
  $frm_data = filteration($_POST);

  $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
      ON bo.booking_id = bd.booking_id INNER JOIN `rooms` r
      ON bo.room_id = r.id
      SET bo.arrival = ?, bo.booking_status = ?, bo.trans_amt = ?, bo.trans_status=?
      WHERE bo.booking_id = ?";

  $values = [1, $frm_data['booking_status'], $frm_data['trans_amt'], $frm_data['trans_status'],$frm_data['booking_id']];

  $res = update($query, $values, 'isssi');
  echo $res;
}

if (isset($_POST['cancel_booking'])) {
  $frm_data = filteration($_POST);

  $query = "UPDATE `booking_order` bo INNER JOIN `rooms` r
  ON bo.room_id = r.id
  SET `booking_status`=?, `refund`=?
  WHERE `booking_id`=?";
  $values = ['Đã Huỷ', 0, $frm_data['booking_id']];
  $res = update($query, $values, 'sii');

  echo $res;

}
<?php
    if(isset($_POST['tenNganh'])){
        include './database/connect.php';
        include './functions.php';

        $tenNganh = $_POST['tenNganh'];
        $toHop = $_POST['toHop'];

        $condition = [
            'major_name' => $tenNganh
        ];
        $result1 = select('majors', '*', $condition);
        $id_major = mysqli_fetch_array($result1)['id_major'];

        // lấy ra điểm sàn thông qua id_major và id_SB
        $condition = [
            'id_major' => $id_major,
            'id_SB' => $toHop
        ];
        $result2 = select('chuyennganh', ['diem_san'], $condition);
        $diem_san = mysqli_fetch_array($result2)['diem_san'];

        echo '<div class="mb_top_8px" style="font-weight: 500; margin-bottom: 4px;">Điểm sàn</div>
            <input type="text" style="width: 55px; text-align: center;" id="diemsan" name="diemsan" value="' . $diem_san . '" readonly>';

    }
?>
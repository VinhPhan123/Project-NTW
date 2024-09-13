<?php 
    include './layouts/header.php';
?>

<?php
    $m=0;
    $n=0;
    $token = md5(uniqid());
?>

<?php 
    // nếu chưa đăng nhập thì out
    $sql = "SELECT * FROM admins;";
    $res = mysqli_query($connect, $sql);
    $query_username = mysqli_fetch_array($res);
    $username_admin = $query_username['username'];
    if($_SESSION['taiKhoan'] != $username_admin){
        header("location: logout.php");
    }
?>
<?php
    $sql_select_subject_combination = "SELECT * FROM subject_combination";
    $query_select_subject_combination = mysqli_query($connect, $sql_select_subject_combination);
    $result_select_subject_combination = mysqli_num_rows($query_select_subject_combination);
    $arr_select_subject_combination = mysqli_fetch_all($query_select_subject_combination);
    
    // echo "<pre>";
    // echo print_r($arr_select_subject_combination);
    // echo "</pre>";
?>

<div class="container" style="display: block; width: 100%;">
	<!-- Page content -->
     <div>
        <h4>Thêm chuyên ngành</h4>
        <form action="" method="post" style="position: relative;">
            <label for="major_name">Tên chuyên ngành</label><br>
            <input type="text" name="major_name" id="">
            <input type="hidden" name="_token" value="<?php echo $token; ?>">
            <button type="submit" name="submit_major_name" style="position: absolute; left: 220px; top: 55px;" class="btn btn-primary">Thêm</button>
        </form>
        <?php
            // $token1 = $_SESSION['token'];
            // $token2 = $_POST['_token'];
            // echo $token1;
            // echo "<br>";
            // echo $token2;
            // echo "<script>alert('$token2');</script>";
            if(isset($_POST['submit_major_name']) && $_SESSION['token'] == $_POST['_token']) {
                // echo "<script>alert('$token2');</script>";
                $major_name = $_POST['major_name'];

                $sql_select_major_name = "SELECT * FROM majors WHERE major_name = '$major_name'";
                $query_select_major_name = mysqli_query($connect, $sql_select_major_name);
                $result_select_major_name = mysqli_num_rows($query_select_major_name);

                if($result_select_major_name > 0) {
                    echo "<script>alert('Ngành này đã tồn tại');</script>";
                } else {
                    $tmp = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM majors"));
                    $sql_insert_major_name = "INSERT INTO majors VALUES ($tmp+1, '$major_name');";
                    $query_insert_major_name = mysqli_query($connect, $sql_insert_major_name);

                    if($query_insert_major_name) {
                        echo "<script>alert('Đã thêm ngành thành công!');</script>";
                    } else {
                        echo "<script>alert('Thêm ngành thất bại!');</script>";
                    }
                }

            }
        ?>
     </div>
    <div>
        <h4>Danh sách ngành</h4>
        <?php
            $sql_major = "SELECT * FROM majors";
            $query_major = mysqli_query($connect, $sql_major);
            $result_major = mysqli_num_rows($query_major);
            if($result_major == 0) {
                echo "Chưa có ngành nào";
            } else {
                $arr_major = mysqli_fetch_all($query_major);
                // echo "<pre>";
                // echo print_r($arr_major);
                // echo "</pre>";

                echo "
                <table>
                    <tr>
                        <th>STT</th>
                        <th>Tên ngành</th>
                        <th>Tổ hợp môn</th>
                        <th>Insert</th>
                        <th>Delete</th>
                    </tr>";
                for($i=0; $i<$result_major; $i++) {
                    $sql_select_sb_in_major = "SELECT * FROM chuyennganh WHERE id_major = $i+1;";
                    $query_select_sb_in_major = mysqli_query($connect, $sql_select_sb_in_major);
                    $result_select_sb_in_major = mysqli_num_rows($query_select_sb_in_major);
                    $arr_select_sb_in_major = mysqli_fetch_all($query_select_sb_in_major);
                    // echo $result_select_sb_in_major;
                    // echo "<pre>";
                    // echo print_r($arr_select_sb_in_major);
                    // echo "</pre>";
    
                    echo "<tr>";
                    echo "<td>" . $arr_major[$i][0] . "</td>";
                    echo "<td>" . $arr_major[$i][1] . "</td>";
                    echo "<td>";
                        $sql_select_chuyennganh = "SELECT * FROM chuyennganh WHERE id_major = $i+1;";
                        $query_select_chuyennganh = mysqli_query($connect, $sql_select_chuyennganh);
                        $result_select_chuyennganh = mysqli_num_rows($query_select_chuyennganh);
                        if($result_select_chuyennganh == 0) {
                            echo "Chưa có tổ hợp môn";
                        } else {
                            $arr_select_chuyennganh = mysqli_fetch_all($query_select_chuyennganh);
                            for($j=0; $j<$result_select_chuyennganh; $j++) {
                                echo $arr_select_chuyennganh[$j][1];
                                if($j < $result_select_chuyennganh-1) echo ' - ';
                            }
                        }
                    echo "</td>";
                    $tmp = $i+1;
                    echo '<td sytle="display: flex;">
                        <form action="" method="post">
                        <input type="hidden" name="row_id" value="' . $tmp . '">
                        <select name="insert_tohop">
                            <option></option>';
                                for($j=0; $j<$result_select_subject_combination; $j++) {
                                    echo '<option value="' . $arr_select_subject_combination[$j][0] .'">' . $arr_select_subject_combination[$j][0] . '</option>';
                                }
                        echo '</select>';
                        echo '<button type="submit" class="btn btn-primary" name="insert">Insert</button>';
                        echo ' <input type="hidden" name="_token" value="'. $token .'"/></form>';
                    echo "</td>";
                    if($result_select_sb_in_major > 0) {
                        echo '<td sytle="display: flex;">
                        <form action="" method="post">
                        <input type="hidden" name="row_id" value="' . $tmp . '">
                        <select name="delete_tohop">
                            <option></option>';
                                for($j=0; $j<$result_select_sb_in_major; $j++) {
                                    echo '<option value="' . $arr_select_sb_in_major[$j][1] .'">' . $arr_select_sb_in_major[$j][1] . '</option>';
                                }
                        echo '</select>';
                        echo '<button type="submit" class="btn btn-danger" name="delete">Delete</button>';
                        echo ' <input type="hidden" name="_token" value="'. $token .'"/></form>';
                        echo "</td>";
                    } else {
                        echo "<td>Chưa có tổ hợp môn</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
        ?>
        <?php
            if(isset($_POST['insert']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {
                $id_major = $_POST['row_id'];
                $id_SB = $_POST['insert_tohop'];

                if($id_SB == '') {
                    echo "<script>alert('Bạn chưa chọn tổ hợp môn!');</script>";
                } else {
                    $sql_select_chuyennganh = "SELECT id_SB FROM chuyennganh WHERE id_major = $id_major;";
                    $query_select_chuyennganh = mysqli_query($connect, $sql_select_chuyennganh);
                    $arr_select_chuyennganh = mysqli_fetch_all($query_select_chuyennganh);

                    $tmp_arr = array();
                    for($i= 0; $i<count($arr_select_chuyennganh); $i++) {
                        array_push($tmp_arr, $arr_select_chuyennganh[$i][0]);
                    }
                    // echo "<pre>";
                    // echo print_r($tmp_arr);
                    // echo "</pre>";

                    // echo "<script>alert('" . $id_major . " " . $id_SB . "');</script>";

                    if(in_array($id_SB, $tmp_arr)) {
                        echo "<script>alert('Tổ hợp môn này đã tồn tại trong mã ngành!');</script>";
                    } else {
                        $sql_insert_chuyennganh = "INSERT INTO chuyennganh VALUES($id_major, '$id_SB')";
                        mysqli_query($connect, $sql_insert_chuyennganh);
                        echo "<script>alert('Đã thêm tổ hợp môn thành công!');</script>";
                        echo '<script>window.location="admin_tao_ho_so.php";</script>';
                    }
                }
            }
            
            if(isset($_POST['delete']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['_token']) {
                $id_major = $_POST['row_id'];
                $id_SB = $_POST['delete_tohop'];

                // echo "<script>alert('" . $id_major . " " . $id_SB . "');</script>";

                if($id_SB == '') {
                    echo "<script>alert('Bạn chưa chọn tổ hợp môn!');</script>";
                } else {
                    $sql_delete_sb_in_major = "DELETE FROM chuyennganh WHERE id_major=$id_major AND id_SB='$id_SB';";
                    mysqli_query($connect, $sql_delete_sb_in_major);
                    echo "<script>alert('Đã xóa tổ hợp môn thành công!');</script>";
                    echo '<script>window.location="admin_tao_ho_so.php";</script>';
                }
            }
        ?>
    </div>
	<?php 
        $_SESSION['token'] = $token;
		include './layouts/footer.php';
	?>
</div>
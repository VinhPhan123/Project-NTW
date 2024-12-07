<link rel="stylesheet" href="./assets/css/menu.css">
<div class="button-open" id="button-open">
    <div class="button-block">
        <div class="button-line"></div>
        <div class="button-line"></div>
        <div class="button-line"></div>
    </div>
</div>
<menu id="menu">
    <div class="menu" id="menu_item">
        <div class="menu-tag">ĐIỀU HƯỚNG</div>
        <div class="button-close" id="button-close">X</div>
        <ul class="dropdown">
            <li class="dropdown-item"><a href="index.php?#">Trang chủ</a></li>
        </ul>
        <ul class="dropdown">
            <?php
                if($_SESSION['role'] == "admin") {
                    echo("<p>GIÀNH CHO ADMIN</p>");
                    echo('<li class="dropdown-item"><a href="admin_tao_ho_so.php">Tạo Hồ sơ</a></li>');
                    echo('<li class="dropdown-item"><a href="danh_sach_nganh.php">Danh sách ngành</a></li>');
                    echo('<li class="dropdown-item"><a href="admin_phan_nganh_gv.php">Phân ngành GV</a></li>');
                    echo('<li class="dropdown-item"><a href="admin_duyetTK.php">Duyệt GV đăng ký</a></li>');
                    echo('<li class="dropdown-item"><a href="admin_danh_sach_ho_so.php">Danh sách hồ sơ</a></li>');
                    echo('<li class="dropdown-item"><a href="admin_thong_ke_ho_so.php">Thống kê hồ sơ</a></li>');
                } elseif($_SESSION['role'] == 'teacher') {
                    echo("<p>GIÀNH CHO TEACHER</p>");
                    echo('<li class="dropdown-item"><a href="teacher_duyet_ho_so.php">Duyệt hồ sơ</a></li>');
                    echo('<li class="dropdown-item"><a href="teacher_lich_su_duyet_ho_so.php">Lịch sử duyệt hồ sơ</a></li>');
                } else {
                    echo("<p>GIÀNH CHO STUDENT</p>");
                    echo('<li class="dropdown-item"><a href="student_knowled_record.php">Học bạ</a></li>');
                    echo('<li class="dropdown-item"><a href="danh_sach_nganh.php">Các ngành xét tuyển</a></li>');
                    echo('<li class="dropdown-item"><a href="student_nop_ho_so.php">Nộp hồ sơ xét tuyển</a></li>');
                    echo('<li class="dropdown-item"><a href="student_lich_su_nop_ho_so.php">Lịch sử nộp hồ sơ</a></li>');
                }
                
                if(isset($_SESSION['menu_status'])) {
                    if($_SESSION['menu_status'] == "open") {
                        echo('
                        <script>
                            var btnOpen = document.getElementById("button-open");
                            var menu = document.getElementById("menu");
                            var menu_item = document.getElementById("menu_item");
                            btnOpen.style.left = "-50px";
                            menu.style.width = "300px";
                            menu.style.left = "0px";
                            menu_item.style.left = "0px";
                            sessionStorage.setItem("menu_status", "open");
                        </script>');
                    } elseif($_SESSION['menu_status'] == 'close') {
                        echo('
                        <script>
                            var btnOpen = document.getElementById("button-open");
                            var menu = document.getElementById("menu");
                            var menu_item = document.getElementById("menu_item");
                            menu.style.width = "0px";
                            menu.style.left = "-50px";
                            menu_item.style.left = "-300px";
                            btnOpen.style.left = "10px";
                            sessionStorage.setItem("menu_status", "close");
                        </script>');
                    }
                }
            ?>
        </ul>
    </div>
</menu>

<script>
    console.log(sessionStorage.getItem("menu_status"));
    var btnOpen = document.getElementById("button-open");
    var btnClose = document.getElementById("button-close");
    var menu = document.getElementById("menu");
    var menu_item = document.getElementById("menu_item");
    btnOpen.onclick = function() {
        btnOpen.style.animation = "move-button-close 1s";
        btnOpen.style.left = "-50px";
        menu.style.animation = "menu-base-open 1s";
        menu.style.width = "300px";
        menu.style.left = "0px";
        menu_item.style.animation = "menu-item-open 1s";
        menu_item.style.left = "0px";
        sessionStorage.setItem("menu_status", "open");
        console.log(sessionStorage.getItem("menu_status"));
    };
    btnClose.onclick = function() {
        menu.style.animation = "menu-base-close 1s";
        menu.style.width = "0px";
        menu.style.left = "-50px";
        menu_item.style.animation = "menu-item-close 1s";
        menu_item.style.left = "-300px";
        btnOpen.style.animation = "move-button-open 1s";
        btnOpen.style.left = "10px";
        sessionStorage.setItem("menu_status", "close");
        console.log(sessionStorage.getItem("menu_status"));
    };
</script>

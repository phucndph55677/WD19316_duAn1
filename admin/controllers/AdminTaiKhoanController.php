<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class AdminTaiKhoanController{
    public $modelTaiKhoan;
    public $modelDonHang;
    public $modelSanPham;
    
    
    public function __construct(){
        $this->modelTaiKhoan = new AdminTaiKhoan();
        $this->modelDonHang = new AdminDonHang();
        $this->modelSanPham = new AdminSanPham();

}
public function danhsachQuanTri($chuc_vu_id){
    $listQuanTri = $this->modelTaiKhoan->getAllTaiKhoan(1);
   
    require_once('./views/taikhoan/quantri/listQuanTri.php');
}
public function formAddQuanTri(){
    require_once('./views/taikhoan/quantri/addQuanTri.php');
    deleteSessionError();
}
public function postAddQuanTri() {
    // Ham nay de xu ly them du lieu
    // var_dump($_POST);

    // Kiem tra xem du lieu co duoc submit len kh
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lay ra du lieu
        $ho_ten = $_POST['ho_ten'];
        $email = $_POST['email'];

        // Tao 1 mang trong de chua du lieu
        $errors = [];
        if (empty($ho_ten)) {
            $errors['ho_ten'] = 'Họ tên khong duoc de trong';
        }
        if (empty($email)) {
            $errors['email'] = 'Email khong duoc de trong';
        }
        $_SESSION['error'] = $errors;

        // Neu khong co loi thi tien hanh them danh muc
        if (empty($errors)) {
            // Neu khong co loi thi tien hanh them danh muc
            // var_dump('oke');
           $password = password_hash('123456', PASSWORD_BCRYPT);
           $chuc_vu_id = 1;
            $this->modelTaiKhoan->insertTaiKhoan($ho_ten, $email, $password, $chuc_vu_id);
            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
            exit();

        } else {
            $_SESSION['flash'] = true;
            // Tra ve form vaf bao loi
            require_once('./views/taikhoan/quantri/addQuanTri.php');
        }
    }
}
public function formEditQuanTri(){
    $id_quan_tri = $_GET['id_quan_tri'];
     $quantri = $this->modelTaiKhoan->getDetailTaiKhoan($id_quan_tri);
     
    require_once('./views/taikhoan/quantri/editQuanTri.php');
    deleteSessionError();
}
public function postEditQuanTri(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      
        // Lay ra du lieu
       $id = $_POST['id'];
       $ho_ten = $_POST['ho_ten'];
       $email = $_POST['email'];
      $so_dien_thoai = $_POST['so_dien_thoai'];
       $trang_thai= $_POST['trang_thai'];
       
        $errors = [];
        if (empty($ho_ten)) {
            $errors['ho_ten'] = 'Họ tên Không được Để Trống';
        }
        if (empty($email)) {
            $errors['email'] = 'Email Không được Để Trống';
        }
        if (!isset($trang_thai) || !in_array($trang_thai, ['1', '0'], true)) {
            $errors['trang_thai'] = 'Trạng thái không hợp lệ hoặc chưa được chọn.';
        }
         $_SESSION['error'] = $errors;
         
           
        if (empty($errors)) {
            $this->modelTaiKhoan->updateTaiKhoan($id, $ho_ten, $email, $so_dien_thoai, $trang_thai);
            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
            exit();         
        } else {
            $_SESSION['flash'] = true;
            $_SESSION['error'] = $errors;
             // Neu co loi thi tra ve form va bao loi
             header("Location: " . BASE_URL_ADMIN . '?act=form-sua-quan-tri&id_quan_tri='. $id);
             exit();
           
        }
       
    }
}
public function resetPassword(){
    $id_quan_tri = $_GET['id_quan_tri'];
    $tai_khoan= $this->modelTaiKhoan->getDetailTaiKhoan($tai_khoan_id)
    $password = password_hash('123456', PASSWORD_BCRYPT);
    $Status =$this->modelTaiKhoan->restPassword( $password, $id_quan_tri);
   if($Status && $tai_khoan['chuc_vu_id'] == 1 ){
    header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
    exit();
    elseif($Status && $tai_khoan['chuc_vu_id'] == 2 ){
        header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang');
   }else{
    var_dump('khong thanh cong');
   }    
    
}

public function danhSachKhachHang()
{
    $listKhachHang = $this->modelTaiKhoan->getAllTaiKhoan(2);

    require_once('./views/taikhoan/khachhang/listKhachHang.php');
}
public function formEditKhachHang(){
    $id_khach_hang = $_GET['id_khach_hang'];
     $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);
     
    require_once('./views/taikhoan/khachhang/editKhachHang.php');
    deleteSessionError();
}

public function postEditKhachHang(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      
        // Lay ra du lieu
       $khach_hang_id = $_POST['khach_hang_id'];
       $ho_ten = $_POST['ho_ten'];
       $email = $_POST['email'];
       $so_dien_thoai = $_POST['so_dien_thoai'];
       $ngay_sinh = $_POST['ngay_sinh'];
       $gioi_tinh = $_POST['gioi_tinh'];
       $dia_chi = $_POST['dia_chi'];
       $trang_thai= $_POST['trang_thai'];
       
        $errors = [];
        if (empty($ho_ten)) {
            $errors['ho_ten'] = 'Họ tên Không được Để Trống';
        }
        if (empty($email)) {
            $errors['email'] = 'Email Không được Để Trống';
        }
        if (empty($ngay_sinh)) {
            $errors['ngay_sinh'] = 'Ngày sinh Không được Để Trống';
        }
        if (empty($gioi_tinh)) {
            $errors['gioi_tinh'] = 'Giới tính hông được Để Trống';
        }
        if (!isset($trang_thai) || !in_array($trang_thai, ['1', '0'], true)) {
            $errors['trang_thai'] = 'Trạng thái không hợp lệ hoặc chưa được chọn.';
        }
         $_SESSION['error'] = $errors;
         
           
        if (empty($errors)) {
            $this->modelTaiKhoan->updateKhachHang($khach_hang_id, $ho_ten, $email, $so_dien_thoai, $ngay_sinh, $gioi_tinh, $dia_chi, $trang_thai);
            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang');
            exit();         
        } else {
            $_SESSION['flash'] = true;
            $_SESSION['error'] = $errors;
             // Neu co loi thi tra ve form va bao loi
             header("Location: " . BASE_URL_ADMIN . '?act=form-sua-khach-hang&id_khach_hang='. $khach_hang_id);
             exit();
           
        }
       
    }
}
public function detailKhachHang(){
    $id_khach_hang = $_GET['id_khach_hang'];
    $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);

    $listDonHang = $this->modelDonHang->getDonHangFromKhachHang($id_khach_hang);
    
    $listBinhLuan =$this->modelSanPham->getBinhLuanFromKhachHang($id_khach_hang)
    require_once './views/taikhoan/khachhang/detailKhachHang.php';
}
}
}
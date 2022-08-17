
<?php
    include 'form.html';

    require './vendor/autoload.php';

    use Connect_DB\Drive\DB_Drive as DB_Drive;
    
    $DB = new DB_Drive(); 

function execute_update()
{
    $DB=$GLOBALS['DB'];

    //Thực Hiện Lấy Dữ Liệu Các MaNV từ DataBase ra
    $list= $DB->get_list("SELECT  MaNV FROM nhanvien");
    $list_idnv=array();
    for($i=0; $i < count($list) ; $i++ )
    {   //đẩy các MaNV sang mảng mới
        $list_idnv[]= $list[$i]['MaNV'];
    }

    if(!in_array($_POST['idnv'],$list_idnv))
    {   //nếu không có MaNV nhập vào thì:
        echo "Không tồn tại nhân viên bạn muốn Update";
    }
    else
    {
        $DB->update('nhanvien', [ 'HoTen'=>$_POST['name'],
                              'MaNV'=>$_POST['idnv'],
                              'Tuoi'=>$_POST['age'],
                              'GioiTinh'=>$_POST['gener'],
                              'QueQuan'=>$_POST['country']],

                        /*Where */ "MaNV="."'".$_POST['idnv']."'"); 
    }

}
if(isset($_POST['submit']))
{
    execute_update();
}

?>

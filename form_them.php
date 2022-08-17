
<?php
    include 'form.html';
    require './vendor/autoload.php';

    use Connect_DB\Drive\DB_Drive as DB_Drive;
    
    $DB = new DB_Drive();

    

function execute_add(){
    $DB = $GLOBALS['DB'] ;
    if($_POST['name']==''||$_POST['idnv']==''||$_POST['age']==''||$_POST['gener']==''||$_POST['country']=='')
    {
        echo 'Cảnh Báo Bạn Chưa Nhập Đủ Thông Tin Xin Mời Nhập Lại!!!';
    }
    else
    {
        //Kiểm tra xem Đã tồn tại nhân viên chưa qua MaNV
        $list= $DB->get_list("SELECT  MaNV FROM nhanvien");
        $list_idnv=array();

        for($i=0; $i < count($list) ; $i++ )
        {
            $list_idnv[]= $list[$i]['MaNV'];
        }

        if(in_array($_POST['idnv'],$list_idnv))
        {
            echo"Nhân Viên Đã Tồn Tại";
        }   
        elseif(!preg_match("/^[a-zA-Z-' ]*$/",$_POST['name']))
        {   //Kiểm tra chỉ chưa các ký tự hợp lệ
            echo "Tên Nhập Không đúng do chưa kí tự không hợp lệ";
        }
        else
        {
            $DB->insert('nhanvien',['HoTen'=>$_POST['name'],
                            'MaNV'=>$_POST['idnv'],
                            'Tuoi'=>$_POST['age'],
                            'GioiTinh'=>$_POST['gener'],
                            'QueQuan'=>$_POST['country']] 
                        );

            echo 'Bạn Đã Thêm Nhân Viên Thành Công';
        }   
    }
};

if(isset($_POST['submit']))
{
    execute_add();
};

?>

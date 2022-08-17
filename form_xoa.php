<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="width:500px;margin:50px auto">

        <h3>Nhập Thông Tin Nhân Viên Cần Xóa:</h3>
        <label for="">Họ Tên:</label> <br>
        <input type="text" name="name"> <br> <br>

        <label for="">ID Nhân Viên:</label> <br>
        <input type="text" name="idnv"> <br> <br>
        <div style="display:flex">
            <input type="submit" value="Xóa"> 
        
            <a href="index.php" style="text-decoration:none">
                <div style="width:100px;height:30px;border:solid 1px silver;margin:10px;background-color:green;color:white;font-size:20px">
                    Hoàn Thành
                </div>
            </a>
        </div>
        
    </form>

    
    

    <?php
require './vendor/autoload.php';

use Connect_DB\Drive\DB_Drive as DB_Drive;

$DB = new DB_Drive();

$list= $DB->get_list("SELECT  MaNV FROM nhanvien");
$list_idnv=array();
for($i=0; $i < count($list) ; $i++ )
{   //đẩy các MaNV sang mảng mới
    $list_idnv[]= $list[$i]['MaNV'];
}

if($_POST['name']==''||$_POST['idnv']=='')
{
    echo 'Cảnh Báo Bạn Chưa Nhập Đủ Thông Tin Xin Mời Nhập Lại!!!';
}   
elseif(!in_array($_POST['idnv'],$list_idnv))
{
    echo "Không Có Nhân Viên Bạn Cần Xóa";
}
else{
    $DB->delete('nhanvien',"MaNV = '".$_POST['idnv']."'");
}


?>
</body>
</html>
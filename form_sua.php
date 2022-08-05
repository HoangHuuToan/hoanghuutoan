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

        <label for="">Họ Tên:</label> <br>
        <input type="text" name="name"> <br> <br>

        <label for="">ID Nhân Viên:</label> <br>
        <input type="text" name="idnv"> <br> <br>

        <label for="">Tuổi</label> <br>
        <input type="text" name="age"> <br> <br>

        <label for="">Giới Tính</label> <br>
        <input type="radio" name="gener" value="Nam"> Nam <br>
        <input type="radio" name="gener" value="Nữ"> Nữ <br> <br>

        <label for="">Quê Quán</label> <br>
        <input type="text" name="country"> <br> <br>

        <input type="submit" value="Sửa">
    </form>

    <?php
class DB_Driver
{
    /*biến lưu trữ địa chỉ,phương thức connect*/

    public $servername = 'localhost';
    public $database = 'mydatabase';
    public $username = 'huutoan';
    public $password = 'Toandz31052002';

    private $__conn;


    /*Function kết nối:*/
    function connect()
    {
        if (!$this->__conn) {
            /*Kết nối*/
            $this->__conn = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
            /*Check*/
            if ($this->__conn->connect_error) {
                die('Lỗi kết nối' . $this->__conn->connect_error);
            }
            /*xử lý truy vấn UTF-8 tránh lỗi phông*/
            mysqli_query($this->__conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
            echo 'connect successfully';
        }
    }
    function dis_connect()
    {
        if ($this->__conn) {
            mysqli_close($this->__conn);
        }
    }
    function insert($table, $data)
    {
        /*Thực hiện kết nối:*/
        $this->connect();
        /*biến lưu trữ các field*/
        $list_field = '';
        /*biến lưu trữ các value*/
        $list_value = '';

        //lặp qua data
        foreach ($data as $key => $value) {
            $list_field = $list_field . ",$key";
            $list_value = $list_value . ",'" . mysqli_real_escape_string($this->__conn, $value) . "'";
        }
        $sql = 'INSERT INTO ' . $table . '(' . trim($list_field, ',') . ') VALUES (' . trim($list_value, ',') . ')';

        return mysqli_query($this->__conn, $sql); //insert thành công trả ra [true] không thành công ra [false]
    }
    function update($table, $data, $where)
    {
        $this->connect();
        $sql = '';
        //Lặp qua data
        foreach ($data as $key => $value) {
            $sql = $sql."$key='".mysqli_real_escape_string($this->__conn, $value)."',";
        }
        $sql = "UPDATE " . $table . " set " . trim($sql, ',') . " WHERE " . $where;

        return mysqli_query($this->__conn, $sql);
    }
    function delete($table, $data, $where)
    {
        $this->connect();
        $sql = '';
        //lặp data
        foreach ($data as $key => $value) {
            $sql = 'DELETE FROM ' . $table . ' WHERE' . $where;
        }

        return mysqli_query($this->__conn, $sql);
    }
    function get_list($sql)
    {
        $this->connect();
        $result = mysqli_query($this->__conn, $sql);
        if (!$result) {
            die('Câu truy vấn sai');
        }
        $return = array();
        //Duyệt qua kết quả để đưa vào mảng trả về
        while ($row = mysqli_fetch_assoc($result)) {
            $return[] = $row;
        }
        // Xóa kết quả khỏi bộ nhớ
        mysqli_free_result($result);

        return $return;

    }
    function get_row($sql)
    {
        // Kết nối
        $this->connect();

        $result = mysqli_query($this->__conn, $sql);

        if (!$result) {
            die('Câu truy vấn bị sai');
        }

        //duyệt kết quả thành mảng liên kết
        $row = mysqli_fetch_assoc($result);

        // Xóa kết quả khỏi bộ nhớ
        mysqli_free_result($result);

        if ($row) {
            return $row;
        }

        return false;
    }
}

$DB = new DB_Driver;

$DB->update('nhanvien', [ 'HoTen'=>$_POST['name'],
                        'IDNhanVien'=>$_POST['idnv'],
                        'Tuoi'=>$_POST['age'],
                        'GioiTinh'=>$_POST['gener'],
                        'QueQuan'=>$_POST['country']],
                        " IDNhanVien="."'".$_POST['idnv']."'"); 

?>
</body>
</html>
<?php

    namespace Connect_DB\Drive;

    class DB_Drive
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
    function delete($table, $where){
        // Kết nối
        $this->connect();
     
        // Delete
        $sql = "DELETE FROM $table WHERE $where";
        $result = mysqli_query($this->__conn, $sql);
        if(!$result)
        {
            die('Không tồn tại dữ liệu bạn muốn xóa');
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

?>
<?php
/*
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/dashboard/');
	exit;
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="text" id="user_name" name="user_name">
        <input type="text" id="user_id" name="user_id">
        <input type="text" id="user_address" name="user_address">
        <input type="text" id="user_ranking" name="user_ranking">
        <input type="submit" value="Nhập" onclick="$DB->connect()">
    </form>

<?php
/*
class User
{
    public $name;
    public $id;
    public $address;
    public $ranking;

    function __construct($Name, $Id, $Address, $Ranking)
    {
        $this->name = $Name;
        $this->id = $Id;
        $this->address = $Address;
        $this->ranking = $Ranking;
    }
    function getName()
    {
        echo $this->name;
    }
}
*/
/*________________ 
$myArrUser = array();

function add_user()
{*/
    /*Trong hàm muốn gọi đến sử dụng 1 biến toàn cục bên ngoài phải khai báo:
    global $myArrUser;
    $user_one = new User($_POST['user_name'], $_POST['user_id'], $_POST['user_address'], $_POST['user_ranking']);
    $myArrUser[] = $user_one;
}
; */
/*
if (isset($_POST)) 
{
    add_user();
}
print_r($myArrUser);


/*______________________________ 
echo '<br>' . '<br>' . '<br>' . '<br>';
$myNumber = 10.2233;

echo min(10, 20, 30, 5, 50, -1);

define("cars", [
    "Alfa Romeo",
    "BMW",
    "Toyota"
]);

echo "<br>";
var_dump(cars);

$h = 10;
function a(&$a)
{
    $a += 5;
}
;
a($h);
echo $h;



$ages = ["Toàn" => 20, "Vĩnh" => 23, "Thảo" => 22, "Phúc" => 21];

foreach ($ages as $name => $age) 
{
    echo "Tên: " . $name . ",Tuổi: " . $age . '<br>';
}



echo '<br>' . '<br>' . '<br>' . '<br>';

class Students
{
    public $name;
    public $age;
    public $address;

    public function __construct($Name, $Age, $Address)
    {
        $this->name = $Name;
        $this->age = $Age;
        $this->address = $Address;
    }


}

$student1 = new Students('Toàn', 20, 'Hải Phòng');
$student2 = new Students('Vĩnh', 23, 'Phú Thọ');
$student3 = new Students('Thảo', 21, 'Bắc Zang');

$arrStudent = new ArrayObject();
$arrStudent[] = $student1;
$arrStudent[] = $student2;
$arrStudent[] = $student3;

var_dump($arrStudent);

*/

/*Kết nối với database bằng PDO(PHP Data Object)*/

/*5 biến nhận thông tin của database 
	$servername = 'servername';
	$database = 'database';
	$usernam = 'username';
	$password = 'password';
	$charset = 'utf8mb4';
*/
/*Cố gắng knoi
	try 
	{
		$dsn = "mysql:host=$servername;dbname=$database;charset=$charset";
		$pdo = new PDO($dsn, $usernam, $password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


		echo "Connect succesfully!!!";
		return $pdo;
	}
*/
/*Nếu xảy ra lỗi ( trường hợp ngoại lệ) xử lí ở đây 
	catch (PDOException $e) 
	{
		echo 'Connect failed:' . $e->getMessage();
	}
*/


/*Kết nối với database bằng mysqli

	$servername = 'servername';
	$database = 'database';
	$usernam = 'username';
	$password = 'password';

	$connect = mysqli_connect($servername, $username, $password, $database);

	if ($connect->connect_error) 
	{
		die('Connect failed :' . $connect->connect_error);
	}
	echo 'connect successfully';
	mysqli_close($connect);
*/


/*Xây dựng class để xử lí các kết nối đến database */
	echo '<h1>Connect Database</h1>';
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
        if (!$this -> __conn) {
            /*Kết nối*/
            $this->__conn = mysqli_connect($this->servername,$this->username,$this->password,$this->database);
            /*Check*/
            if ($this->__conn -> connect_error){
                die('Lỗi kết nối' .$this->__conn->connect_error);
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
        $list_field='';
        /*biến lưu trữ các value*/
        $list_value='';

        //lặp qua data
        foreach($data as $key => $value)
        {
            $list_field= $list_field.",$key";
            $list_value= $list_value.",'".mysqli_real_escape_string($this->__conn,$value)."'";
        }   
        $sql = 'INSERT INTO '.$table.'('.trim($list_field,',').') VALUES ('.trim($list_value, ',').')';
 
        return mysqli_query($this->__conn, $sql);//insert thành công trả ra [true] không thành công ra [false]
    }
    function update($table, $data, $where)
    {
		$this->connect();
		$sql='';
		//Lặp qua data
		foreach($data as $key => $value)
		{
			$sql= $sql."$key='".mysqli_real_escape_string($this->__conn,$value)."',";
		}
        $sql = "UPDATE " .$table ." set " .trim($sql,',')." WHERE ".$where ;
        return mysqli_query($this->__conn, $sql);
    }   
    function delete($table, $where){
        // Kết nối
        $this->connect();
     
        // Delete
        $sql = "DELETE FROM $table WHERE $where";
        return mysqli_query($this->__conn, $sql);
    }
    function get_list($sql)
    {
        $this->connect();
        $result = mysqli_query($this->__conn,$sql);
        if(!$result)
        {
            die('Câu truy vấn sai');
        }
        $return = array();
        //Duyệt qua kết quả để đưa vào mảng trả về
        while($row = mysqli_fetch_assoc($result))
        {
            $return[]=$row;
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
 
    if (!$result){
        die ('Câu truy vấn bị sai');
    }
    
    //duyệt kết quả thành mảng liên kết
    $row = mysqli_fetch_assoc($result);
 
    // Xóa kết quả khỏi bộ nhớ
    mysqli_free_result($result);
 
    if ($row){
        return $row;
    }
 
    return false;
    }
}

$DB = new DB_Driver;


echo '<br>';    
$result = $DB->get_list('SELECT * FROM nhanvien');

var_dump($result);

echo    '<table style="border:1px solid black;"border="1" class="table_dl" cellpadding="0" cellspacing="0">
            <tr>
                <th>Họ Tên</th>
                <th>ID Nhân Viên</th>
                <th>Tuổi</th>
                <th>Giới Tính</th>
                <th>Quê Quán</th>
            </tr>';
foreach($result as $key => $value)
{
    echo    '<tr>
                <td>'.$value['HoTen'].'</td>
                <td>'.$value['IDNhanVien'].'</td>
                <td>'.$value['Tuoi'].'</td>
                <td>'.$value['GioiTinh'].'</td>
                <td>'.$value['QueQuan'].'</td>
            <tr>';
}            
echo '</table>';



/*
$DB->insert('nhanvien',['HoTen'=>'Vĩnh','Tuoi'=>22,'GioiTinh'=>'Nu','QueQuan'=>'Vĩnh Phúc']);
*/
?>

<div class="list_btn">

    <a href="form_them.php">
        <button id="btn_add" class="btn add">Thêm Mới Nhân Viên</button>
    </a>
    
    <a href="form_sua.php">
        <button class="btn edit">Sửa Nhân Viên</button>
    </a>
</div>
   <script src="js.js">
    
   </script>
</body>
</html>




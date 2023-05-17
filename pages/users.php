<?php
ini_set('display_errors', '1');
echo "this is users.php";

$host = 'localhost'; //имя хоста, на локальном компьютере это localhost
		$user = 'root'; //имя пользователя, по умолчанию это root
		$password = 'root'; //пароль, по умолчанию пустой
		$db_name = 'testtable'; //имя базы данных
 
	//Соединяемся с базой данных используя наши доступы:
    $db = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);

        $query2 = 'SELECT * FROM users';
//$result2 = mysqli_query($link, $query2);
$result2 =$db->query($query2);
//var_dump($result2);
echo "<br>";
echo "<br>";
//$data = mysqli_fetch_assoc($result);



//for ($dataall2 = []; $row = mysqli_fetch_assoc($result2); $dataall2[] = $row);

$dataall2 = $result2->FetchAll(PDO::FETCH_ASSOC);

//var_dump($dataall2);

echo "<br>";
echo "<br>";
//echo count($dataall2);
?>

<?php //echo $dataall2[0]['id'] ?>

<table>
  <tbody>
    <tr>
      <td>id</td>
      <td>login</td>
      <td>password</td>
      <td>ip</td>
    </tr>
    
    <?php
    for ($i=0; $i<count($dataall2); $i++) { ?>
        <tr>
        <td><?php echo $dataall2[$i]['user_id'] ?></td>
        <td><?php echo $dataall2[$i]['user_login'] ?></td>
        <td><?php echo $dataall2[$i]['user_password'] ?></td>
        <td><?php echo $dataall2[$i]['user_ip'] ?></td>
      </tr>
      <?php
    }
    ?>
    
  </tbody>
</table>
<a href="../index.php">main</a>
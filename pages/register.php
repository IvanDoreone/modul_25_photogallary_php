<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title></title>
</head>
<body>

<?php
//вывод ошибок и функция генерации случайной строки для хэша
ini_set('display_errors', '1');
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}
// Соединяемся с БД
$host = 'localhost'; //имя хоста, на локальном компьютере это localhost
$user = 'root'; //имя пользователя, по умолчанию это root
$password = 'root'; //пароль 
$db_name = 'testtable'; //имя базы данных


$link=mysqli_connect($host, $user, $password, $db_name); 

if(isset($_POST['submit']))
{
    $err = [];
    // проверяем логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    } 
    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    } 
    // проверяем, не существует ли пользователя с таким именем
    $query = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
        ?>
        <p><a href="login.php">Авторизуйтесь здесь<a></p>
        <?php
    } 
    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {
        $login = $_POST['login'];
        // Убираем лишние пробелы и делаем двойное хэширование (используем старый метод md5)
        $password = md5(md5(trim($_POST['password']))); 
        mysqli_query($link,"INSERT INTO users SET user_login='".$login."', user_password='".$password."'");

        // Вытаскиваем из БД запись, у которой логин равняется введенному
    $query = mysqli_query($link,"SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link,$_POST['login'])."' LIMIT 1");
    $data = mysqli_fetch_assoc($query); 

        $hash = md5(generateCode(10));
 
        if(empty($_POST['not_attach_ip']))
        {
            // Если пользователя выбрал привязку к IP
            // Переводим IP в строку
            $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
            
        } 
        // Записываем в БД новый хеш авторизации и IP
        mysqli_query($link, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'"); 
        // Ставим куки
        setcookie("id", $data['user_id'], time()+60*60*24*30, HttpOnly);
        setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true); // httponly !!! 
        setcookie("user_name", $data['user_login'], time()+60*60*24*30, "/", null, null, true); // httponly !!!
        // Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: check.php"); exit();
    }
    else
    {
        print "<b>При регистрации произошли следующие ошибки:</b><br>";
        //вывод списка ошибок
        foreach($err AS $error)
        {
            print $error."<br>";
        }
    }
}
?> 

<div class="container pt-4">
<form method="POST">
<div class="mb-3">
<p>Логин <input name="login" type="text" class="form-control" autocomplete="off" placeholder="только цифры и латинские бункы от 3 до 30 символов" required><br></p>
<p>Пароль <input name="password" type="password" class="form-control" autocomplete="off" placeholder="придумайте и введите пароль" required><br></p>
<p>Не прикреплять к IP(не безопасно) <input type="checkbox" name="not_attach_ip"><br></p>
<p><input name="submit" type="submit" value="Зарегистрироваться" class="btn btn-outline-success"></p>

</form>
<p>Уже зарегистированны? пройдите авторизацию на главной странице:</p>

<a href="../index.php">Врнуться на главную страницу</a>
</div>
</body>
</html>

<?php
ini_set('display_errors', '1');
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
print "Привет, ".$_COOKIE['user_name'].". Это ваш личный кабинет!";
}
else {
    echo "пройдите регистрацию или авторизуйтесь";
}

if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{ 
 ?> <p><a href="logout.php">Выйти  </a><a href="../index.php">  Вернуться на главную страницу</a></p> <?php } ?>
 

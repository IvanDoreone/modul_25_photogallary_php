<?php
// Страница разавторизации 
// Удаляем куки
setcookie("id", "", time());
setcookie("hash", "", time() - 3600*24*30*12, "/",null,null,true); // httponly !!! 
setcookie("user_name", "", time() - 3600*24*30*12, "/");
// Переадресовываем браузер на страницу проверки нашего скрипта
header("Location: ../index.php"); exit(); 
?>

<?php
 
define('URL', 'index.php'); // URL страницы с галереей
define('UPLOAD_MAX_SIZE', 1000000); // ставим макс 1mb
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
define('UPLOAD_DIR', 'uploads');
 
$errors = [];
 
if (!empty($_FILES)) {
 
    for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
 
        $fileName = $_FILES['files']['name'][$i];
 
        if ($_FILES['files']['size'][$i] > UPLOAD_MAX_SIZE) {
            $errors[] = 'Недопустимый размер файла ' . $fileName;
            continue;
        }
 
        if (!in_array($_FILES['files']['type'][$i], ALLOWED_TYPES)) {
            $errors[] = 'Недопустимый формат файла ' . $fileName;
            continue;
        }
        
 
        $filePath = UPLOAD_DIR . '/' . basename($fileName);

        if (file_exists($filePath)) {
            $errors[] = 'Этот файл уже загружен (' . $fileName.') Выберете другой... ' ;
            continue;
        }
 //проверка та то что файл уже загружен
        if (!move_uploaded_file($_FILES['files']['tmp_name'][$i], $filePath)) {
            $errors[] = 'Ошибка загрузки файла ' . $fileName;
            continue;
        }
    }
}
 
?>
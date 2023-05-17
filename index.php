<?php 
ini_set('display_errors', '1'); 
include 'config/validephoto.php';


$host = 'localhost'; //имя хоста, на локальном компьютере это localhost
		$user = 'root'; //имя пользователя, по умолчанию это root
		$password = 'root'; //пароль
		$db_name = 'testtable'; //имя базы данных
 
	//готовим запрос на добавление в базу данных информации по загружунным фоткам
    $db = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);

    $preq = $db->prepare("INSERT INTO photos (`filename`, `link`, `date`, `owner`) VALUES (:filename, :link, :date, :name)");
    $preq->bindParam(':filename', $fileName);
    $preq->bindParam(':link', $filePath);
    $preq->bindParam(':date', $date);
    $preq->bindParam(':name', $name_user);
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>фотогалерея</title>
</head>
<body>
  <header>
    <div>
  <?php
  //приветсвие заргестрированному пользователю или вывод формы авторизации
if (isset($_COOKIE['user_name'])) {
  ?>
  <div class="container pt-4">
    <?php
  echo "Добро пожаловать, ".$_COOKIE['user_name']."!";
  ?>
  <p><a href="pages/logout.php"> Выйти </a><a href="pages/users.php"> Список пользователей </a>  <a href="pages/lk.php"> ЛК </a></p>
</div>
<?php }
else {
  ?>
  <div class="container pt-4">
    <?php
  echo "Для того, чтобы загрузить фото или оставить комментарии, зарегистрируйтесь или авторизуйтесь:";
  
  include 'pages/login.php';
  ?>
  <p><a href="pages/register.php"> Регистрация </a></p>
</div>

  <?php } ?>
    <div>
  <header>

<div class="container pt-4">
    <h1 class="mb-4">Загрузить фото</h1>
 
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php
  
    endif; ?>
 
    <?php if (!empty($_FILES) && empty($errors)): ?>
        <div class="alert alert-success">Файлы успешно загружены</div>
        
    <?php
    //запись данных о загруженном фото в БД
  $fileName = $fileName;
  $filePath = $filePath;
  $date = date('d-m-Y H:i', (time()+10800));
  $name_user = $_COOKIE['user_name'];
  $preq->execute();

  endif; ?>
 
    <form action="<?php echo URL; ?>" method="post" enctype="multipart/form-data">
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="files[]" id="customFile" multiple required>
            <label class="custom-file-label" for="customFile" data-browse="Выбрать">Выберите файлы</label>
            <small class="form-text text-muted">
                Максимальный размер файла: <?php echo UPLOAD_MAX_SIZE / 1000000; ?>Мб.
                Допустимые форматы: <?php echo implode(', ', ALLOWED_TYPES) ?>.
            </small>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Загрузить</button>
        <a href="<?php echo URL; ?>" class="btn btn-secondary ml-3">Сброс</a>
    </form>
</div>
 
<!-- Вывод галереи в таблицу -->
<div class="container pt-4">
<h2 class="mb-4">Галерея</h2>

<table class="table table-bordered">
  <tbody>
    <tr>
      <td>#</td>
      <td>превьюшка</td>
      <td>кто загрузил</td>
      <td>время загрузки</td>
      <td>комментарии</td>

    </tr>
    <?php
    $sql = "SELECT * FROM photos ORDER BY date DESC";
    $stmt = $db->query($sql);
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
    if (isset($result)) {
    for ($i=0; $i<count($result); $i++) { 
      $structure = 'comments/'.$result[$i]['id'];
      //создаем подпапку в папке /comments с названием = id фотки, которую комментируют
      if (!is_dir($structure)) {
      mkdir($structure, 0700);
      }?>
        <tr id="<?php echo $result[$i]['filename'] ?>">
        <td><?php echo ($i+1) ?></td>
        <td><a href="<?php echo $result[$i]['link'] ?>"><img src="<?php echo $result[$i]['link'] ?>" width = "300px"></a></td>
        <td><?php echo $result[$i]['owner'] ?>
        

        <?php
          if (isset($_COOKIE['user_name']) && $_COOKIE['user_name'] == $result[$i]['owner']) {
            ?>
      <form method='POST'>
      <input type="hidden" name="delate_id" value="<?php echo $result[$i]['filename'] ?>">
        
        <input type="submit" value="удалить фото" class="btn btn-outline-primary btn-sm">
      </form> 
      </p>
      <?php
          }
?>
    
      </td>
        <td><?php echo $result[$i]['date'] ?></td>
        <td>
        <p> 
          <?php
          if (isset($_COOKIE['user_name'])) {
            ?>
      <form method='GET'  id="<?php echo $result[$i]['id'] ?>">
      <input type="hidden" name="photo_id" value="<?php echo $result[$i]['id'] ?>">
        <input type="text" class="form-control" name="comment" size="45%">
        <input type="submit" value="оставить комментарий" class="btn btn-outline-primary btn-sm">
      </form> 
      </p>
      <?php
          }
          //записываем коммент (если создан) в файл и помещаем в подпапку по id фотки
      if(isset($_GET['comment']))
{
  $name_user1 = $_COOKIE['user_name'];
  $contt = '<div id='.$_COOKIE['user_name'].'>'.$_GET['comment'].'</div>';
  if (isset($_GET['comment'])) {
  $file = fopen('comments/'.$_GET['photo_id'].'/'.$name_user1.'_'.time().'txt', 'a');
  fwrite($file, $contt);
  fclose($file);
  }
  //сбрасываем данные GET что бы не появлялся повторный коммент при перезагрузке страницы
  unset($_GET['comment']);
  header('location: index.php');

}
?>
        <div id="<?php echo $result[$i]['id'] ?>">
        <?php 
    
      //выводим кнопку удалить комментрарий для пользователя, который его оставлял 
      for ($k=2; $k<count(scandir($structure)); $k++) {
        echo file_get_contents($structure.'/'.scandir($structure)[$k]); 
        
        //echo(explode('_', scandir($structure)[$k])[0]);
        if (isset($_COOKIE['user_name'])) {
if ((explode('_', scandir($structure)[$k])[0]) == $_COOKIE['user_name']) {
        ?>
        <form method='GET'>
        <input type="hidden" name="button_id" value="<?php echo $structure.'/'.scandir($structure)[$k] ?>">
          
          <input type="submit" value="удалить комментарий" class="btn btn-outline-danger btn-sm">
        </form> 
        <?php
      }}}
//удаляем коммент (файл с ним) по нажатию кнопки
      if (isset($_GET['button_id'])) {
        unlink($_GET['button_id']);
        header('location: index.php');
      }
      ?>
            </div>
    
      <?php
    }}
    ?>
  </tbody>
</table>
</div>
<?php
if(isset($_POST['delate_id']))
{
  if(file_exists('uploads/'.$_POST['delate_id'])) {
  unlink('uploads/'.$_POST['delate_id']);
  }
  $targett = $_POST['delate_id'];
  $sql1 = "DELETE  FROM  photos WHERE filename = '$targett'";
  //DELETE FROM photos WHERE filename = 'meatball4.jpg'
  $db->exec($sql1);
  unset($_POST);

  //скрипт JS что бы сразу убрать строку с удаленной картинкой, без дополнительной перезхагрузки страницы
  ?>
<script>document.getElementById("<?php echo $targett ?>").remove();;</script>
 
<?php
  }
?>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input@1.3.4/dist/bs-custom-file-input.min.js"></script>
<script>
    $(() => {
        bsCustomFileInput.init();
    })
</script>
</body>
</html>





<?php

//echo 'upload_max_filesize in bytes = ' . return_bytes(ini_get('upload_max_filesize'));
//echo '<br />post_max_size in bytes = ' . return_bytes(ini_get('post_max_size'));
session_start();

$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$address_site = $protocol.$_SERVER['SERVER_NAME']; // Адрес сайта


//Проверяем была ли отправлена форма, то есть была ли нажата кнопка “Загрузить изображение”. Если да, то идём дальше, если нет, то выведем пользователю сообщение об ошибке.
if(!isset($_POST['upload_image'])){

    if(isset($_GET['flag']) && !empty($_SERVER['HTTP_REFERER'])){
        // Сохраняем в сессию сообщение об ошибке.
        $_SESSION["server_messages"] = "<p class='text-danger font-weight-bold'>Ошибка! Размер загруженного изображения превышает 3MB </p>";

    }else{

        // Сохраняем в сессию сообщение об ошибке.
        $_SESSION["server_messages"] = "<p class='text-danger font-weight-bold'>Ошибка! Вы зашли в обработчик формы напрямую, поэтому нет данных для обработки. </p>";
    }

    //Возвращаем пользователя обратно на страницу загрузки изображения
    header("Location: ".$address_site);

    exit();
}

// (1) метка: Место для следующего куска кода

// указываем какие MIME-типы разрешены для загрузки
$allow_types = ['image/jpeg', 'image/png'];

// проверяем MIME-тип загруженного файла и если данный тип не находятся в массиве с разрешенными типами,
// то, возвращаем пользователя обратно на страницу загрузки и выводим ему соответствующее сообщение об ошибке
if(!in_array($_FILES['file_img']['type'], $allow_types)){

    // Сохраняем в сессию сообщение об ошибке.
    $_SESSION["server_messages"] = "<p class='text-danger font-weight-bold'>Ошибка! Выбранный вами файл не является изображением </p>";

    //Возвращаем пользователя обратно на страницу загрузки изображения
    header("Location: ".$address_site);

    //Останавливаем скрипт
    exit();
}

// (2) метка: Место для следующего куска кода

// Массив с разрешенными расшерениями
$allow_extensions = ['jpg', 'jpeg', 'png'];

// Узнаем расирение загруженного файла
$extension_file =  pathinfo( $_FILES['file_img']['name'], PATHINFO_EXTENSION );

if(!in_array($extension_file, $allow_extensions)){
    // Если расширение загруженного файла не находится в массиве с разрешенными расшерениями,
    // то, останавливаем скрипт
    exit();
}


// (3) метка: Место для следующего куска кода
if($_FILES['file_img']['size'] > return_bytes('3M')){
    // Если размер загруженного изображения превышает 3MB то возвращаем ошибку

    // Сохраняем в сессию сообщение об ошибке.
    $_SESSION["server_messages"] = "<p class='text-danger font-weight-bold'>Ошибка! Размер загруженного изображения превышает 3MB</p>";

    //Возвращаем пользователя обратно на страницу загрузки изображения
    header("Location: ".$address_site);

    //Останавливаем скрипт
    exit();
}

// Перемещаем изображение в нужную папку
$result_move = move_uploaded_file($_FILES['file_img']['tmp_name'], 'images/'.$_FILES['file_img']['name']);

if(!$result_move){

    // В случае возникновения какой-то ошибки при загрузке файла

    // Сохраняем в сессию сообщение об ошибке.
    $_SESSION["server_messages"] = "<p class='text-danger font-weight-bold'>Ошибка! Не удалось загрузить файл</p>";

    //Возвращаем пользователя обратно на страницу загрузки изображения
    header("Location: ".$address_site);

    //Останавливаем скрипт
    exit();
}

// Если загрузка файла было выполнено успешно, выводим пользователю соответствующее сообщение

// Сохраняем в сессию сообщение об ошибке.
$_SESSION["server_messages"] = "<p class='text-success font-weight-bold'>Файл загружен успешно!!!</p>";

//Возвращаем пользователя обратно на страницу загрузки изображения
header("Location: ".$address_site);

//Останавливаем скрипт
exit();


function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // Модификатор 'G' доступен с PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}
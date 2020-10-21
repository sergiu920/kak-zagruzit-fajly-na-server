<?php
session_start();

$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$address_site = $protocol.$_SERVER['SERVER_NAME']; // Адрес сайта

/*
    Проверяем была ли отправлена форма, то есть была ли нажата кнопка “Загрузить изображение”. Если да, то идём дальше, если нет, то выведем пользователю сообщение об ошибке.
*/
if(!isset($_POST["upload_image"])){

    exit("<p><strong>Ошибка!</strong> Вы зашли в обработчик формы напрямую, поэтому нет данных для обработки.</p><p> Вы можете перейти на <a href=".$address_site."> главную страницу сайта </a> </p>");
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


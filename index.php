<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Как загрузить файл на сервер</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>

    <div class="container">

        <div class="row">

            <div class="col-md-12">
                <form action="upload-one-file.php" method="POST" enctype="multipart/form-data" class="form-inline md-form">

                    <p class="text-info">Разрешается к загрузки только изображения в формате jpg или png</p>
                    <p class="text-info">Максимальный размер загружаемого файла, не должно превысить 10MB</p>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="file_img" id="file_img" required>
                        </div>
                    </div>

                    <button type="submit" name="upload_image" class="btn btn-primary">Загрузить изображение</button>
                </form>
                <?php
                    if(isset($_SESSION["server_messages"])){
                ?>
                        <div class="server_messages">
                            <?php echo $_SESSION["server_messages"] ?>
                        </div>
                <?php
                        //Уничтожаем чтобы не появилось заново при обновлении страницы
                        unset($_SESSION["server_messages"]);
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
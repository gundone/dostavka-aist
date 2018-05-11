<?php
    require_once(dirname(__FILE__) . '/wp-config.php');
    $wp->init();
    $wp->parse_request();
    $wp->query_posts();
    $wp->register_globals();
    $wp->send_headers();

    $uploaddir = getcwd() . '/wp-content/uploads/';
    $uploadfile = $uploaddir . basename($_FILES['files']['name']);
    update_option('siteurl', 'http://ex-do.local');
    update_option('home', 'http://ex-do.local');
    define('FORCE_SSL_ADMIN', false);
    echo '<pre>';
    echo admin_url('admin.php');
//    if (move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile)) {
//        echo "Upload success\n";
//    } else {
//        echo "Upload failure\n";
//    }
//
//    echo 'Некоторая отладочная информация:';
//    print_r($_FILES);
//
//    print "</pre>";


?>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="files"/>
<input type ="submit" value="Загрузить файл"/>
</form>


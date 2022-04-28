<?php
// VERITABANI AYARLARI
define('DB_HOST', 'localhost');
define('DB_NAME', 'todo');          // Veritabanı Adı
define('DB_USERNAME', 'root');      // Kullanıcı Adı
define('DB_PASSWORD', '');          // Şifre
define('DB_CHARSET', 'utf8mb4');

function post($name){
    if (isset($_POST[$name]) && !empty($_POST[$name])){
        return htmlspecialchars($_POST[$name]);
    }
}
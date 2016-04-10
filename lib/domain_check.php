<?php
if ((strpos($_SERVER['HTTP_HOST'], 'www.') === false)){
    header('Location: http://www.'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
    exit();
}
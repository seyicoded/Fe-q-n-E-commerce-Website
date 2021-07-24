<?php
    setcookie(md5("admin_signed_in"),sha1("true"),( time() - (86400 * 366)), "/");
    setcookie(md5("admin_authen"),base64_encode($authen),( time() - (86400 * 366)), "/");
    header("Location:homepage.php");
?>
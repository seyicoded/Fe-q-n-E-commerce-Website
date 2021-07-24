<?php
    //include config for health doctor
    include('include.php');
    
    //inlcude config for db
    include('../../include/connectdb.php');
    $p = new db();
    $con = $p -> con();
    
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">           
        <title>FEMQUEN And Co. Int'l</title>
        <link rel="stylesheet" href="../../template/lib/w3.css">         
        <link rel="stylesheet" href="../../template/font-awesome/css/font-awesome.min.css">
        <link rel="icon" href="../../media/image/icon/icon.png" type="image/x-icon">
        <script type="text/javascript" src="../../template/js/jquerym.js"></script>
    </head>
    <body class="w3-container w3-padding-0 w3-margin-0" style="width: 100%; height: 100%; background: #ACACAC;">
        
        <iframe src="../files/" style="width:100%; height: 400px;"></iframe>
        
    </body>
</html>

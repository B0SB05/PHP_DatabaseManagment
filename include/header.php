<!DOCTYPE html>
<html>
    <head>
        <script src="include/javascriptLib/localJs.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    
    <body>
        <form>
            <?php

require_once './include/dbManagment.php';

$db = database::getInstance();
$databases = $db->queryDataBaseName();
?>

<?php

require_once './include/header.php';

if (isset($_GET["databasename"])) {
    $databaseName = $_GET["databasename"];
    $beanPath = "./$databaseName/_Beans";
    $tables = array();
    $directoryPath = "";
    //Bean Creation ....
    beanCreation($beanPath);
    //print_r(scandir("./$databaseName"));
    //Bean Services 
    $servicePath = "./$databaseName/_Services";
    beanService($servicePath, $tables);
    $databasePath = "./$databaseName/_DatabaseStore";
    database($databasePath);

    echo "<h2> Explore Directories ...</h2> $directoryPath";
    //printDirectory("./$databaseName");
}

function printDirectory($path) {

    foreach (scandir($path) as $value) {
        if (is_dir($value))
            printDirectory($value);
        else
            echo " > $value";
    }
}

function directoryCreation($directoryPath) {
    if (!file_exists($directoryPath))
        $dir = mkdir($directoryPath, 0755, true);
    else
        $dir = true;
    return $dir;
}

function fileCreation($filePath, $data) {
    if (!file_exists($filePath))
        return file_put_contents($filePath, $data);
}

function database($dbStore) { 
   
    if (directoryCreation($dbStore)) {

        $data = "<?php


class queryString {

    function initConnection() {
        return mysqli_connect(server, user, password, database);
    }

    public function queryExecuation($" . "sql,$" . "getID=false ) {
        $" . "connection = $" . "this->initConnection();
        mysqli_set_charset($" . "connection, \"utf-8\");
        return mysqli_query($" . "connection, $" . "sql);
}

    function unpacking($" . "sql) {
        $" . "totallSql = array();
        while ($" . "row = mysqli_fetch_row($" . "sql)) {
            $" . "jsonArray = array();
            foreach ($" . "row as $" . "key => $" . "value) {
                array_push($" . "jsonArray, ($" . "value));
            }
            array_push($" . "totallSql, $" . "jsonArray);
        }
        return json_encode($" . "totallSql);
    }

    function queryString($" . "tablename = null, $" . "select = false, $" . "delete = false, $" . "update = false, $" . "insert = false, $" . "condition = true, $" . "cols = \"*\", $" . "values = null) {

        if ($" . "tablename != null) {
            $" . "sqlString = \"\";
            if ($" . "select && !($" . "delete && $" . "update && $" . "insert)) {
                $" . "sqlString = \"select $" . "cols from $" . "tablename where $" . "condition;\";
            }

            if ($" . "delete && !($" . "select && $" . "update && $" . "insert)) {
                $" . "sqlString = \"delete from $" . "tablename where $" . "condition;\";
            }
            if ($" . "update && !($" . "delete && $" . "select && $" . "insert)) {
                $" . "sqlString = \"update $" . "tablename set $" . "cols where $" . "condition;\";
            }

            if ($" . "insert && !($" . "delete && $" . "select && $" . "update) && ($" . "values != null) && $" . "cols != \"*\") {
                $" . "sqlString = \"insert into $" . "tablename ( $" . "cols )values ( $" . "values )  where $" . "condition;\";
            }

            return $" . "sqlString;
        }

        return null;
    }

    //select Cols or select all 
    function selectStm($" . "tablename, $" . "cols = \"*\", $" . "condition = true, $" . "connection = null) {
        $" . "sql = \"select $" . "cols from $" . "tablename where $" . "condition\";
        // $" . "sql.\"<br>\";
       return $" . "this->unpacking($" . "this->queryExecuation($" . "sql, $" . "connection));
    }
   

    function insertStm($" . "tablename, $" . "cols, $" . "value, $" . "connection = null) {
        $" . "sql = \"insert into $" . "tablename ($" . "cols) values ($" . "value);\";
    $" . "connection = $" . "this->initConnection();
        mysqli_set_charset($" . "connection, \"utf-8\");
         mysqli_query($" . "connection, $" . "sql) ;
         //echo $" . "sql;
        // return mysqli_error($" . "connection);
        return mysqli_insert_id($" . "connection) ;
    
    }

    
    function updateStm($" . "tablename, $" . "cols, $" . "condition = true, $" . "connection = null) {
        $" . "sql = \"update  $" . "tablename set $" . "cols where $" . "condition\";
        return $" . "this->queryExecuation($" . "sql, $" . "connection);
    }

    //Delete row or empty table 
    function deleteStm($" . "tablename, $" . "condition = true, $" . "connection = null) {
        $" . "sql = \"delete from $" . "tablename where $" . "condition\";
        return $" . "this->queryExecuation($" . "sql, $" . "connection);
    }

}

?>
";
        fileCreation($dbStore."/queryString.php", $data);
        $data = "<?"."php \n 
define(\"server\", \"localhost\");
define(\"user\", \"root\");
define(\"password\", \"P@ssw0rd\");
define(\"database\", \"sis_schools_2012\");\n?>";

        fileCreation($dbStore."/dbConnection.php", $data);
    }
    $GLOBALS['directoryPath'].="<br /> The Services directory is :$dbStore has been Created ....<br />";
}

function beanService($servicePath, $tablesName) {

    if (directoryCreation($servicePath)) {
        foreach ($tablesName as $value) {
            $data = array("<?" . "php \nrequire_once '../_Beans/$value" . "Beans.php';\nrequire_once '../_DatabaseStore/queryString.php';\nrequire_once '../_DatabaseStore/dbConnection.php';" . "\nfunction add(){}\n", "\nfunction get(){}\n", "\nfunction update(){}\n", "\nfunction delete(){}\nfunction packing($" . "beanObject){\n return join(',', (array) $" . "beanObject);\n} \nfunction getConnection(){return null;}            foreach ($"."_POST as $"."key => $"."value) {
                echo \"if(isset($"."\" . \"_POST['$"."key']))  $"."\" . \"$"."key=$"."\" . \"_POST['$"."key'];\";
            }

if (isset($"."_GET['operation'])) {


    $"."operation = $"."_GET['operation'];
    switch ($"."operation) {
        case 1:
	//get
            break;
        case 2:
//add
         break;
        case 3:
//delete
            break;
        case 4:
//update
            break;
        default:
            echo \"$"."operation is undefined \";
            break;
    }
}\n?>");

            fileCreation("$servicePath/$value" . "Services.php", $data);
        }

        $GLOBALS['directoryPath'].="<br /> The Services directory is : $servicePath has been Created ....<br />";
    
        
        }
}

function beanCreation($beanPath) {
    $databaseName = $GLOBALS['databaseName'];
    if (directoryCreation($beanPath)) {
        echo "directory Created ";
        $query = $GLOBALS['db']->queryTableName($databaseName);
        while ($row = mysqli_fetch_assoc($query)) {
            $tableName = $row["TABLE_NAME"];
            $tableCols = array();
            $subquery = $GLOBALS['db']->queryTablefiled($databaseName, $tableName);
            foreach ($subquery as $key1 => $value1)
                if (is_array($value1))
                    array_push($tableCols, $value1['Field'] . ";//" . $value1['Type']);


            $content = "<?php " . $GLOBALS['db']->beanCreation($tableName, $tableCols) . "?>";
            $GLOBALS['db']->beanToFile("$beanPath/$tableName", $content);
            array_push($GLOBALS['tables'], $tableName);
        }
        $GLOBALS['directoryPath'].="<br />The beans directory is : $beanPath has been created ....<br />";
    }
    else
        echo "Can't create direcotry $databaseName";
}

?>
 
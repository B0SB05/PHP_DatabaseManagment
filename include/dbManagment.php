<?php
 
define("userName", "root");
define("password", "P@ssw0rd");
define("hostName", "localhost");
define("servicePort", "3306");

class database extends mysqli {

    private static $instance = null;

    public static function getInstance() {

        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function __construct() {

        parent::__construct(hostName, userName, password);
        if (mysqli_connect_error()) {
            exit("Connect Error (" . mysqli_connect_errno() . ") " . mysqli_connect_error());
        }
        parent::set_charset("utf-8");
    }

    public function queryDataBaseName() {
        return $this->sqlQuery("show databases ;");
    }

    public function queryTableName($targetDataBase) {

        return $this->sqlQuery("select * from INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE '%$targetDataBase%'");
    }

    public function queryTablefiled($targetDataBase, $targetTableName) {

        return $this->sqlQuery("SHOW COLUMNS FROM $targetDataBase.$targetTableName");
    }

    public function sqlQuery($sql) {

        return $this->query($sql);
    }

    public function dataStoreFunction($tablename, $variable) {
        // Select , delete , Insert , update 
        $content = "\n $tablename" . "DataStore { \n public $" . "tablename='$tablename';\n";
        $newline = "\n";
        $methods = array("select", "delete");
        $part1 = array(" from ", " from ");
        $part2 = array(" where ", " where ");
        $sql = array(
            "select X from Y where C ;", " insert into X (Cols) Values (Values) where C; ", "update X set Y=Z where C"
        );

        $sqlSelectString = "\n function $tablename" . "SelectStmt($" . "cols='*',$" . "condition=true){\n";
        $sqlSelectString.=" SELECT $" . "cols from $tablename where $" . "condition";
        $sqlSelectString.="\n}\n";

        $sqlDeleteString = "\n function $tablename" . "DeleteStmt($" . "condition=true){\n";
        $sqlDeleteString.=" DELETE from $tablename where $" . "condition";
        $sqlDeleteString.="\n}\n";

        $sqlInsertString = "\n function $tablename" . "InsertStmt($" . "values ,$" . "condition=true){\n";
        $sqlInsertString.=" Insert into $tablename values (join()) where $" . "condition";
        $sqlInsertString.="\n}\n";



        if (is_array($variable))
            $length = '';



        $content.="\n }";


        return $content;
    }

    public function beanFunction($variable, $setFunction = false, $getFunction = false, $updateFunction = false, $insertFunction = false, $conditionFunction = false, $type = "") {
        $content = "";

        if ($setFunction)
            $content.="\n //set Col name \n public function set" . ucfirst($variable) . "(){\n $" . "this->$variable='$variable';\n}\n";

        if ($updateFunction)
            if ((preg_match("/char/", $type) || preg_match("/text/", $type)) !== false)
                $content.="\n public function update" . ucfirst($variable) . "($" . "value){\n $" . "this->$variable=\"$variable='$" . "value'\";\n}\n";
            else
                $content.="\n public function update" . ucfirst($variable) . "($" . "value){\n $" . "this->$variable=\"$variable=$" . "value\";\n}\n";

        if ($conditionFunction)
            if ((preg_match("/char/", $type) || preg_match("/text/", $type)) !== false)
                $content.="\n public function condition" . ucfirst($variable) . "($" . "value){\n $" . "this->$variable=\"$variable='$" . "value'\";\n}\n";
            else
                $content.="\n public function condition" . ucfirst($variable) . "($" . "value){\n $" . "this->$variable=\"$variable=$" . "value\";\n}\n";

        if ($insertFunction)
            if ((preg_match("/char/", $type) || preg_match("/text/", $type)) !== false)
                $content.="\n public function insert" . ucfirst($variable) . "($" . "value){\n $" . "this->$variable=\"'$" . "value'\";\n}\n";
            else
                $content.="\n public function insert" . ucfirst($variable) . "($" . "value){\n $" . "this->$variable=$" . "value;\n}\n";

        if ($getFunction)
            $content.="\n //get Current Variable value \n public function get" . ucfirst($variable) . "(){\n return $" . "this->$variable;\n}\n";
        return $content;
    }

    public function beanCreation($tableName, $col) {
        $class = "\n class " . $tableName . "_bean {\n";
        foreach ($col as $value) {
            $class.="\n\npublic $$value ; \n";
            $value = explode(";", $value);
            $class.=$this->beanFunction($value[0], true, true, true, true, true, $value[1]);
        }
        $class.="public function getTableName(){return '$tableName';}\n } \n";
        return $class;
    }

    public function beanToFile($filename, $content) {
        $filename.="Beans.php";
        return file_put_contents($filename, $content, LOCK_EX);
    }

}

?>

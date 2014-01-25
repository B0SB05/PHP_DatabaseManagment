
        <?php 
        require_once './include/header.php';
        $databases = $db->queryDataBaseName();
        if($databases){
        ?>
        <select name="databaseName" id="databaseName" onchange="showjspajax('BosBosPHP_Framework.php', 'databasename='+this.value, 'tables', 'GET') ">
                <option value="-1">Select Database Name</option>
        <?php
        while ($row = mysqli_fetch_assoc($databases)) {
            if (is_array($row))
                foreach ($row as $key => $value)
                    echo "<option value='$value'>$value</option>";
        }
        ?>
    </select>
        <?php } 
        else "<h3>No result</h3> ";
        
        ?>
            </form>
        <div id="tables" name="tables" ></div>
         
</body>
</html>

<?php 
    function Connection(){
        $server = "localhost";
        $user = "root";
        $pass = "";
        $db_name = "medical_system_db";

        $con = mysqli_connect($server,$user,$pass,$db_name);

        $result = (!$con)?"Connection Lost":$con;
        return $result;
    }
?>
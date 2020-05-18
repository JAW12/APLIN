<?php

include __DIR__."/system/load.php";

$query = "SELECT * FROM CUSTOMER";
$user = getQueryResultRowArrays($db, $query);

foreach($user as $key => $value){
    if(!password_is_hash($value["PASSWORD"])){
        $pass = password_hash($value["PASSWORD"], PASSWORD_DEFAULT);
    }
    $update = "UPDATE CUSTOMER SET PASSWORD = '$pass' WHERE USERNAME = '$value[USERNAME]'";
    executeNonQuery($db, $update);
}

echo "Berhasil!";

function password_is_hash($password)
{
    $nfo = password_get_info($password);
    return $nfo['algo'] != 0;
}
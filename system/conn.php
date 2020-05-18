<?php //tag php ga ditutup gpp
//dbname sesuaikan dgn nama db
$dbname = "proyek_aplin";
$dsn = "mysql:host=localhost;dbname=".$dbname.";port=3306;charset=utf8mb4";
$user = "root"; //ini default di xampp. kalo deploy tergantung server
$pass ="";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

//----- connect database -----
try {
    $db = new PDO($dsn,$user,$pass,$options);
} catch (Exception $e) {
    echo $e->getMessage(); //tanda panah pada php = tanda titik pada java/C#/dll
}

//----- function query database -----
function getQueryResultRow($db, $query){
    try {
        $result = $db->query($query)->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (Exception $e) {
        echo $e->getMessage(); //tanda panah pada php = tanda titik pada java/C#/dll
    }    
}

function getQueryResultRowField($db, $query, $fieldName){
    try {
        $result = $db->query($query)->fetch(PDO::FETCH_ASSOC)[$fieldName];
        return $result;
    } catch (Exception $e) {
        echo $e->getMessage(); //tanda panah pada php = tanda titik pada java/C#/dll
    }    
}

function getQueryResultRowArrays($db, $query){
    try {
        $result = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (Exception $e) {
        echo $e->getMessage(); //tanda panah pada php = tanda titik pada java/C#/dll
    }    
}

function executeNonQuery($db, $query){
    try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute();
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }    
}

function getCustomerData($db, $username){
    try {
        $query = "SELECT * FROM CUSTOMER WHERE USERNAME = '{$username}'";
        $result = getQueryResultRow($db, $query);
        return $result;
    } catch (Exception $e) {
        echo $e->getMessage(); //tanda panah pada php = tanda titik pada java/C#/dll
    }    
}

function getCustomerName($db, $id){
    try {
        $query = "SELECT concat(NAMA_DEPAN_CUSTOMER,' ',NAMA_BELAKANG_CUSTOMER) AS 'NAME' FROM CUSTOMER WHERE ROW_ID_CUSTOMER = '{$id}'";
        $result = getQueryResultRowArrays($db, $query);
        return $result;
    } catch (Exception $e) {
        echo $e->getMessage(); //tanda panah pada php = tanda titik pada java/C#/dll
    }    
}
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

//----- function php -----
function showAlert($message){
    echo "<script>alert('$message')</script>";
}

function updateDataSession($idxSession, $data){
    $_SESSION[$idxSession] = $data;
}

// function showAlertModal($message){
//     echo '                 
//     <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModal" aria-hidden="true">
//         <div class="modal-dialog modal-dialog-centered" role="document">
//             <div class="modal-content">
//                 <div class="modal-header">
//                     Squee Store Says
//                 </div>
//                 <div class="modal-body">
//                     '.$message.'
//                 </div>            
//                 <div class="modal-footer">
//                     <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
//                 </div>
//             </div>
//         </div>
//     </div>
//     ';
//     echo "<script>
//         $(document).ready(function(){
//             $('#alertModal').modal('show');
//         });    
//     </script>";
// }

function getDateFormatted($date){
    try {
        $hasil = date("F d Y H:i:s", strtotime($date));
        return $hasil;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function refreshPage(){
    header("Refresh:0");
}

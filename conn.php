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

function showModal($title, $message, $buttonmessage, $button){
    // $title utk nentuin titlenya
    // $message utk nentuin isinya mau apa
    // $buttonmessage utk nentuin teks button nya mau apa
    // $button utk klo ada tambahan button (opsional)    

    echo '<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">' . $title . '</h5>
            </div>
            <div class="modal-body">
            ' . $message . '
            </div>
            <div class="modal-footer">
            ' . $button . '
                <button type="button" class="btn btn-secondary" data-dismiss="modal">' . $buttonmessage . '</button>
            </div>
        </div>
    </div>
    </div>';
    echo "<script>
        $('#myModal').modal('show');
    </script>";
}

function showAlertModal($warna, $icon, $message, $buttonmessage, $button){
    // $warna utk nentuin warna background atas, pake class bootstrap aja.
    // $icon utk nentuin iconnya
    // $message utk nentuin isinya mau apa
    // $buttonmessage utk nentuin teks button nya mau apa
    // $button utk klo ada tambahan button (opsional)

    echo '<style>
    /* Khusus Modal Alert */
        .modal-confirm {		
            color: #434e65;
            width: 525px;
        }
        .modal-confirm .modal-content {
            padding: 20px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
        }
        .modal-confirm .modal-header {
            border-bottom: none;   
            position: relative;
            text-align: center;
            margin: -20px -20px 0;
            border-radius: 5px 5px 0 0;
            padding: 35px;
        }
        .modal-confirm h4 {
            text-align: center;
            font-size: 36px;
            margin: 10px 0;
        }
        .modal-confirm .form-control, .modal-confirm .btn {
            min-height: 40px;
            border-radius: 3px; 
        }
        .modal-confirm .close {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #fff;
            text-shadow: none;
            opacity: 0.5;
        }
        .modal-confirm .close:hover {
            opacity: 0.8;
        }
        .modal-confirm .icon-box {
            color: #fff;		
            width: 95px;
            height: 95px;
            display: inline-block;
            border-radius: 50%;
            z-index: 9;
            border: 5px solid #fff;
            padding: 10px;
            margin: 0 auto;
        }
        .modal-confirm .icon-box i {
            font-size: 58px;
            margin: -2px 0 0 -2px;
        }
        .modal-confirm.modal-dialog {
            margin-top: 80px;
        }
        .modal-confirm .btn {
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.4s;
            line-height: normal;
            border-radius: 30px;
            margin-top: 10px;
            padding: 6px 20px;
            min-width: 150px;
            border: none;
        }
        .modal-confirm .btn:hover, .modal-confirm .btn:focus {
            background: #014d92;
            outline: none;
        }
        </style>';

    echo '<div id="alertModal" class="modal fade">
        <div class="modal-dialog modal-confirm text-center">
            <div class="modal-content">
                <div class="modal-header ' . $warna . '">
                    <div class="icon-box">
                        ' . $icon . '
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    ' . $message . '                    
                    <button class="btn btn-primary" data-dismiss="modal">' . $buttonmessage . '</button>
                    ' . $button . '
                </div>
            </div>
        </div>
    </div>';
    echo "<script>
    $('#alertModal').modal('show');
    </script>";
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

function hashPassword($p, $b){ // true -> cek pake hash, false -> cek ga pake hash
    if($b == true){
        return password_hash($p, PASSWORD_DEFAULT);
    }
    else{
        return $p;
    }
}

function cekPassword($p1, $p2, $b){ // true -> cek pake hash, false -> cek ga pake hash
    if($b == true){
        if(password_verify($p1, $p2)){
            return true;
        }
        else{
            return false;
        }
    }
    else{
        if($p1 == $p2){
            return true;
        }
        else{
            return false;
        }
    }
}


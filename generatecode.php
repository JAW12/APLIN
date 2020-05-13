<?php
    function generateCodeForRegistration($panjang){
        $result="";
        $dictionary=array_merge(range(1,9));
        for ($i=0; $i <$panjang ; $i++) { 
            $result .=$dictionary[mt_rand(0,count($dictionary)-1)];
        }
        return $result;
    }
    function uniquecodeemailForRegistration(){
        global $db;
        $count=1;
        $result="";
        do {
           $result=generateCodeForRegistration(5);
           $query="select Count(*) as jumlah from verifikasi_email where KODE_VERIFIKASI='$result'";
           $count=$db->query($query)->fetch(PDO::FETCH_ASSOC)["jumlah"];
        }while ($count >0);
        return $result;
        
    }
?>
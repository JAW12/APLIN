<?php
    include "system/load.php";
     /** @var PDO $db Prepared Statement */
    $login = getDataLogin();

    $jenisUser = "";
    if (isset($login) && is_array($login)) {
        $jenisUser = "admin";
        $rowIdUserAktif = -1;
        if ($login['role'] == 1) {
            $jenisUser = "customer";
        }
        
        if ($jenisUser == "customer") {
            $dataCustomer = getCustomerData($db, $login['username']);
            $rowIdUserAktif = $dataCustomer['ROW_ID_CUSTOMER'];
        }
    }

    //--- function ----
    function getListProduk($db){
        $tmpFilterCategory = array();
        $conditionCatParent = "";
        $conditionCatChildren = "";

        $query = "SELECT * FROM PRODUK P, KATEGORI_PRODUK KP";
        $condition = " P.STATUS_AKTIF_PRODUK = 1 AND P.ROW_ID_PRODUK = KP.ROW_ID_PRODUK ";
        if (isset($_POST['q']) && !empty($_POST['q'])) {
            if ($condition != "") {
                $condition = $condition . " AND ";
            } 
            $condition = $condition . " LOWER(P.NAMA_PRODUK) LIKE '%{$_POST['q']}%'";
        }
        if (isset($_POST['min']) && !empty($_POST['min'])) {
            $value = $_POST['min'];
            if ($condition != "") {
                $condition = $condition . " AND ";
            } 
            $condition = $condition . " P.HARGA_PRODUK >= $value ";
        }
        if (isset($_POST['max']) && !empty($_POST['max'])) {
            $value = $_POST['max'];
            if ($condition != "") {
                $condition = $condition . " AND ";
            } 
            $condition = $condition ." P.HARGA_PRODUK <= $value ";
        }
        if (isset($_POST['availableProduct']) && $_POST['availableProduct'] == "true") {
            if ($condition != "") {
                $condition = $condition . " AND ";
            } 
            $condition = $condition . " P.STOK_PRODUK > 0 ";
        }

        if (isset($_POST['category_parent']) || isset($_POST['category_child'])) {
            $selectedParent = array(); $selectedChildren = array();
            if (isset($_POST['category_parent'])) {
                $selectedParent = $_POST['category_parent'];
            }
            if (isset($_POST['category_child'])) {
                $selectedChildren = $_POST['category_child'];
            }

            if (is_array($selectedParent) && count($selectedParent) > 0) {
                foreach ($selectedParent as $key => $value) {
                    $tmpFilterCategory[] = $value;
                }
            }
            if (is_array($selectedChildren) && count($selectedChildren) > 0) {
                foreach ($selectedChildren as $key => $value) {
                    $tmpFilterCategory[] = $value;
                }
            }

            if (count($tmpFilterCategory) > 0) {
                $inQuery  = str_repeat('?,', count($tmpFilterCategory) - 1) . '?';
                if ($condition != "") {
                    $conditionCatParent .= " AND ";
                    $conditionCatChildren .= " AND ";
                }
                $conditionCatParent .= " KP.ROW_ID_KATEGORI_PARENT IN ($inQuery)";
                $conditionCatChildren .= " KP.ROW_ID_KATEGORI_CHILD IN ($inQuery)";
            }
        }

        if ($condition != "") {
            $query .= " WHERE ";
        }

        $queryParent = $query . $condition . $conditionCatParent; 
        $queryChildren = $query . $condition . $conditionCatChildren;

        // echo $queryParent . "<br/>";
        // echo $queryChildren . "<br/>";
        // echo count($tmpFilterCategory);

        $listProduk = array();
        try {
             /** @var PDO $db Prepared Statement */
            if (count($tmpFilterCategory) > 0) {
                //get result filter category parent
                if ($conditionCatParent != "") {
                    $stmt = $db->prepare($queryParent);
                    $stmt->execute($tmpFilterCategory);
                    $resCatParent = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                
                if ($conditionCatChildren != "") {
                    //get result filter category children                            
                    $stmt = $db->prepare($queryChildren);
                    $stmt->execute($tmpFilterCategory);
                    $resCatChildren = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }

                $listProduk = array_unique(array_merge($resCatParent,$resCatChildren), SORT_REGULAR);
            }
            else{
                $query .= $condition;
                $stmt = $db->prepare($query);
                $stmt->execute();
                $listProduk = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            return $listProduk;

        } catch (Exception $e) {
            echo $e->getMessage(); //tanda panah pada php = tanda titik pada java/C#/dll
            return false;
        }
    }

    function showCardProduk($db, $jenisUser, $listProduk){
        if ($listProduk == false) {
            showAlertDiv("We can't find products matching the selection");
        }
        else{
            ?>
            <div class="container-fluid px-1 pl-1">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 card-deck">
                    <?php
                    foreach ($listProduk as $key => $value) {
                        $lokasiFotoProduk = "res/img/produk/".$value['LOKASI_FOTO_PRODUK'];
                        $cl = "";
                        $text = "&nbsp;";
                        if (intval($value['STOK_PRODUK']) <= 0) {
                            $text = "Out of Stock";
                            $cl = "grayscale";
                        }
                        ?>
                            <form method="POST">                            
                                <div class="card border-0 hover-shadow my-4 p-3" style="width: 18rem;box-sizing: border-box">
                                    <div>
                                        <img width="256px" height="256px" src="<?= $lokasiFotoProduk ?>" class="card-img-top <?= $cl ?>" alt="gambar produk">
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">
                                            <?php echo "<p class='font-weight-bold text-danger text-right'> $text </p>" ?>
                                            <p class="font-weight-bold text-left">
                                                Rp. <?= getSeparatorNumberFormatted($value['HARGA_PRODUK']) ?>
                                            </p><br/>
                                            <p>
                                                <button class="btn btn-link text-left text-dark text-decoration-none" style="width : 230px;height:100px;" name="lihatDetail" formaction="product-detail.php">
                                                    <?= $value['NAMA_PRODUK'] ?>
                                                </button>                                                 
                                            </p>
                                        </p>                            
                                    </div>
                                    <div class="card-button p-2 d-flex flex-wrap justify-content-around my-2 mt-n1">
                                        <input type="hidden" name="idProduk" value="<?= $value['ROW_ID_PRODUK'] ?>">
                                        <button class="btn btn-primary w-100 rounded my-2" name="lihatDetail" formaction="product-detail.php">View Detail</button>    
                                        <?php
                                            if ($jenisUser == "customer") {
                                                echo "<button type='button' class='btn btn-warning w-100 rounded my-2' name='addToWishlist' onclick=addtowish('".$value['ROW_ID_PRODUK']."') formaction='wishlist.php'>Add to Wishlist</button>"; 
                                            }
                                        ?>
                                    </div>
                                </div>              
                            </form>                        
                        <?php
                    }
                    ?>                  
                </div>    
            </div>
            <?php
        }
    }
    
    if (isset($_POST['viewProduct'])) {
        $listProduk = getListProduk($db);
        showCardProduk($db, $jenisUser, $listProduk);
    }

?>
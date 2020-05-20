<?php
    include __DIR__."/system/load.php";
     /** @var PDO $db Prepared Statement */
    
    $login = getDataLogin();

    $jenisUser = "customer";
    if (isset($login) && is_array($login)) {
        $jenisUser = "customer";
        $rowIdUserAktif = -1;
        if ($login['role'] == 1) {
            $jenisUser = "customer";
        }
        else if ($login['role'] == 0) {
            $jenisUser = "admin";
        }
        
        if ($jenisUser == "customer") {
            $dataCustomer = getCustomerData($db, $login['username']);
            $rowIdUserAktif = $dataCustomer['ROW_ID_CUSTOMER'];
        }
    }
    
    function getParentCategories($db){
        $query = "SELECT * FROM KATEGORI WHERE STATUS_AKTIF_KATEGORI = 1 AND STATUS_PARENT = 1";
        $dataCategory = getQueryResultRowArrays($db, $query);
        return $dataCategory;
    }

    function getChildrenCategories($db, $row_id_parent){
        $query = "SELECT * FROM KATEGORI WHERE STATUS_AKTIF_KATEGORI = 1 AND ROW_ID_KATEGORI_PARENT = {$row_id_parent}";
        $dataCategory = getQueryResultRowArrays($db, $query);
        return $dataCategory;
    }

    function showCategoryList($db){
        $dataParent = getParentCategories($db);
        $ctrChildren = 0;
        foreach ($dataParent as $key => $value) {
            $row_id_parent = $value['ROW_ID_KATEGORI'];
            $nama_parent = ucwords(strtolower($value['NAMA_KATEGORI']));
            ?>
                <div class="row ml-0">
                    <div class="col">
                        <div class="form-inline pr-1">
                            <input class="form-check-input cbCategoryParent" type="checkbox" value='<?= $row_id_parent ?>' name="category_parent[<?= $key ?>]">
                            <label class="form-check-label ml-0 col-form-label-sm"><?= $nama_parent ?></label>
                        </div>
                        <?php
                            $dataChildren = getChildrenCategories($db, $row_id_parent);
                            if (is_array($dataChildren) && count($dataChildren) > 0) {
                                foreach ($dataChildren as $key => $value) {
                                    $row_id_child = $value['ROW_ID_KATEGORI'];
                                    $nama_child = ucwords(strtolower($value['NAMA_KATEGORI']));                                    
                                    ?>
                                        <div class="row child-category ml-2">
                                            <div class="col float-left">
                                                <div class="form-inline">
                                                    <input class="form-check-input cbCategoryChild" type="checkbox" value='<?= $row_id_child ?>' name="category_child[<?= $ctrChildren ?>]">
                                                    <label class="form-check-label col-form-label-sm"><?= $nama_child ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    $ctrChildren++;
                                }
                            }
                        ?>
                    </div>
                </div>
            <?php
        }
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <?php include "head.php"; ?>
        <style>
            .hover-shadow{
                box-shadow: 0px 0px 0px white;
            }

            .hover-shadow:hover{
                box-shadow: 0px 0px 10px lightgrey;                
            }

            .card-button{
                display: none;
            }

            .grayscale{
                filter: grayscale(100%);
            }

            #judul{
                padding: 0;
                padding-top: 5%;

                padding-bottom: 5%;
                background-repeat:no-repeat;
                background-size: cover;
            }
        </style>

        <!-- JS Sendiri -->
        <title>Product List</title>
    </head>
    <body id="page-top">
        <!-- Header Section -->
        <?php include("header.php"); ?>

        <!-- Main Section -->
        <main>
            <div id="judul" class="col-12 text-center my-5" style="background-image: url('res/img/bg9.jpg');">
                <h1 class="text-light display-3 font-weight-bold">
                    Product List
                </h1>
            </div>

            <div class="row d-flex justify-content-around">
                <!-- filter -->
                <div class="col-sm-6 col-md-4 col-lg-4 col-xl-2 pr-2">                    
                    <div class="container-fluid w-100">
                        <div class="container my-4 d-flex justify-content-around flex-wrap">
                            <form method="GET" class="form-inline mr-2 ml-5" id="formFilter" style="width: 100%">
                                <input type="hidden" class="form-control form-control-sm" name="viewProduct">
                                <?php
                                    $class_hr = "border border-dark w-100 float-left mb-2";
                                    $keyword = ""; $min = "" ; $max = ""; $checkedStatus = "";
                                    if (isset($_GET['q']) && !empty($_GET['q'])) {
                                        $keyword = $_GET['q'];
                                    }
                                    if (isset($_GET['min']) && !empty($_GET['min'])) {
                                        $min = $_GET['min'];
                                    }
                                    if (isset($_GET['max']) && !empty($_GET['max'])) {
                                        $max = $_GET['max'];
                                    }
                                    if (isset($_GET['availableProduct']) && $_GET['availableProduct'] == "true") {
                                        $checkedStatus = "checked";
                                    }
                                ?>
                                
                                <div class="my-2 align-middle" style="width: 100%">
                                    <div class="form-inline">
                                        <button type="button" class="btn btn-light rounded-circle mr-2 btn-angle">
                                            <i class="fas fa-angle-up"></i>
                                        </button>
                                        <span class="font-weight-bold font-italic">Product Info</span>
                                    </div>
                                    
                                    <div class="container-filter w-100">
                                        <p class="text-sm-left mx-2 my-2">Availability</p>
                                        <div class="form-inline mx-2 w-100">
                                            <input class="form-check-input form-control-sm ml-1" type="checkbox" id="cbAvailableProduct" value="true" name="availableProduct" <?= $checkedStatus ?>>
                                            <label class="form-check-label text-break" for="cbAvailableProduct">Available Products</label>
                                        </div>

                                        <p class="text-sm-left mx-2 my-2 mt-3">Product Name</p>
                                        <input type="text" class="form-control form-control-sm ml-2" placeholder="Product Name" name="q" value="<?= $keyword ?>">
                                    </div>                                    
                                </div>
                                <hr class="<?= $class_hr ?>">
                                <div class="my-2 align-middle w-100">
                                    <div class="form-inline">
                                        <button type="button" class="btn btn-light rounded-circle mr-2 btn-angle">
                                            <i class="fas fa-angle-up"></i>
                                        </button>
                                        <span class="font-weight-bold font-italic mr-4">Price Range</span>
                                    </div>
                                                                        
                                    <div class="container-filter">
                                        <input type="number" class="form-control form-control-sm ml-2 my-2" placeholder="Minimum Price" name="min" value="<?= $min ?>">
                                        <input type="number" class="form-control form-control-sm ml-2 my-2" placeholder="Maximum Price" name="max" value="<?= $max ?>">
                                    </div>
                                </div>
                                <hr class="<?= $class_hr ?>">
                                <div class="my-2 align-middle w-100">
                                    <div class="form-inline">
                                        <button type="button" class="btn btn-light rounded-circle mr-2 btn-angle">
                                            <i class="fas fa-angle-up"></i>
                                        </button>
                                        <span class="font-weight-bold font-italic">Product Category</span>
                                    </div>
                                    
                                    <div class="container-filter text-left mt-1 container-category">
                                        <?php showCategoryList($db) ?>
                                    </div>                                    
                                </div>
                                <hr class="<?= $class_hr ?>">
                                <div class="my-1 mx-0 w-100 d-flex flex-wrap justify-content-around">                                    
                                    <button type="button" class="btn btn-info w-100 my-2" id="btnReset">Clear All</button>
                                    <?php
                                        if ($jenisUser == "admin") {
                                            ?>
                                                <a class="btn btn-warning w-100 my-2" href="master-product.php">Add Product</a>
                                            <?php
                                        }
                                    ?>
                                </div>
                                
                            </form>    
                        </div>
                    </div>
                </div>
                <!-- product list -->
                <div class="col">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-around" id="containerProductList">

                        </div>
                    </div>               
                </div>
            </div>            
        </main>
        <div id="alert"></div>
        <!-- Footer Section -->
        <?php include ("footer.php"); ?>
        <?php include "script.php"; ?>
        <script>
            function loadProductList(){
                $.ajax({
                    method : "POST",
                    url : "ajax-product-list.php",
                    data : $("#formFilter").serialize(),
                    success : function(res){
                        $("#containerProductList").html(res);
                    }
                });
            }

            function uncheckCheckbox(){
                let cbCategories = $("#formFilter input[type='checkbox']:checked");

                cbCategories.each(function(){
                    this.checked = false;
                });
            }

            function resetFilter(){
                $("#formFilter input").val("");
                uncheckCheckbox();               
            }

            function addtowish(idproduk) {
                $.post("addtowish.php", 
                    { idproduk: idproduk },
                    function(result) {
                        $("#alert").html(result);
                        $("#alertModal").modal();
                    }
                );
            }

            $("#formFilter input").change(function(){
                loadProductList();
            });

            $("#formFilter .btn-angle").click(function(){
                let containerFields = $(this).parent().siblings(".container-filter");
                let icon = $(this).children();

                //slide toggle fields
                $(containerFields).slideToggle(200, "linear");

                //ubah icon
                console.log(icon);
                if ($(icon).hasClass("fa-angle-down")) {
                    $(icon).removeClass("fa-angle-down");
                    $(icon).addClass("fa-angle-up");
                }
                else if ($(icon).hasClass("fa-angle-up")) {
                    $(icon).removeClass("fa-angle-up");
                    $(icon).addClass("fa-angle-down");
                }
            })

            $("#btnReset").click(function(){
                resetFilter();
                loadProductList();
            })

            $("#formFilter").submit(function(e){
                e.preventDefault();
                loadProductList();
            })

            // automatically check/uncheck all child categories if its parent is checked/unchecked
            $(document).on("change", ".cbCategoryParent", function(){
                let childrenCategories = $(this).parent().siblings().find(".cbCategoryChild");
                let statusCheckedParent = this.checked;
                childrenCategories.each(function(){
                    // let isChecked = this.checked;
                    // this.checked = !isChecked;
                    this.checked = statusCheckedParent;
                });
                loadProductList();
            })

            $(document).ready(function(){
                //load untuk pertama kali
                loadProductList();

                //data akan diperbarui setiap 1 menit sekali
                setInterval(() => {
                    loadProductList();
                }, 60 * 1000);
            });
        </script>
    </body>
</html>
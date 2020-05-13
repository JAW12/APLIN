<style>
.bg-light.scrolled {
    background-color: #f8f9fa !important;
    transition: background-color 200ms;
}

.bg-light{
    background-color: #fff !important;
    transition: background-color 200ms;
}

#btnLog div{
    display: none;
}

@media only screen and (max-width: 1200px) {
    #btnLog div{
        display: block;
    }

    #btnLog{
        margin-top: 2%;
    }
}

</style>
<nav class="navbar navbar-expand-lg navbar-fixed-top fixed-top navbar-light bg-light">
    <a class="navbar-brand js-scroll-trigger" href="index.php"><img src="res/img/logo.png" style="width: 100px;"></a><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto my-2 my-lg-0 mr-4">
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="aboutus.php">About Us</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="contactus.php">Contact Us</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="product-list.php">Products</a></li>
        </ul>
        <form class="form-inline my-2 my-lg-0 mr-3" method="GET">
                <div class="input-group">
                <?php
                    $keyword = "";
                    if (isset($_GET['q'])) {
                        $keyword = $_GET['q'];
                    }                                
                ?>
                <input class="form-control" type="search" placeholder="Search Product" aria-label="Search" name="q" value="<?= $keyword ?>">
                <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" formaction="product-list.php">
                    <i class="fa fa-search"></i>
                </button>            
                </div>
            </div>
        </form>
        <?php if (isset($_SESSION['login'])){
                if($_SESSION['login']['role'] == 1){
            ?>
                <a class="btn btn-dark text-warning mr-2" style="width: 50px; height: 37px;" href="cart.php" role="button"><i class="fas fa-shopping-cart"></i></a>
                <a class="btn btn-dark text-warning mr-2" style="width: 50px; height: 37px;" href="wishlist.php" role="button"><i class="fas fa-heart"></i></a>
                <?php
                }
                ?>
                <a class="btn btn-dark text-warning mr-2" style="width: 50px; height: 37px;" href="transaction-list.php" role="button">
                    <i class="fas fa-history"></i>
                </a>
                <div></div>
                <a class="btn btn-danger px-4" id="btnLog" href="logout.php" role="button">Log Out</a>
                <?php
            }
            else{
            ?>
                <div></div>
                <a class="btn btn-primary px-4" id="btnLog" href="login.php" role="button">Log In</a>
            <?php
            }
        ?>
    </div>
</nav>
<script>
    $(document).scroll(function () {
        var $nav = $(".navbar");
        $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
    });
</script>
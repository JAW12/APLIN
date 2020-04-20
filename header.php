<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="index.php">Logo</a><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto my-2 my-lg-0 mr-4">
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="aboutus.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="contactus.php">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="product-list.php">Products</a></li>
            </ul>
            <form class="form-inline my-2 my-lg-0 mr-3">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
            </form>
            <?php if (isset($_SESSION['login'])){
                ?>
                    <a class="btn btn-danger" style="width: 8%" href="logout.php" role="button">Log Out</a>
                <?php
            }
                else{
                ?>
                    <a class="btn btn-primary" style="width: 8%" href="login.php" role="button">Log In</a>
                <?php
                }
            ?>
        </div>
    </div>
</nav>

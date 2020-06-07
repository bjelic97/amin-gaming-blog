<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Menu Begin -->
    <div class="humberger-menu-overlay"></div>
    <div class="humberger-menu-wrapper">
        <div class="hw-logo">
            <a href="#">
                <img src="assets/img/f-logo.png" alt="">
            </a>
        </div>
        <div class="hw-menu mobile-menu">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php">Posts <?= (isset($_SESSION['user']) && $_SESSION['user']->id_role == 1) ? '<i class="fa fa-angle-down"></i>' : '' ?></a>
                    <?php if (isset($_SESSION['user'])) : ?>
                        <?php if ($_SESSION['user']->id_role == 1) : ?>
                            <ul class="dropdown">
                                <li><a href="index.php?page=posts&id=new"><i class="fa fa-plus"></i> New post</a></li>
                            </ul>
                        <?php endif; ?>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
        <div id="mobile-menu-wrap"></div>
        <?php if (isset($_SESSION['user'])) : ?>
            <div class="hw-insta-media">
                <div class="section-title">
                    <h5><?= $_SESSION['user']->username ?></h5>
                </div>
                <div class="insta-pic">
                    <img src="assets/img/trending/editor-2.jpg" alt="">
                </div>
            </div>
        <?php endif; ?>

        <div class="hw-social mt-3">
            <?php if (!isset($_SESSION['user'])) : ?>
                <a href="#" class="generic-switch generic-open" data-action="register">Register</a>
                <a href="#" class="generic-switch generic-open" data-action="login">Login</a>
            <?php else : ?>
                <a href="#" class="generic-switch generic-open mt-3" data-action="logout">Logout</a>
            <?php endif; ?>

        </div>
    </div>
    <!-- Humberger Menu End -->
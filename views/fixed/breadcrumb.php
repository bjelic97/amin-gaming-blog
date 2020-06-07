<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg spad" data-setbg="assets/img/breadcrumb-bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb-text">
                    <?php
                    $title = '';
                    $action = '';
                    switch ($_GET['page']) {
                        case 'posts':
                            $title = 'Posts';
                            $action = 'create';
                            break;
                        case 'author':
                            $title = 'Author';
                            $action = 'Aleksa Bjeličić';
                            break;
                    }
                    ?>
                    <h3><?= $title; ?>: <span><?= $action; ?></span></h3>
                    <div class="bt-option">
                        <a href="index.php">Home</a>
                        <a href="index.php?page=<?= $_GET['page'] ?>"><?= $title; ?></a>
                        <span><?= ucfirst($action); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
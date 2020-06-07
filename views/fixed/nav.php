<?php
require "overlay.php";

?>
<!-- Header Section Begin -->
<?php if (isset($_SESSION['user'])) : ?>
    <input type="hidden" id="loggedUserId" value=<?= $_SESSION["user"]->id ?> />
    <input type="hidden" id="loggedUserRole" value=<?= $_SESSION["user"]->id_role ?> />
    <input type="hidden" id="loggedUserUsername" value=<?= $_SESSION["user"]->username ?> />
    <div class="ht-options">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 offset-9">
                    <div class="ht-widget">
                        <ul>
                            <li><i class="fa fa-clock-o"></i>Last time login : <?= date("F j, Y. H:i", strtotime($_SESSION['user']->last_activity)); ?></li>
                            <li><i class="fa fa-user"></i><?= $_SESSION['user']->username ?></li>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<header class="header-section">
    <div class="logo">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <a href="./index.html">
                        <img src="assets/img/logo.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-options">
        <div class="container">
            <div class="humberger-menu humberger-open">
                <i class="fa fa-bars"></i>
            </div>
            <?php if (!isset($_SESSION['user'])) : ?>
                <div class="nav-search">
                    <a class="generic-switch generic-open" data-action="register">Register</a>
                </div>
                <div class="nav-search">
                    <a class="generic-switch generic-open" data-action="login">Login</a>
                </div>

            <?php else : ?>
                <div class="nav-search">
                    <a class="generic-switch generic-open" data-action="logout">Logout</a>
                </div>
            <?php endif; ?>

            <div class="nav-menu">
                <ul>
                    <li class="active"><a class="pr-4" href="index.php"><span>Home</span></a></li>
                    <li class="mega-menu"><a href="index.php"><span>Posts <i class="fa fa-angle-down"></i></span></a>
                        <div class="megamenu-wrapper">
                            <div class="row">
                                <div class="col-4 offset-2">
                                    <?php if (isset($_SESSION['user'])) : ?>
                                        <?php if ($_SESSION['user']->id_role == 1) : ?>
                                            <a href="index.php?page=posts&id=new" class="pr-4"><i class="fa fa-plus"></i> NEW POST</a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <a id="latest-posts-nav-title" class="pr-4">LATEST</a>
                                </div>
                                <div class="col-4">
                                    <select id="offset-posts" class="ddl">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                    </select>
                                </div>
                                <div id="clear-nav-posts-form-button" class="col-1 elementDissapear">
                                    <a href="#" id="clear-nav-posts-form" class="pr-4">CLEAR</a>
                                </div>
                            </div>

                            <ul class="mw-nav">
                                <?php $categories = getCategoriesForExistingPosts();
                                foreach ($categories as $category) :
                                ?>
                                    <li><a href="#" data-id="<?= $category->id ?>" class="post-category-nav"><span><?= strtoupper($category->name) ?></span></a></li>

                                <?php endforeach; ?>
                            </ul>
                            <input type="hidden" id="selected-offset" />
                            <input type="hidden" id="selected-category-nav" />
                            <div id="posts-nav" class="mw-post">
                                <?php $posts = getPostsResponse(3, 0, 5);
                                foreach ($posts['content'] as $post) : ?>
                                    <div class="mw-post-item">
                                        <div class="mw-pic">
                                            <img id="posts-nav-img-<?= $post->id ?>" src="<?= $post->src ?>" alt="<?= $post->alt ?>">
                                        </div>
                                        <div class="mw-text">
                                            <h6><a href="index.php?page=posts&id=<?= $post->id ?>"><?= $post->title ?></a></h6>
                                            <ul>
                                                <li><i class="fa fa-clock-o"></i><?= date("F j, Y. H:i", strtotime($post->created_at)) ?></li>
                                                <li><i class="fa fa-comment-o"></i><?= $post->commNum ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->
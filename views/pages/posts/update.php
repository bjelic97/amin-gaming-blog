<!-- Details Hero Section Begin -->
<?php
$post_likers = $response['usersWhoLiked'];

function checkIfLoggedUserLikedPost($id_post, $arrayOfUsers)
{
    $id_user = isset($_SESSION['user']) ? (int) $_SESSION['user']->id : null;
    foreach ($arrayOfUsers as $user) {
        if ($user->id_post == $id_post && $user->id_user == $id_user) {
            return true;
        }
    }
    return false;
}
?>

<div id="post-preview">
    <section id="post-image-preview" class="details-hero-section set-bg" data-setbg="<?= $post->src_small ?>">
        <div class="container">
            <div class="row pr-5">
                <div class="col-lg-5">
                    <div class="details-hero-text">
                        <div class="label"><span class="category"><?= $post->category ?></span></div>
                        <h3 id="post-preview-title"><?= $post->title ?></h3>
                        <ul>
                            <li>by <span><?= $post->username ?></span></li>
                            <li><i class="fa fa-clock-o"></i><?= $post->created_at ?></li>
                            <li id="post-preview-comments"><i class="fa fa-comment-o"></i><?= $post->commNum > 0 ? $post->commNum : '' ?></li>
                            <li><i class="fa fa-heart-o"></i><?= (count($post_likers) > 0) ? count($post_likers) : '' ?></li>
                        </ul>

                        <?php if (isset($_SESSION['user'])) : ?>
                            <?php if ($_SESSION['user']->id_role == 1) : ?>
                                <div class="mt-5 label"><a id="ed-post-img" class="text-white generic-switch generic-open" data-post="<?= $post->id ?>" data-image="<?= $post->src ?>" data-action="edit-post-image" href=""><i class="fa fa-wrench pr-2"></i> Change image</a></div>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Details Hero Section End -->
</div>


<!-- Details Post Section Begin -->
<section class="details-post-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 p-0">
                <div class="details-text">
                    <div class="dt-author">
                        <div class="da-pic">
                            <img src="assets/img/trending/editor-2.jpg" alt="">
                        </div>
                        <div class="da-text">
                            <h5 class="mb-3"><?= $post->username ?></h5>
                            <div class="dt-quote">
                                <p>“ It's these long and meandering character arcs that make my adventures feel so epic in
                                    scale, like if Game of Thrones was a high-fantasy anime.” - <span>Steven Jobs</span></p>
                            </div>
                            <div class="da-links">
                                <a href="https://github.com/bjelic97" target="_blank"><i class="fa fa-github"></i></a>
                                <a href="https://www.linkedin.com/in/aleksa-bjelicic-4782211a3/" target="_blank"><i class="fa fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>

                    <?php if (isset($_SESSION['user'])) : ?>
                        <?php if ($_SESSION['user']->id_role == 1) : ?>
                            <div class="row ml-1">
                                <div class="section-title">
                                    <h5 class="static-post-title">Title</h5>
                                </div>
                                <div class="ml-3 dt-tags">
                                    <a href="#" class="edit-post-title" data-id="<?= $post->id ?>">Edit</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>


                    <div class="dt-desc">
                        <h3 class="post-title" style="color:white"><?= $post->title ?></h3>
                    </div>

                    <div style="margin-top:-80px" class="signup-text elementDissapear edit-post-title-form">
                        <div class="container">
                            <form class="signup-form">
                                <div class="sf-input-list">
                                    <input id="post-title" type="text" class="input-value" placeholder="Title *">
                                </div>
                                <button type="button" id="btn-save-edit-post-title" data-id="<?= $post->id ?>"><span>Save</span></button>
                                <button class="mb-3" type="button" id="btn-cancel-edit-post-title"><span>Cancel</span></button>
                            </form>
                        </div>
                    </div>

                    <?php if (isset($_SESSION['user'])) : ?>
                        <?php if ($_SESSION['user']->id_role == 1) : ?>
                            <div class="row ml-1 mt-5">
                                <div class="section-title">
                                    <h5 class="static-post-content">Content</h5>
                                </div>
                                <div class="ml-3 dt-tags">
                                    <a href="#" class="edit-post-content" data-id="<?= $post->id ?>">Edit</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>


                    <div class="dt-desc">
                        <p class="post-content"><?= $post->content ?></p>
                    </div>

                    <div style="margin-top:-80px" class="signup-text elementDissapear edit-post-content-form">
                        <div class="container">
                            <div class="dt-leave-comment mb-4">
                                <form action="#">
                                    <textarea class="text-white" id="post-content" type="text" placeholder="Content *"></textarea>
                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col-4">
                                            <button type="button" id="btn-save-edit-post-content" data-id="<?= $post->id ?>"><span>Save</span></button>
                                        </div>
                                        <div class="col-2"></div>
                                        <div class="col-4">
                                            <button type="button" id="btn-cancel-edit-post-content"><span>Cancel</span></button>
                                        </div>
                                        <div class="col-1"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php if (isset($_SESSION['user'])) : ?>
                        <?php if ($_SESSION['user']->id_role == 1) : ?>
                            <div class="row ml-1 mt-5">
                                <div class="section-title">
                                    <h5 class="static-post-category">Category</h5>
                                </div>
                                <div class="ml-3 dt-tags">
                                    <a href="#" class="edit-post-category" data-category="<?= $post->id_category ?>" data-id="<?= $post->id ?>">Edit</a>
                                </div>
                            </div>

                            <div style="margin-top:-80px" class="signup-text elementDissapear edit-post-category-form">
                                <div class="container">
                                    <form class="signup-form">
                                        <select class="w-100 ddl" id="post-category">
                                            <?php
                                            $categories = getCategories();
                                            foreach ($categories as $category) :
                                            ?>
                                                <option value="<?= $category->id ?>"><?= strtoupper($category->name) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="button" id="btn-save-edit-post-category" data-id="<?= $post->id ?>"><span>Save</span></button>
                                        <button class="mb-3" type="button" id="btn-cancel-edit-post-category"><span>Cancel</span></button>
                                    </form>
                                </div>
                            </div>

                            <div class="dt-tags tag-post-cat">
                                <a href="#" class="category"><?= strtoupper($post->category) ?></a>
                            </div>

                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="mt-5 dt-tags">
                        <a>Category : <span class="category"><?= strtoupper($post->category) ?></span></a>
                        <a><span>Published : <?= $post->created_at ?></span></a>
                        <a><span id="modified-at">Modified : <?= $post->modified_at ?></span></a>
                    </div>

                    <?php include "partials/comments.php"; ?>

                </div>
            </div>
            <div class="col-lg-4 col-md-7">
                <div class="sidebar-option">
                    <div class="social-media">
                        <div class="section-title">
                            <h5>Post stats</h5>
                        </div>
                        <ul>
                            <li id="post-stats-comments">
                                <div class="sm-icon"><i class="fa fa-comment-o"></i></div>
                                <span><?= $post->commNum ?> comments</span>
                            </li>
                            <li id="post-likes">
                                <div class="sm-icon"><i class="fa fa-heart-o"></i></div>
                                <span><?= (count($post_likers) > 0) ? count($post_likers) : 0 ?> likes</span>
                            </li>
                        </ul>
                    </div>

                    <?php if (isset($_SESSION['user'])) : ?>
                        <div class="subscribe-option">
                            <form action="#">
                                <button type="button" class="toggle-like-post" data-id="<?= $post->id ?>"><span id="post-liked-by-logged-user"><?= checkIfLoggedUserLikedPost($post->id, $post_likers) ? 'UNLIKE POST' : 'LIKE POST' ?></span></button>
                                <?php if ($_SESSION['user']->id_role == 1) : ?>
                                    <button type="button" class="mt-4 generic-switch generic-open" data-id="<?= $post->id ?>" data-action="delete-post">Remove post</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Details Post Section End -->
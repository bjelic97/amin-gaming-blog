<?php $comments = getCommentsResponse(0, OFFSET, $post->id);
$likers = $comments['usersWhoLiked'];

function checkIfLoggedUserLikedComment($id_comment, $arrayOfUsers)
{
    $id_user = isset($_SESSION['user']) ? (int) $_SESSION['user']->id : null;

    foreach ($arrayOfUsers as $user) {
        if ($user->id_comment == $id_comment && $user->id_user == $id_user) {
            return true;
        }
    }
    return false;
}

?>
<div class="mt-5 dt-comment">
    <?php if ($comments['totalElements'] > 0) : ?>
        <h4 id="total-comments" class="mb-5">Total : <?= $comments['totalElements'] ?> comments</h4>
        <h4 id="current-comm-page" class="mb-5">Page : 1</h4>
    <?php endif; ?>

    <div id="post-comments">
        <?php
        foreach ($comments['content'] as $comment) :
        ?>
            <div id="comment-<?= $comment->id ?>" class="dc-item">
                <div class="dc-pic">
                    <img src="assets/img/details/comment/comment-1.jpg" alt="">
                </div>
                <div class="dc-text">
                    <h5><?= $comment->username ?></h5>
                    <span class="c-date"><?= date("F j, Y. H:i", strtotime($comment->created_at)) ?></span>
                    <p id="comment-content-<?= $comment->id ?>" class="word-wrap"><?= $comment->content ?></p>

                    <?php if (isset($_SESSION['user'])) : ?>
                        <div class="row">
                            <div class="ml-4 dt-tags">
                                <a href="#" class="toggle-like-comment" data-id="<?= $comment->id ?>" data-post="<?= $post->id ?>"><span><i style="color:<?= checkIfLoggedUserLikedComment($comment->id, $likers) ? 'red' : '' ?>" class="fa fa-heart" aria-hidden="true"></i></span> <strong><?= ((int) $comment->totalUsersLiked != 0) ? $comment->totalUsersLiked : '' ?></strong></a>
                                <?php if ($_SESSION['user']->id == $comment->created_by) : ?>
                                    <a href="#" class="toggle-edit-comment" data-id="<?= $comment->id ?>" data-post="<?= $post->id ?>"><span><i class="fa fa-wrench" aria-hidden="true"></i></span></a>
                                <?php endif; ?>
                                <?php if (($_SESSION['user']->id == $comment->created_by) || ($_SESSION['user']->id_role == 1)) : ?>
                                    <a href="#" class="generic-switch generic-open" data-id="<?= $comment->id ?>" data-action="delete-comment"><span><i class="fa fa-times" aria-hidden="true"></i></span></a>
                                <?php endif; ?>

                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- <?php if (isset($_SESSION['user'])) : ?>
                        <div class="cancel-edit-comment">
                            <a href="#" data-id="reply-btn-<?= $comment->id ?>" class="reply-btn"><span>Reply</span></a>
                        </div>
                    <?php endif; ?> -->

                </div>
            </div>

        <?php endforeach; ?>

        <div id="edit-comment" class="dc-item elementDissapear">
            <div class="dc-pic">
                <img src="assets/img/details/comment/comment-1.jpg" alt="">
            </div>
            <div class="dc-text">
                <h5><?= $comment->username ?></h5>
                <div class="mt-3 dt-leave-comment">
                    <form action="#">
                        <textarea id="edit-comment-content" class="comment-content-edit text-white" placeholder="Message"></textarea>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-4">
                                <button type="button" id="btn-save-edit-comment-content" data-id="" data-post=""><span>Save</span></button>
                            </div>
                            <div class="col-2"></div>
                            <div class="col-4">
                                <button type="button" id="btn-cancel-edit-comment-content" data-id=""><span>Cancel</span></button>
                            </div>
                            <div class="col-1"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


    <?php if (isset($_SESSION['user'])) : ?>
        <div class="dt-comment">
            <div class="dc-item">
                <div class="dc-pic">
                    <img src="assets/img/details/comment/comment-1.jpg" alt="">
                </div>
                <div class="dc-text">
                    <h5><?= $_SESSION['user']->username ?></h5>
                    <div class="mt-3 dt-leave-comment">
                        <form action="#">
                            <textarea id="comment-content" class="text-white" placeholder="Message"></textarea>
                            <button type="button" data-post="<?= $post->id ?>" id="comment-add">Add comment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <input type="hidden" data-post="<?= $post->id ?>" id="selected-offset-comments-main" />

    <div id="pag-comments" class="pagination-item">
        <div class="row">
            <div class="col">
                <?php
                for ($i = 0; $i < $comments['totalPages']; $i++) : ?>
                    <a href="#" class="comments-pagination" data-post="<?= $post->id ?>" data-limit="<?= $i ?>"><span><?= $i + 1 ?></span></a>
                <?php endfor; ?>
            </div>
            <?php if ($comments['totalPages'] > 0) : ?>
                <div class="col">
                    <select id="offset-comments-main" class="ddl">
                        <option value="4">4</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                    </select>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <input type="hidden" id="selected-page-comments" />
</div>
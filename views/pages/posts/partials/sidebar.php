<?php

//EXPORT POST DETAILS EXCEL

if (isset($_POST['btnExcel'])) {

    // misbehaving, would open but page blocks

    // $excel = new COM("Excel.Application");
    // $excel->Visible = 1;
    // $excel->DisplayAlerts = 1;
    // $workbook = $excel->Workbooks->Open("http://localhost/amin/models/Posts/Post.xlsx", -4143) or die('Did not open filename');
    // $sheet = $workbook->Worksheets('Posts');
    // $sheet->activate;
    // $br = 1;
    // foreach ($posts as $post) {

    //     $cell = $sheet->Range("A{$br}");
    //     $cell->activate;
    //     $cell->value = $post->title;


    //     $cell = $sheet->Range("B{$br}");
    //     $cell->activate;
    //     $cell->value = $post->category;


    //     $cell = $sheet->Range("C{$br}");
    //     $cell->activate;
    //     $cell->value = $post->content;


    //     $cell = $sheet->Range("D{$br}");
    //     $cell->activate;
    //     $cell->value = $post->created_at;

    //     $br++;
    // }
    // exit();
}
?>

<div class="col-lg-4 col-md-7 p-0">
    <div class="sidebar-option">


        <?php if (isset($_SESSION['user'])) : ?>
            <?php if ($_SESSION['user']->id_role == 1) : ?>
                <div class="social-media">
                    <div class="section-title">
                        <h5>Admin actions</h5>
                    </div>
                    <ul>
                        <a href="index.php?page=posts&id=new">
                            <li>
                                <div class="sm-icon"><i class="fa fa-plus"></i></div>
                                <span>ADD POST</span>
                            </li>
                        </a>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>


        <div class="social-media">

            <div id="show-selected-page" class="section-title elementDissapear">
                <h5>Page</h5>
                <input type="hidden" id="selected-started-at" />

                <div id="selected-page" class="mt-3 pagination-item">
                    <a href="#" class="posts-pagination"><span>1</span></a>
                </div>

                <div id="clear-page" class="mt-3 subscribe-option">
                    <form action="#">
                        <button type="submit"><span>Clear</span></button>
                    </form>
                </div>

            </div>

            <div class="section-title">
                <h5 id="category-toggle">Categories</h5>
                <input type="hidden" id="selected-category-value" />
                <ul id="selected-category" class="mt-3 elementDissapear">

                </ul>

                <div id="clear-category" class="subscribe-option elementDissapear">
                    <form action="#">
                        <button type="submit"><span>Clear</span></button>
                    </form>
                </div>

            </div>
            <p>Filter posts by category</p>
            <ul>
                <?php
                $categories = getCategoriesForExistingPosts();
                foreach ($categories as $category) :
                ?>
                    <a href="#" class="post-category" data-id="<?= $category->id ?>">
                        <li>
                            <div class="sm-icon"><i class="fa fa-gamepad"></i></div>
                            <span><?= strtoupper($category->name) ?></span>
                            <div class="follow"><?= $category->numPosts ?> posts</div>
                        </li>
                    </a>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="subscribe-option">
            <div class="section-title">
                <h5>Search</h5>
            </div>
            <p>Filter posts by title</p>
            <form action="#">
                <input id="search-title" type="text" placeholder="Title">
                <div id="clear-title" class="mb-3 subscribe-option elementDissapear">
                    <form action="#">
                        <button type="submit"><span>Clear</span></button>
                    </form>
                </div>
                <p>Order posts by</p>
                <select class="w-100 ddl" id="order-posts">
                    <option value="0">Choose..</option>
                    <option value="1">Title - Ascending</option>
                    <option value="2">Title - Descending</option>
                    <option value="3">Latest</option>
                    <option value="4">Oldest</option>
                    <option value="5">Most comments</option>
                </select>
                <div id="clear-sort" class="mt-3 subscribe-option elementDissapear">
                    <form action="#">
                        <button type="submit"><span>Clear</span></button>
                    </form>
                </div>
                <div class="mt-5 subscribe-option">
                    <form method="POST" action="index.php?page=posts">
                        <button name="btnExcel" onclick="exportTableToExcel('tblData','amin-posts')" style="background: rgba(50, 135, 54, 0.5);" type="button"><span><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export with filters</span></button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>
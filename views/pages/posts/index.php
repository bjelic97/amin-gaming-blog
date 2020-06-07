 <!-- Categories Grid Section Begin -->
 <section class="categories-grid-section spad">
     <div class="container">
         <div class="row">
             <div class="col-lg-8 p-0">
                 <div id="posts" class="row">
                     <?php foreach ($posts as $post) : ?>
                         <div class="col-lg-6">
                             <div class="cg-item">
                                 <div class="cg-pic set-bg" data-setbg="<?= $post->src ?>">
                                     <div class="label"><span><?= strtoupper($post->category) ?></span></div>
                                 </div>
                                 <div class="cg-text">
                                     <h5><a href="index.php?page=posts&id=<?= $post->id ?>"><?= $post->title ?></a></h5>
                                     <ul>
                                         <li>by <span><?= $post->username ?></span></li>
                                         <li><i class="fa fa-clock-o"></i><?= $post->created_at ?></li>
                                         <li><i class="fa fa-comment-o"></i><?= $post->commNum ?></li>
                                     </ul>
                                     <p class="word-wrap"><?php if (strlen($post->content) > 300) {
                                                                echo substr($post->content, 0, 300) . ' ...';
                                                            } else {
                                                                echo $post->content;
                                                            } ?></p>
                                 </div>
                                 <div class="pagination-item mt-5">
                                     <div class="row justify-content-between">
                                         <div class="col-3">
                                             <a href="index.php?page=posts&id=<?= $post->id ?>">Details</a>
                                         </div>
                                         <?php if (isset($_SESSION['user'])) : ?>
                                             <?php if ($_SESSION['user']->id_role == 1) : ?>
                                                 <div>
                                                     <a style="background: #0d0d0d; border: 1px solid #222222;" href="index.php?page=posts&id=<?= $post->id ?>">Edit</a>
                                                     <a class="generic-switch generic-open" data-id="<?= $post->id ?>" data-action="delete-post" style="background: rgba(194, 0, 0, 0.5)" href="#">Remove</a>
                                                 </div>
                                             <?php endif; ?>
                                         <?php endif; ?>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     <?php endforeach; ?>
                 </div>

                 <input type="hidden" id="selected-offset-main" />

                 <div id="pag" class="pagination-item">
                     <div class="row">
                         <div class="col">
                             <?php
                                for ($i = 0; $i < $response['totalPages']; $i++) : ?>
                                 <a href="#" class="posts-pagination" data-limit="<?= $i ?>"><span><?= $i + 1 ?></span></a>
                             <?php endfor; ?>
                         </div>
                         <?php if ($response['totalPages'] > 0) : ?>
                             <div class="col">
                                 <select id="offset-posts-main" class="ddl">
                                     <option value="4">4</option>
                                     <option value="10">10</option>
                                     <option value="20">20</option>
                                 </select>
                             </div>
                         <?php endif; ?>
                     </div>
                 </div>
             </div>
             <?php
                include "partials/sidebar.php";
                ?>
         </div>
     </div>
 </section>

 <!-- Categories Grid Section End -->

 <!-- SIMPLEST POSSIBLE EXPORT IN EXCEL IN JS, SINCE PHP WAS NOT WORKING FOR ME -->
 <table id="tblData" class="elementDissapear">
     <tr>
         <th>Title</th>
         <th>Category</th>
         <th>Content</th>
         <th>Posting date</th>
         <th>Owner</th>
         <th>Total comments</th>
     </tr>
     <?php foreach ($posts as $post) : ?>
         <tr>
             <td><?= $post->title ?></td>
             <td><?= $post->category ?></td>
             <td><?= $post->content ?></td>
             <td><?= $post->created_at ?></td>
             <td><?= $post->username ?></td>
             <td><?= $post->commNum ?></td>
         </tr>
     <?php endforeach; ?>

 </table>

 <!-- END SIMPLEST POSSIBLE EXPORT IN EXCEL IN JS, SINCE PHP WAS NOT WORKING FOR ME-->
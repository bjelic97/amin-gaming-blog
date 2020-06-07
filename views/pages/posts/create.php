<div style="background-color:#080808" class="signup-text">
    <div class="container">
        <div class="signup-title">
            <h2>New post</h2>
            <p>Fill out the form below to create a new post.</p>
        </div>
        <div class="details-text">
            <div class="dt-leave-comment">
                <form class="signup-form">
                    <div class="sf-input-list">
                        <input id="title" name="title" type="text" class="input-value" placeholder="Title *">
                        <select class="w-100 ddl" name="categories" id="categories">
                            <option value="0">Choose category *</option>
                            <?php
                            $categories = getCategories();
                            foreach ($categories as $category) :
                            ?>
                                <option value="<?= $category->id ?>"><?= strtoupper($category->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <textarea class="text-white" id="content" name="content" placeholder=" Content *"></textarea>
                        <input class="input-value pt-2" type='file' id="uploaded-img" />
                        <img class="blah" src="assets/img/default-image.jpg" />
                    </div>
                    <button class="w-100 mt-4 mb-2" type="button" id="create-post"><span>Create</span></button>
                </form>
            </div>
        </div>

    </div>
</div>
<?php if ($_GET['id'] == 'new') : ?>
    <?php if (isset($_SESSION['user'])) : ?>
        <?php if ($_SESSION['user']->id_user_role == 1) : ?>
            <?php include "create.php" ?>
        <?php endif; ?>  
    <?php endif; ?>
<?php endif; ?>


<?php if ($_GET['id'] != 'new') : ?>
    <?php include "update.php" ?>
<?php endif; ?>
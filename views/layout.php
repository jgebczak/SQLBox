<?php Box::renderPartial('header'); ?>
<?php Box::renderPartial('sidebar'); ?>


<div id='page'>

    <div id='panel'>

        <div class='bg_white' style='height:2.5em'>

            <?php if (Box::islogged()): ?>

                <span class='left small_container bg_gray_14'>
                    Mysql > Server
                </span>

                <div class='right small_container'>
                    <a class='right' href="#">Logout</a>
                </div>

            <?php endif ?>

        </div>

        <div class='container bl_gray_11 bg_blue_14'>
            <h1>Login</h1>
        </div>


        <div class='alert_box error' style='display:none'>
            <i class="fa fa-exclamation-triangle"></i><span class='msg'></span>
        </div>

        <div class='alert_box success' style='display:none'>
            <i class="fa fa-check-square"></i><span class='msg'></span>
        </div>

        <?=$content?>

        </div>

</div>


<?php Box::renderPartial('footer'); ?>
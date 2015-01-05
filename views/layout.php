<?php Box::renderPartial('header'); ?>
<?php Box::renderPartial('sidebar'); ?>


<div id='page'>

    <div id='panel'>

        <div class='bg_white' style='height:2.5em'>

            <?php if (Box::islogged()): ?>

                <span class='left small_container bg_gray_14'>

                    <a href="/"><?=Box::$engine?></a>

                    <?php if (Box::$sql): ?>
                        > <a href="/?user=<?=Box::$user?>&server=<?=Box::$server?>">Server</a>
                        > <a href="/?user=<?=Box::$user?>&server=<?=Box::$server?>&db=<?=Box::$db?>"><?=Box::$db?></a>
                        > Custom query

                    <?php elseif (Box::$add): ?>
                        > <a href="/?user=<?=Box::$user?>&server=<?=Box::$server?>">Server</a>
                        > <a href="/?user=<?=Box::$user?>&server=<?=Box::$server?>&db=<?=Box::$db?>"><?=Box::$db?></a>
                        > Insert: <?=Box::$add?>

                    <?php elseif (Box::$edit): ?>
                        > <a href="/?user=<?=Box::$user?>&server=<?=Box::$server?>">Server</a>
                        > <a href="/?user=<?=Box::$user?>&server=<?=Box::$server?>&db=<?=Box::$db?>"><?=Box::$db?></a>
                        > Edit: <?=Box::$edit?>

                    <?php elseif (Box::$select): ?>
                        > <a href="/?user=<?=Box::$user?>&server=<?=Box::$server?>">Server</a>
                        > <a href="/?user=<?=Box::$user?>&server=<?=Box::$server?>&db=<?=Box::$db?>"><?=Box::$db?></a>
                        > Data: <?=Box::$select?>

                    <?php elseif (Box::$table): ?>
                        > <a href="/?user=<?=Box::$user?>&server=<?=Box::$server?>">Server</a>
                        > <a href="/?user=<?=Box::$user?>&server=<?=Box::$server?>&db=<?=Box::$db?>"><?=Box::$db?></a>
                        > Table: <?=Box::$table?>

                    <?php elseif (Box::$db): ?>
                        > <a href="/?user=<?=Box::$user?>&server=<?=Box::$server?>">Server</a>
                        > <?=Box::$db?>
                    <?php else: ?>
                        > Server
                    <?php endif ?>

                </span>

                <div class='right small_container'>
                    <a class='right' href="?logout">Logout</a>
                </div>

            <?php endif ?>

        </div>

        <div class='container bl_gray_11 bg_blue_14'>
            <h1><?=Box::$title?></h1>
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
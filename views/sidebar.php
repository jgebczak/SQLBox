<!-- SIDEBAR -->
<!-- =============================================================================================================== -->

    <header id='sidebar' class='left'>

        <div class='bg_white' style='height:2.5em'></div>

        <div class='container bl_gray_11 bg_gray_14'>
            <h1>sqlbox <small>v.<?=Box::$ver?></small></h1>
        </div>


        <?php if (!Box::isLogged()): ?>

            <div class='container bl_gray_13'>
                Log in first <i class="fa fa-chevron-circle-right gray9"></i>
            </div>

        <?php elseif (Box::$action=='select_db'): ?>

            <div class='container bl_gray_13'>
                Select database <i class="fa fa-chevron-circle-right gray9"></i>
            </div>

        <?php else: ?>

<!--             <div class='container bl_gray_13'>

                <a href="#">SQL</a> |
                <a href="#">Import</a> |
                <a href="#">Dump</a>

            </div>
 -->
            <div class='container bl_gray_13'>

                <?php if ($tables = Box::getTables()): ?>

                    <?php foreach ($tables as $t): ?>
                        <a class='gray8' href="<?=Box::url(array('select'=>$t))?>">select</a> <a href="<?=Box::url(array('table'=>$t))?>"><?=$t?></a><BR>
                    <?php endforeach ?>

                <?php else: ?>

                    There are no tables.

                <?php endif; ?>
            </div>


        <?php endif; ?>


    </header>

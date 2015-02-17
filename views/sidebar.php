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

            <div class='container bl_gray_13'>

                <a href="<?=Box::url(array('sql'=>''))?>">SQL</a>
<!--                 <a href="#">Import</a> |
                <a href="#">Dump</a>
 -->
            </div>



        <?php include('widgets/sidebar.table_search.php'); ?>

        <!-- LIST OF TABLES -->

<!--             <div style='text-align:center'>
                <a style='font-size:0.9em; color:purple' href="<?=Box::url(array('create'=>''))?>">+ Create new table</a>
            </div>
 -->
            <div class='container bl_gray_13 sidebar_tables'>

                <?php if ($tables = Box::getTables()): ?>

                    <?php foreach ($tables as $t): ?>

                        <div class='sidebar_table' data-name='<?=$t?>'>
                            <a class='gray8' href="<?=Box::url(array('select'=>$t))?>">select</a> <a href="<?=Box::url(array('table'=>$t))?>"><?=Helper::shorten($t,17)?></a>
                        </div>

                    <?php endforeach ?>

                <?php else: ?>

                    There are no tables.

                <?php endif; ?>
            </div>


        <?php endif; ?>

    </header>


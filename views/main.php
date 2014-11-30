<?php Box::render('header'); ?>


<div id='page'>

<!-- SIDEBAR -->
<!-- =============================================================================================================== -->

    <header id='sidebar' class='left'>

        <div class='bg_white' style='height:2.5em'></div>

        <div class='container bl_gray_11 bg_gray_14'>
            <h1>sqlbox <small>v.<?=Box::$ver?></small></h1>
        </div>


        <div class='container bl_gray_13'>

            <a href="#">SQL</a> |
            <a href="#">Import</a> |
            <a href="#">Dump</a>

        </div>

        <div class='container bl_gray_13'>

            <?php foreach ($tables as $t): ?>

              <a href="#">[select]</a> <?=$t?><BR>

            <?php endforeach ?>

        </div>
    </header>


<!-- MAIN PANEL -->
<!-- =============================================================================================================== -->

    <div id='panel'>

        <div class='bg_white' style='height:2.5em'>

            <span class='left small_container bg_gray_14'>
                Mysql > Server
            </span>

            <div class='right small_container'>
                <a class='right' href="#">Logout</a>
            </div>

        </div>


        <div class="clear"></div>

        <div class='container bl_gray_11 bg_blue_14'>
            <h1>Database: some</h1>
        </div>

        <div class='container'>

            content!<BR>
            ddd<BR>
            ddd<BR>

        </div>

    </div>


</div>

<!--
<div id='header'>


    <strong id='logo'><span class='blue'>sql</span>box</strong>
    <small id='version_info'></small>
    <div class="clear"></div>
</div>
 -->

<!-- <div style='background-color:red; width:30vmin; height:30vmin'>
xxddddddddd
</div>
 -->


<?php Box::render('footer'); ?>
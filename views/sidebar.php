<!-- SIDEBAR -->
<!-- =============================================================================================================== -->

    <header id='sidebar' class='left'>

        <div class='bg_white' style='height:2.5em'></div>

        <div class='container bl_gray_11 bg_gray_14'>
            <h1>sqlbox <small>v.<?=Box::$ver?></small></h1>
        </div>


        <?php if (Box::isLogged()): ?>

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


        <?php else: ?>

            <div class='container bl_gray_13'>

                Log in first >

            </div>

        <?php endif ?>


    </header>

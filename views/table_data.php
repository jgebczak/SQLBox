<style type="text/css">

    xmp
    {
        display:inline;
        padding:0px;
        margin:0px;
        white-space:pre;
    }

</style>


<div class='container'>
    <form>

    Current database: <strong><?=Box::$db?></strong>

    <BR><BR>
    <!-- ACTION BUTTONS (DATA, STRUCTURE ETC.) -->

    <a class='button big selected' href='<?=Box::url(array('select'=>Box::$select))?>'>Data</a>
    <a class='button big' href='<?=Box::url(array('table'=>Box::$select))?>'>Structure</a>

<?php if (0):?>
    <a class='button big' href='<?=Box::url(array('table'=>Box::$select))?>'>Alter</a>
    <a class='button big' href='<?=Box::url(array('table'=>Box::$select))?>'>New Item</a>
<?php endif; ?>

    <!-- FILTERS (LIMIT) -->
    <div class='right'>
            <input type='hidden' name='user'   value='<?=Box::$user?>' />
            <input type='hidden' name='server' value='<?=Box::$server?>' />
            <input type='hidden' name='db'     value='<?=Box::$db?>' />
            <input type='hidden' name='select' value='<?=Box::$select?>' />

            Text length
            <input class='sm' type='number' name='text_length' value='<?=Box::$text_length?>'/>

            Limit
            <input class='sm' type='number' name='limit' value='<?=Box::$limit?>'/>
            <button type='submit' class='button small'>Refresh</button>
    </div>

    <div class="clear"></div>
    <BR>

    <!-- QUERY VIEW -->
    <?php if (Box::$query): ?>
    <div class='query'>
        <script type="syntaxhighlighter" class="brush: sql"><![CDATA[
<?=Box::$query?>
       ]]></script>
    </div>
    <?php endif; ?>

    <BR>


    <!-- SELECT, SEARCH AND SORTING -->

    Select:
    <input placeholder='Comma separated names' class='lg' type='text' name='fields' value='<?=Table::$fields?>'/>
    <div class="clear space"></div>


    <!-- DATA -->

        <table border='1' class='data' id='columns'>

            <tr class='header'>
            <?php foreach ($columns as $c): ?>
                <th><?=$c['COLUMN_NAME']?></th>
            <?php endforeach ?>
            </tr>

            <?php foreach ($data as $row): ?>

                <?php $i = 0; ?>
                <tr>
                    <?php foreach ($row as $key => $value): ?>
                        <td>
                            <xmp><?=Box::value($value,$columns[$i])?></xmp>
                        </td>
                        <?php $i++; ?>
                    <?php endforeach ?>
                </tr>

            <?php endforeach ?>

        </table>


    <!-- PAGINATION -->

    <div class="clear"></div>
    <BR>
    <?php if (Table::$pages>1): ?>

    <div class='pagination'>

        <?php if (Box::$page>1): ?>
            <a href="<?=Box::url(array('page'=>Box::$page-1),$keep=1)?>">Prev</a>
        <?php endif ?>

        <?php if (Box::$page>6): ?>
            <a href="<?=Box::url(array('page'=>1),$keep=1)?>">1</a> ...
        <?php endif ?>

        <?php
        for ($i=Box::$page-5; $i < Box::$page+5; $i++) {

            if ($i > 0 && $i <= Table::$pages) {
            ?>
                <a <?=($i==Box::$page)?'class="current"':''?> href="<?=Box::url(array('page'=>$i),$keep=1)?>"><?=$i?></a>
            <?php
            }
        }
        ?>
        <?php if (Box::$page<Table::$pages - 4): ?>
            ... <a href="<?=Box::url(array('page'=>Table::$pages),$keep=1)?>"><?=Table::$pages?></a>
        <?php endif ?>

        <?php if (Box::$page < Table::$pages): ?>
            <a href="<?=Box::url(array('page'=>Box::$page+1),$keep=1)?>">Next</a>
        <?php endif ?>

    </div>

    <?php endif ?>

    </form>
</div>

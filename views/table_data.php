<?php include('widgets/table.sorting_tooltip.php'); ?>


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



    <!-- =========================================================================================================== -->
    <!-- ACTION BUTTONS (DATA, STRUCTURE ETC.) -->

    <a class='button big selected' href='<?=Box::url(array('select'=>Box::$select))?>'>Data</a>
    <a class='button big' href='<?=Box::url(array('table'=>Box::$select))?>'>Structure</a>

<?php if (0):?>
    <a class='button big' href='<?=Box::url(array('table'=>Box::$select))?>'>Alter</a>
    <a class='button big' href='<?=Box::url(array('table'=>Box::$select))?>'>New Item</a>
<?php endif; ?>




    <!-- =========================================================================================================== -->
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
            <button id='btn_refresh' type='submit' class='button small'>Refresh</button>
    </div>

    <div class="clear"></div>
    <BR>




    <!-- =========================================================================================================== -->
    <!-- QUERY VIEW -->

    <span class='query_time'>Execution time: <?=Box::$query_time?> s</span>

    <?php if (Box::$query): ?>
    <div class='query'>
        <script type="syntaxhighlighter" class="brush: sql"><![CDATA[
<?=Box::$query?>
       ]]></script>
    </div>
    <?php endif; ?>

    <BR>




    <!-- =========================================================================================================== -->
    <!-- SELECT, SEARCH AND SORTING -->

    Search:
    <input placeholder='ie. id>1' class='lg' type='text' id='search' name='search' value="<?=Table::$search?>"/>

    Select:
    <input placeholder='Comma separated names' class='lg' type='text' id='fields' name='fields' value='<?=Table::$fields?>'/>

    Sort by:
    <select id='sort' name='sort'>
        <?php if ($columns) foreach ($columns as $kname => $c): ?>
                <?php $sel = (Table::$sort == $kname) ? 'selected="selected"':''?>
                <option <?=$sel?> value='<?=$kname?>'><?=$kname?></option>
        <?php endforeach; ?>
    </select>

    <select id='order' name='order'>
            <?php $sel_asc  = (Table::$order == 'ASC') ?  'selected="selected"':''?>
            <option <?=$sel_asc?>  value='ASC'>Ascending</option>

            <?php $sel_desc = (Table::$order == 'DESC') ? 'selected="selected"':''?>
            <option <?=$sel_desc?> value='DESC'>Descending</option>
    </select>
    <button type='submit' class='button small'>Refresh</button>
    <div class="clear space10"></div>



    <!-- =========================================================================================================== -->
    <!-- DATA -->

    <?php if ($data): ?>

        <table border='1' class='data' id='columns'>

            <tr class='header'>
                <th>

                </th>
            <?php foreach ($columns as $kname => $c): ?>
                <th class='column'><?=$c ? $c['COLUMN_NAME']:$kname?></th>
            <?php endforeach ?>
            </tr>

            <?php foreach ($data as $row): ?>

                <?php $i = 0; ?>
                <tr>
                    <td>
                        <a href='<?=Box::url(array('edit'=>Box::$select,'where'=>$primary_key.'='.$row[$primary_key]))?>'><i class="fa fa-pencil-square-o"></i></a>
                    </td>
                    <?php foreach ($row as $key => $value): ?>
                        <td>
                            <xmp style='<?=Box::format($value,$columns[$key])?>'><?=Box::value($value,$columns[$key])?></xmp>
                        </td>
                        <?php $i++; ?>
                    <?php endforeach ?>
                </tr>

            <?php endforeach ?>

        </table>

    <?php else: ?>

    <BR>
    No data returned.

    <?php endif ?>




    <!-- =========================================================================================================== -->
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




<script type="text/javascript">
//----------------------------------------------------------------------------------------------------------------------

var current_column = '';

    function sortColumn(order)
    {
        if (!current_column || current_column == '') return;
        $("#sort").val(current_column)
        $("#order").val(order)
        $("form").submit();
    }

    $(document).ready(function(){
        $("#search").focus().select();
    });

//----------------------------------------------------------------------------------------------------------------------
</script>
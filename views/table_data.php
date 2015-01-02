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

    Current database: <strong><?=Box::$db?></strong>

    <BR><BR>
    <!-- ACTION BUTTONS (DATA, STRUCTURE ETC.) -->

    <a class='button big selected' href='<?=Box::url(array('select'=>Box::$select))?>'>Data</a>
    <a class='button big' href='<?=Box::url(array('table'=>Box::$select))?>'>Structure</a>

    <!-- FILTERS (LIMIT) -->
    <div class='right'>
        <form>
            <input type='hidden' name='user'   value='<?=Box::$user?>' />
            <input type='hidden' name='server' value='<?=Box::$server?>' />
            <input type='hidden' name='db'     value='<?=Box::$db?>' />
            <input type='hidden' name='select' value='<?=Box::$select?>' />

            Text length
            <input class='sm' type='number' name='text_length' value='<?=Box::$text_length?>'/>

            Limit
            <input class='sm' type='number' name='limit' value='<?=Box::$limit?>'/>
            <button type='submit' class='button small'>Refresh</button>
        </form>
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
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        ...
        <a href="#"><?=Table::$pages?></a>
    </div>

    <?php endif ?>

</div>

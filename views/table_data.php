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
    <a class='button big' href='<?=Box::url('select',Box::$select)?>'>Data</a>
    <a class='button big' href='<?=Box::url('table',Box::$select)?>'>Structure</a>


        <BR><BR>

        <div class="clear"></div>

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

</div>

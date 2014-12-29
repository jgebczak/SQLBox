
<!-- MAIN PANEL -->

<div class='container'>

    Current database: <strong><?=Box::$db?></strong>

    <BR><BR>
    <a class='button big' href='<?=Box::url('select',Box::$table)?>'>Data</a>
    <a class='button big' href='<?=Box::url('table',Box::$table)?>'>Structure</a>


        <BR><BR>

        <div class="clear"></div>

        <table border='1' class='data' id='columns'>
            <tr class='header'>
                <th>Column</th>
                <th>Type</th>
                <th>Comment</th>
            </tr>

            <?php foreach ($columns as $c): ?>

                <tr data-name='<?=$c['COLUMN_NAME']?>'>
                    <td><strong><?=$c['COLUMN_NAME']?></strong></td>
                    <td>
                        <?=$c['COLUMN_TYPE']?>
                        <?=$c['EXTRA']?>
                        <?php if ($c['IS_NULLABLE']=='YES'): ?>
                            NULL
                        <?php endif ?>
                    </td>
                    <td><?=$c['COLUMN_COMMENT'];?></td>
                </tr>

            <?php endforeach ?>

        </table>

</div>


<!-- MAIN PANEL -->

<div class='container'>

    Current database: <strong><?=Box::$db?></strong>

    <BR><BR>

    <?php if ($tables): ?>

        <table border='1' class='data' id='tables'>
            <tr class='header'>
                <th>Table</th>
                <th>Data Size</th>
                <th>Engine</th>
                <th>Collation</th>
                <th>Rows</th>
                <th>Auto Inc.</th>
                <th>Comment</th>
            </tr>

            <?php foreach ($tables as $t): ?>

                <?php
                    $db = Box::$db;
                    $tname = $t['TABLE_NAME'];
                    $rows = Box::cmd("select count(*) from $db.$tname")->queryScalar();
                ?>

                <tr>
                    <td><a class='select_table' href="<?=Box::url('table',$t['TABLE_NAME'])?>"><?=$t['TABLE_NAME']?></a></td>
                    <td style='text-align:right'><?=Box::formatDataSize($t['DATA_LENGTH'])?></td>
                    <td><?=$t['ENGINE']?></td>
                    <td><?=$t['TABLE_COLLATION']?></td>
                    <td style='text-align:right'><?=number_format($rows)?></td>
                    <td style='text-align:right'><?=$t['AUTO_INCREMENT']?></td>
                    <td><?=$t['TABLE_COMMENT']?></td>
                </tr>

            <?php endforeach ?>

        </table>


    <?php else: ?>

        There are no tables.

    <?php endif ?>

</div>

<script type="text/javascript">
//----------------------------------------------------------------------------------------------------------------------
// navigation up and down

$(document).ready(function(){

     // select first item as default (skip header though)
     $("#tables tr").not('.header').eq(0).addClass('selected');

     // up/down navigation
     $(document).keydown(function (event){

                var key = event.which;
                var isSelected = $("#tables tr.selected").size()>0;
                var cur = $("#tables tr.selected");

                if (key == KEY_UP || key == KEY_DOWN)
                {
                    if (!isSelected)
                    {
                        $("#tables tr").not('.header').eq(0).addClass('selected');
                        return;
                    }
                }

                if (key == KEY_ENTER)
                {
                    window.location.href = cur.find('a.select_table').attr('href');
                }

                if (key == KEY_DOWN)
                {
                    if (cur.next().not('.header').size() == 0) return;
                    cur.removeClass('selected').next().addClass('selected');
                }

                if (key == KEY_UP)
                {
                    if (cur.prev().not('.header').size() == 0) return;
                    cur.removeClass('selected').prev().addClass('selected');
                }
    });
});

//----------------------------------------------------------------------------------------------------------------------
</script>



<div class='container'>

    <h3>Available databases:</h3>

    Click on the database name or use up/down arrows to navigate and enter to choose.<BR><BR>

    <?php if ($dbs): ?>

        <table border='1' class='data' id='databases'>
            <tr class='header'>
                <th>Database</th>
                <th>Tables</th>
                <th>Rows</th>
                <th>Data Size</th>
            </tr>

            <?php foreach ($dbs as $db => $details): ?>

                <tr>
                    <td><a href="?db=<?=$db?>"><?=$db?></a></td>
                    <td style='text-align:right'><?=$details['tables']?></td>
                    <td style='text-align:right'> <?=$details['rows']?></td>
                    <td style='text-align:right'><?=Box::formatDataSize($details['data_size'])?></td>
                </tr>

            <?php endforeach ?>

        </table>


    <?php else: ?>

        This user has not access to any database or there are no databases on this server.

    <?php endif ?>

</div>


<script type="text/javascript">
//----------------------------------------------------------------------------------------------------------------------
// navigation up and down

$(document).ready(function(){

     $(document).keydown(function (event){

                var key = event.which;
                var isSelected = $("#databases tr.selected").size()>0;
                var cur = $("#databases tr.selected");

                if (key == KEY_UP || key == KEY_DOWN)
                {
                    if (!isSelected)
                    {
                        $("#databases tr").not('.header').eq(0).addClass('selected');
                        return;
                    }
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


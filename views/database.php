
<!-- MAIN PANEL -->

<div class='container'>

    Current database: <strong><?=Box::$db?></strong>

    <BR><BR>

    <?php if ($tables): ?>


        <span class='fa-stack fa-lg gray12' style='font-size:1.0rem'>
            <i class="fa fa-circle fa-stack-2x"></i>
            <i style='color:white' class="fa fa-search fa-stack-1x"></i>
        </span>

        <input type='text' id='search' placeholder='Filter' />

        <BR><BR>
        <div class="clear"></div>

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

                <tr data-name='<?=$t['TABLE_NAME']?>'>
                    <td><a class='select_table' href="<?=Box::url(array('table'=>$t['TABLE_NAME']))?>"><?=$t['TABLE_NAME']?></a></td>
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

     $("#search").focus();

     $("#search").keyup(function(event){

        // perform search only if key pressed is alphanum (or backspace)
        var regex = new RegExp("^[a-zA-Z0-9\b]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }

        // apply filter by hiding rows not matching the selector
        var s = $("#search").val();
        if (s != '')
         {
            $("#tables tr").not('.header').each(function(){
                var name = $(this).data('name');
                if (name.indexOf(s) > -1)
                    $(this).show();
                else
                    $(this).hide();

                // move selection to the first match
                $("#tables tr").not('.header').removeClass('selected');
                $("#tables tr:visible").not('.header').eq(0).addClass('selected');
            });
         }
         else
            $("#tables tr").show();
     });

     // select first item as default (skip header though)
     $("#tables tr").not('.header').eq(0).addClass('selected');

     // up/down navigation
     $(document).keydown(function (event){

                // active only if table search menu is active
                if (!$('#search').is(':focus')) return;

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
                    event.preventDefault();
                    if (cur.nextAll(':visible').not('.header').size() == 0) return;
                    cur.removeClass('selected').nextAll(':visible').first().addClass('selected');
                }

                if (key == KEY_UP)
                {
                    event.preventDefault();
                    if (cur.prevAll(':visible').not('.header').size() == 0) return;
                    cur.removeClass('selected').prevAll(':visible').first().addClass('selected');
                }
    });
});

//----------------------------------------------------------------------------------------------------------------------
</script>

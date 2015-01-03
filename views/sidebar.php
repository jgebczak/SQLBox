<!-- SIDEBAR -->
<!-- =============================================================================================================== -->

    <header id='sidebar' class='left'>

        <div class='bg_white' style='height:2.5em'></div>

        <div class='container bl_gray_11 bg_gray_14'>
            <h1>sqlbox <small>v.<?=Box::$ver?></small></h1>
        </div>


        <?php if (!Box::isLogged()): ?>

            <div class='container bl_gray_13'>
                Log in first <i class="fa fa-chevron-circle-right gray9"></i>
            </div>

        <?php elseif (Box::$action=='select_db'): ?>

            <div class='container bl_gray_13'>
                Select database <i class="fa fa-chevron-circle-right gray9"></i>
            </div>

        <?php else: ?>

<!--             <div class='container bl_gray_13'>

                <a href="#">SQL</a> |
                <a href="#">Import</a> |
                <a href="#">Dump</a>

            </div>
 -->

        <!-- TABLE SEARCH -->


        <div style='padding:10px; margin-bottom:-10px'>

            <span class='fa-stack fa-lg gray12' style='font-size:1.0rem'>
                <i class="fa fa-circle fa-stack-2x"></i>
                <i style='color:white' class="fa fa-search fa-stack-1x"></i>
            </span>

            <input type='text' id='table_search' placeholder='Find Table...' />
        </div>

        <!-- LIST OF TABLES -->

            <div class='container bl_gray_13 sidebar_tables'>

                <?php if ($tables = Box::getTables()): ?>

                    <?php foreach ($tables as $t): ?>

                        <div class='sidebar_table' data-name='<?=$t?>'>
                            <a class='gray8' href="<?=Box::url(array('select'=>$t))?>">select</a> <a href="<?=Box::url(array('table'=>$t))?>"><?=$t?></a>
                        </div>

                    <?php endforeach ?>

                <?php else: ?>

                    There are no tables.

                <?php endif; ?>
            </div>


        <?php endif; ?>

    </header>


<script type="text/javascript">
//----------------------------------------------------------------------------------------------------------------------

    $("#table_search").focus();


    // Search by table name
    $("#table_search").keyup(function(event){

        // perform search only if key pressed is alphanum (or backspace)
        var regex = new RegExp("^[a-zA-Z0-9\b]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }

        // apply filter by hiding rows not matching the selector
        var s = $("#table_search").val();
        if (s != '')
         {
            $(".sidebar_table").each(function(){
                var name = $(this).data('name');
                if (name.indexOf(s) > -1)
                    $(this).show();
                else
                    $(this).hide();

                // move selection to the first match
                $(".sidebar_table").removeClass('selected');
                $(".sidebar_table:visible").eq(0).addClass('selected');
            });
         }
         else
            $(".sidebar_table").show();
     });



     // up/down navigation for selected table
     $(document).keydown(function (event){

                // active only if table search menu is active
                if (!$('#table_search').is(':focus')) return;

                var key = event.which;
                var isSelected = $(".sidebar_table.selected").size()>0;
                var cur = $(".sidebar_table.selected");

                if (key == KEY_UP || key == KEY_DOWN)
                {
                    if (!isSelected)
                    {
                        $(".sidebar_table").eq(0).addClass('selected');
                        return;
                    }
                }

                // open selected table when ENTER is pressed
                if (key == KEY_ENTER)
                {
                    var link = cur.eq(0).find('a').eq(0);
                    window.location.href = link.attr('href');
                }

                if (key == KEY_DOWN)
                {
                    event.preventDefault();
                    if (cur.nextAll(':visible').size() == 0) return;
                    cur.removeClass('selected').nextAll(':visible').first().addClass('selected');
                }

                if (key == KEY_UP)
                {
                    event.preventDefault();
                    if (cur.prevAll(':visible').size() == 0) return;
                    cur.removeClass('selected').prevAll(':visible').first().addClass('selected');
                }
    });


//----------------------------------------------------------------------------------------------------------------------
</script>

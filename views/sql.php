
<style type="text/css">
/* -------------------------------------------------------------------------------------------------------------------*/

 #query {
        width:100%;
        height:250px;
        font-size:1em;
        border:1px solid #ccc;
    }

/* -------------------------------------------------------------------------------------------------------------------*/
</style>


<div class='container'>

    <!-- =========================================================================================================== -->
    <!-- QUERY EDITOR -->

    <div id='query'><?=$_SESSION['sql']?></div>
    <div class="clear space15"></div>
    <a class='button big' href='javascript:submitQuery()'>Run Query</a>

    <!-- =========================================================================================================== -->
    <!-- QUERY RESULTS -->
    <div class="clear space15"></div>

    <?php
      // query, rows, non_select,rows_affected

    //debug ($_SESSION['queries']);

     ?>

    <?php
        if ($_SESSION['queries']) foreach ($_SESSION['queries'] as $i => $query):

        $status='';
        if ($query['error']) $status='<span style="color:red">Failed</span>';
        elseif ($query['rows']) $status=count($query['rows']).' row(s) returned';
        elseif ($query['rows_affected']) $status=count($query['rows_affected']).' rows affected';
    ?>

    <!-- =========================================================================================================== -->
    <!-- QUERY SUMMARY -->

    <span class='left'>
        Query <strong><?=($i+1)?> / <?=count($_SESSION['queries'])?></strong> - <?=$status?>
    </span>
    <?php if ($query['query_time']): ?>
        <span class='right'>
            <span class='query_time'>Execution time: <?=$query['query_time']?> s</span>
        </span>
    <?php endif ?>

    <div class="clear"></div>

    <!-- =========================================================================================================== -->
    <!-- QUERY SYNTAX (SQL) -->

    <div class='query'>
        <script type="syntaxhighlighter" class="brush: sql"><![CDATA[
<?=$query['query']?>
       ]]></script>
    </div>

    <!-- =========================================================================================================== -->
    <!-- ERROR MESSAGE (IF ANY) -->

    <?php if ($query['error']): ?>

        <div class='alert_box error'>
             <?=$query['error']?>
        </div>
        <div class="clear"></div>

    <?php else: ?>

    <!-- =========================================================================================================== -->
    <!-- RESULT (ROWS) -->


        <?php if (count($query['rows'])): ?>

        <table border='1' class='data' id='columns'>

                <tr class='header'>
                    <th>

                    </th>
                <?php foreach ($query['rows'][0] as $kname => $c): ?>
                    <th class='column'><?=$kname?></th>
                <?php endforeach ?>
                </tr>

                <?php foreach ($query['rows'] as $row): ?>

                    <tr>
                        <td>
                            <a href='#'><i class="fa fa-pencil-square-o"></i></a>
                        </td>
                        <?php foreach ($row as $key => $value): ?>
                            <td>
                                <xmp><?=$value?></xmp>
                            </td>
                        <?php endforeach ?>
                    </tr>

                <?php endforeach ?>

        </table>

        <?php else: ?>

            No rows returned.

        <?php endif ?>

    <?php endif ?>
    <div class="clear"></div>
    <BR />

    <?php endforeach; ?>
    <!-- =========================================================================================================== -->

</div>


<script src="/vendor/ace-20.12.14/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("query");
    editor.setTheme("ace/theme/clouds");
    editor.getSession().setMode("ace/mode/sql");
</script>




<script type="text/javascript">
//----------------------------------------------------------------------------------------------------------------------

    function submitQuery()
    {
        var  sql = editor.getValue();
        $.post("<?=Box::url(array())?>", {sql:sql}, function(response){

            // after running query(ies), reload the page and pull the results from the session
            if (response == 'ok')
                window.location.reload();
        })
    }

//----------------------------------------------------------------------------------------------------------------------

    $(document).ready(function(){
            editor.focus();

            $("#query").keydown(function(e){
                if (e.ctrlKey && e.keyCode === 13) {
                    submitQuery();
                }
            });

    });

//----------------------------------------------------------------------------------------------------------------------
</script>


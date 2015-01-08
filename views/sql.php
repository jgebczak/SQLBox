
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

    <!-- QUERY EDITOR -->

    <div id='query'><?=$_SESSION['sql']?></div>
    <div class="clear space15"></div>
    <a class='button big' href='javascript:submitQuery()'>Run Query</a>

    <!-- QUERY RESULTS -->
    <div class="clear space15"></div>

    <?php
      // query, rows, non_select,rows_affected
     ?>

    <?php
        if ($_SESSION['queries']) foreach ($_SESSION['queries'] as $i => $query):

        $status='';
        if ($query['error']) $status='<span style="color:red">Error</span>';
        elseif ($query['rows']) $status=count($query['rows']).' row(s) returned';
        elseif ($query['rows_affected']) $status=count($query['rows_affected']).' rows affected';
    ?>

    <span class='left'>
        Query <strong><?=($i+1)?> / <?=count($_SESSION['queries'])?></strong> - <?=$status?>
    </span>
    <?php if ($query['query_time']): ?>
        <span class='right'>
            <span class='query_time'>Execution time: <?=$query['query_time']?> s</span>
        </span>
    <?php endif ?>

    <div class="clear"></div>

    <div class='query'>
        <script type="syntaxhighlighter" class="brush: sql"><![CDATA[
<?=$query['query']?>
       ]]></script>
    </div>

    <?php if ($query['error']): ?>

        <div class='alert_box error'>
             <?=$query['error']?>
        </div>
        <div class="clear"></div>

    <?php else: ?>
        success.
    <?php endif ?>
    <div class="clear"></div>
    <BR />

    <?php endforeach; ?>

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


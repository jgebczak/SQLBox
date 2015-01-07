
<style type="text/css">
/* -------------------------------------------------------------------------------------------------------------------*/

 #query {
        width:100%;
        height:300px;
        font-size:1em;
        border:1px solid #ccc;
    }

/* -------------------------------------------------------------------------------------------------------------------*/
</style>


<div class='container'>

    <!-- QUERY RESULTS -->

    <pre>
    <?php print_r ($_SESSION['queries']); ?>
    </pre>

    <!-- QUERY EDITOR -->

    <div id='query'><?=$_SESSION['sql']?></div>
    <div class="clear space15"></div>
    <a class='button big' href='javascript:submitQuery()'>Run Query</a>

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
    });

//----------------------------------------------------------------------------------------------------------------------
</script>


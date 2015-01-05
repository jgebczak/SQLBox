
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

    <form action="<?=Box::url(array())?>" method='POST' enctype='multipart/form-data'>

    <div id='query'></div>

    </form>

    <div class="clear space15"></div>
    <input type='submit' class='button big' value='Run Query'/>

</div>


<script src="/vendor/ace-20.12.14/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("query");
    editor.setTheme("ace/theme/clouds");
    editor.getSession().setMode("ace/mode/sql");
</script>




<script type="text/javascript">
//----------------------------------------------------------------------------------------------------------------------

$(document).ready(function(){
        editor.focus();
        //editor.getValue();
});

//----------------------------------------------------------------------------------------------------------------------
</script>


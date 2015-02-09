<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

<style type="text/css">

    .action {
        cursor:pointer;
    }

</style>


<div class='container'>

    Table Name:
    <input name='name' type='text' id='name' />

    <select id='engine'>
        <?php if ($engines) foreach ($engines as $e): ?>
            <option value='<?=$e?>'><?=$e?></option>
        <?php endforeach; ?>
    </select>

    <select id='collation'>
        <?php if ($collations) foreach ($collations as $c): ?>
            <option value='<?=$c?>'><?=$c?></option>
        <?php endforeach; ?>
    </select>

    <BR><BR>


        <a class='small button' href='javascript:void(0)' onclick='addColumn()'>Add column</a>
        <BR><BR>


        <table style='display:none' id='column_template'>
        <tbody>
            <tr>
                <td><i class="fa fa-bars" style='cursor:pointer'></i></td>
                <td><input type='text' class='col_field' /></td>
                <td>
                    <select class='col_type'>
                        <option value='int'>int</option>
                        <option value='tinyint'>tinyint</option>
                        <option value='smallint'>smallint</option>
                        <option value='mediumint'>mediumint</option>
                        <option value='bigint'>bigint</option>
                        <option value='varchar'>varchar</option>
                    </select>
                </td>
                <td><input type='number'   class='col_length' /></td>
                <td><input type='checkbox' class='col_null' /></td>
                <td><input type='radio'    class='col_auto_inc' value="1"/> </td>
                <td><input type='text'     class='col_default' /></td>
                <td><input type='text'     class='col_comment' /></td>
                <td>
                    <i class="fa fa-plus action action_add"></i>
                    <i class="fa fa-remove action action_remove"></i>
                </td>
            </tr>
        </tbody>
        </table>

        <table border='1' class='data' id='columns'>
            <tr class='header'>
                <th></th>
                <th>Column Name</th>
                <th>Type</th>
                <th>Length</th>
                <th>NULL</th>
                <th>AI</th>
                <th>Default</th>
                <th>Comment</th>
                <th>Actions</th>
            </tr>
            <tbody>
            </tbody>
        </table>

        <BR>

        <a class='button big' href='javascript:void(0)' onclick='createTable()'>Create Table</a>
        <a class='button small' href='<?=Box::url(array('select'=>Box::$edit))?>'>Cancel</a>

</div>




<script type="text/javascript">
//----------------------------------------------------------------------------------------------------------------------

    function addColumn(parent)
    {
        // clone the template and append to the end of list of columns
        var h = $("#column_template tbody").html();

        if (typeof parent==='undefined')
        {
           $("#columns tr").last().after(h);
        }
        else
        {
            parent.after(h);
        }

        // bind actions
        $(".action_remove").off('click').on('click', function(){
            $(this).parent().parent().remove();
        });

        $(".action_add").off('click').on('click', function(){
            addColumn($(this).parent().parent());
        });
    }

//----------------------------------------------------------------------------------------------------------------------

    function createTable()
    {
        var columns = Array();

        $("#columns tbody tr").not('.header').each(function(){

            var column = {};
            column.name    = $(this).find('.col_field').val();
            column.type    = $(this).find('.col_type').val();
            column.length  = $(this).find('.col_length').val();
            column.null    = $(this).find('.col_null').is(':checked')?1:0;
            column.ai      = $(this).find('.col_auto_inc').is(':checked')?1:0;
            column.default = $(this).find('.col_default').val();
            column.comment = $(this).find('.col_comment').val();

            columns.push(column);

        });

        var collation = $("#collation").val();
        var engine    = $("#engine").val();
        var name      = $("#name").val();

        var url = '<?=Box::url(array('createsave'=>''))?>';

        $.post(url, {columns:columns,name:name,engine:engine,collation:collation}, function(response){

                if (response == 'ok')
                {
                    notification('success','Savings have been saved.');
                }
                else
                {
                    notification('error',response);
                }
        })

    }

//----------------------------------------------------------------------------------------------------------------------


    function runTest()
    {
        addColumn();

        // autopopulate for testing
        $(".col_field").eq(1).val('id');
        $(".col_field").eq(2).val('aaaa');
        $(".col_field").eq(3).val('bbbb');
        $(".col_field").eq(4).val('c');
        $(".col_type").eq(3).val('varchar');
        $(".col_length").eq(3).val('15');

        $(".col_null").eq(2).attr('checked','checked');
        $(".col_auto_inc").eq(1).attr('checked','checked');
        $(".col_comment").eq(4).val('comm');
        $(".col_default").eq(3).val('default');

        var n = Math.round(Math.random()*1000);
        $("#name").val('test'+n);
    }


//----------------------------------------------------------------------------------------------------------------------

    $(document).ready(function(){
        addColumn();
        addColumn();
        addColumn();

        runTest();

        $("#collation").val('utf8_general_ci');

        $( "#columns tbody" ).sortable({
            placeholder: "ui-state-highlight"
        });
        $( "#columns tbody" ).disableSelection();
    });

//----------------------------------------------------------------------------------------------------------------------
</script>


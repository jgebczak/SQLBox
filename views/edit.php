

<div class='container'>

    <form action="<?=Box::url(array('editsave'=>Box::$edit, 'where'=>Edit::$where))?>" method='POST' enctype='multipart/form-data'>

        <table border='1' class='data' id='databases'>
            <tr class='header'>
                <th>Field</th>
                <th>Value</th>
            </tr>

            <?php foreach ($columns as $c): ?>

            <?php
                $col  = $c['COLUMN_NAME'];
                $type = Box::dataType($c['DATA_TYPE']);

                echo $type;

                $v    = $values[$col];
                $v    = str_replace('"',"&quot;", $v);
             ?>

                <tr>
                    <td><?=$col?></td>
                    <td>
                        <input type='text' name='<?=$col?>' value="<?=$v?>"/>
                    </td>
                </tr>

            <?php endforeach ?>

        </table>

        <BR>
        <input type='submit' class='button small' value='Save'/>
        <a class='button small' href='<?=Box::url(array('select'=>Box::$edit))?>'>Cancel</a>

    </form>

</div>




<script type="text/javascript">
//----------------------------------------------------------------------------------------------------------------------

$(document).ready(function(){
});

//----------------------------------------------------------------------------------------------------------------------
</script>


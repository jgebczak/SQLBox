

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
                $v    = $values[$col];
                $v    = str_replace('"',"&quot;", $v);

             ?>

                <tr>
                    <td style='min-width:130px;'><?=$col?></td>
                    <td>
                        <?php if ($type=='number' || $type=='float'): ?>
                             <input type='number' name='<?=$col?>' value="<?=$v?>"/>
                        <?php endif ?>

                        <?php if ($type=='char'): ?>
                             <input style='width:300px' type='text' name='<?=$col?>' value="<?=$v?>"/>
                        <?php endif ?>

                        <?php if ($type=='datetime'): ?>
                             <input type='text' name='<?=$col?>' value="<?=$v?>"/>
                        <?php endif ?>

                        <?php if ($type=='enum'): ?>
                             <input type='text' name='<?=$col?>' value="<?=$v?>"/>
                        <?php endif ?>

                        <?php if ($type=='set'): ?>
                             <input type='text' name='<?=$col?>' value="<?=$v?>"/>
                        <?php endif ?>

                        <?php if ($type=='timestamp'): ?>
                             <input type='text' name='<?=$col?>' value="<?=$v?>"/>
                        <?php endif ?>

                        <?php if ($type=='date'): ?>
                             <input type='date' name='<?=$col?>' value="<?=$v?>"/>
                        <?php endif ?>

                        <?php if ($type=='time'): ?>
                             <input type='text' name='<?=$col?>' value="<?=$v?>"/>
                        <?php endif ?>

                        <?php if ($type=='text'): ?>
                             <textarea style='width:300px' rows='5' name='<?=$col?>'><?=$v?></textarea>
                        <?php endif ?>

                        <?php if ($type=='blob'): ?>
                             Blob data cannot be edited.
                        <?php endif ?>


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


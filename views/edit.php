

<div class='container'>

    <form action="<?=Box::url(array('editsave'=>Box::$edit, 'mode' => $mode, 'where'=>Edit::$where))?>" method='POST' enctype='multipart/form-data'>

        <table border='1' class='data' id='databases'>
            <tr class='header'>
                <th>Field</th>
                <th>Value</th>
                <th>Comment</th>
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
                    <td class='value'>
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

                            <select style='min-width:150px' name='<?=$col?>'>
                                <?php if ($enum_values = Edit::getEnumValues(Box::$edit, $col)) foreach ($enum_values as $enum_v): ?>
                                    <?=Html::option($enum_v,'',$enum_v,$enum_v==$v)?>
                                <?php endforeach; ?>
                            </select>
                        <?php endif ?>

                        <?php if ($type=='set'): ?>
                             <?php
                                $set_values = explode(',', $v);
                             ?>
                             <?php foreach (Edit::getSetValues(Box::$edit,$col) as $i => $set_v): ?>
                                <?=Html::checkbox($col."[$i]",$set_v,in_array($set_v, $set_values))?>
                             <?php endforeach ?>
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
                    <td style='max-width:500px;'>
                        <div style='text-wrap:unrestricted; word-wrap:break-word'>
                         <?=$c['COLUMN_COMMENT']?>
                        </div>
                    </td>
                </tr>

            <?php endforeach ?>

        </table>

        <BR>

        <?php if ($mode=='add'): ?>
            <input type='submit' class='button big' value='Insert'/>
        <?php else: ?>
            <input type='submit' class='button big' value='Save'/>
        <?php endif ?>

        <a class='button small' href='<?=Box::url(array('select'=>Box::$edit))?>'>Cancel</a>

        <?php if ($mode=='edit'): ?>
            <a class='button small red' onclick='return confirm("Are you sure?");' href='<?=Box::url(array('delete'=>Box::$edit, 'where'=>Edit::$where))?>'>Delete</a>
        <?php endif; ?>

    </form>

</div>




<script type="text/javascript">
//----------------------------------------------------------------------------------------------------------------------

$(document).ready(function(){
        $(".value").eq(0).find('input,textarea,select').focus();
});

//----------------------------------------------------------------------------------------------------------------------
</script>


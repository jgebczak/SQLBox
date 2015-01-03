

<div class='container'>

        <table border='1' class='data' id='databases'>
            <tr class='header'>
                <th>Field</th>
                <th>Value</th>
            </tr>

            <?php foreach ($columns as $c): ?>

                <tr>
                    <td><?=$c['COLUMN_NAME']?></td>
                    <td>
                        <input type='text'/>
                    </td>
                </tr>

            <?php endforeach ?>

        </table>

        <BR>
        <a class='button small' href='javascript:void(0)' onclick='Save'>Save</a>
        <a class='button small' href='javascript:void(0)' onclick='Save'>Cancel</a>

</div>




<script type="text/javascript">
//----------------------------------------------------------------------------------------------------------------------

$(document).ready(function(){
});

//----------------------------------------------------------------------------------------------------------------------
</script>


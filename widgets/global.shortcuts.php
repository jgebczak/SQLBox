<!-- SHORTCUT HANDLER -->
<input type="text" id="shortcut" name="shortcut" style='z-index:-100;position:absolute' />



<script type="text/javascript">
//----------------------------------------------------------------------------------------------------------------------

$(document).ready(function(){

        // install "function key" (shortcut listener activated by Escape)
        $(document).keydown(function (event){

                var key = event.which;

                //console.log(key);
                if (key == 17) isCtrl = true;
                if (key == 27)
                {
                    console.log('Shortcut ready');
                    $("#shortcut").focus();
                }
        });

        // actual shortcuts
        $("#shortcut").keydown(function (event){
            var key = event.which;

            // search tables ("T")
            if (key == 84)
            {
                console.log('Shortcut: search tables');
                $("#table_search").focus();
                event.preventDefault();
            }
        });

});


//----------------------------------------------------------------------------------------------------------------------
</script>
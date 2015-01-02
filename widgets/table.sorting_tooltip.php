<!-- TOOLTIP FOR SORTING BY COLUMN -->
<span id='column_tooltip' style='padding:5px; background:#ccc; display:none; position:absolute'>
    <a id='sort_asc' href='javascript:sortColumn("ASC")'><i style='padding-left:0px; margin-right:0px; text-weight:normal' class="fa fa-caret-square-o-up"></i></a>
    <a id='sort_desc' href='javascript:sortColumn("DESC")'><i style='margin-right:0px; text-weight:normal' class="fa fa-caret-square-o-down"></i></a>
</span>


<script type="text/javascript">
//----------------------------------------------------------------------------------------------------------------------

    $(document).ready(function(){

        $(".column").hover(function(){
            current_column = $(this).text();

            $("#column_tooltip").appendTo($(this))
                                .css('top', $(this).offset().top-20)
                                .css('left', $(this).offset().left)
                                .show();
        },

        function(){
            $("#column_tooltip").hide();
        });

    });

//----------------------------------------------------------------------------------------------------------------------
</script>
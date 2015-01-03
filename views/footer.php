
          <script src="js/main.js"></script>

    </body>
</html>


<script type="text/javascript">
//----------------------------------------------------------------------------------------------------------------------

// maintain same height for sidebar and main content
$(document).ready(function() {

    var currHeight = $(window).height();
    $('#sidebar, #panel').css('height', currHeight);

    $(window).resize(function() {
        var currHeight = $(window).height();
        $('#sidebar, #panel').css('height', currHeight);
    });
});

//----------------------------------------------------------------------------------------------------------------------
</script>
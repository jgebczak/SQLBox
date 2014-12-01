
<!-- LOGIN -->
<!-- =============================================================================================================== -->

    <div id='panel'>

        <div class='bg_white' style='height:2.5em'>
        </div>

        <div class='container bl_gray_11 bg_blue_14'>
            <h1>Login</h1>
        </div>


        <div class='alert_box error' style='display:none'>
            <i class="fa fa-exclamation-triangle"></i><span class='msg'></span>
        </div>

        <div class='alert_box success' style='display:none'>
            <i class="fa fa-check-square"></i><span class='msg'></span>
        </div>



        <div class='container'>

            This version supports MySQL only.<BR><BR>

            <table id='login_form' class='form'>
                <tr>
                    <td>Server</td>
                    <td><input type='text' id='server' /></td>
                </tr>
                <tr>
                    <td>Login</td>
                    <td><input type='text' id='login' /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='password' id='pass' /></td>
                </tr>
            </table>

            <BR>

            <a class='button big' href='javascript:void(0)' onclick=''>Login</a>

        </div>

    </div>



<script type="text/javascript">
//----------------------------------------------------------------------------------------------------------------------

    function login()
    {
            notification('error','NO!')
    }

//----------------------------------------------------------------------------------------------------------------------


    $(document).ready(function(){
        $("#server").focus();

        // react on enter key
        enter('#server,#login','next');
        enter('#pass',login);
    });

//----------------------------------------------------------------------------------------------------------------------
</script>

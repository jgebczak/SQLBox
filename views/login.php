
<!-- LOGIN -->
<!-- =============================================================================================================== -->

<div class='container'>

    This version supports MySQL only.<BR><BR>

    <table id='login_form' class='form'>
        <tr>
            <td>Server</td>
            <td><input placeholder='localhost' type='text' id='server' /></td>
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

    <a class='button big' href='javascript:void(0)' onclick='login()'>Login</a>

</div>


<script type="text/javascript">
//----------------------------------------------------------------------------------------------------------------------

    function login()
    {
        var server = $("#server").val();
        var login = $("#login").val();
        var pass = $("#pass").val();

        $.post("?ajax=login", {server:server,login:login,pass:pass}, function(response){
            if (response == 'ok')
            {
                window.location.href = '?user=login';
            }
            else
            {
                notification('error',response);
            }
        })
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

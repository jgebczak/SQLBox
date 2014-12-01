<?php

class Box {

//----------------------------------------------------------------------------------------------------------------------

    static $ver = '0.1';

    // db handler
    static $db;

//----------------------------------------------------------------------------------------------------------------------

    // set pw in session for now
    static function init()
    {
        $_SESSION['user']       = 'root';
        $_SESSION['pass']       = 'CocaCola';
        $_SESSION['server']     = 'localhost';
        $_SESSION['connection'] = 'mysql:host=localhost;dbname=kb';
    }

//----------------------------------------------------------------------------------------------------------------------

    static function isLogged()
    {
        return $_REQUEST['username'];
    }


//----------------------------------------------------------------------------------------------------------------------

    static function cmd($q)
    {
        return new Command (Box::$db, $q);
    }

//----------------------------------------------------------------------------------------------------------------------

    static function connect()
    {
        try {
                Box::$db = new PDO($_SESSION['connection'], $_SESSION['user'], $_SESSION['pass']);
            }
            catch (PDOException $e) {
                die ($e->getMessage());
            }

        Box::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

//----------------------------------------------------------------------------------------------------------------------

    static function error($msg)
    {
        die('Error: '.$msg);
    }

//----------------------------------------------------------------------------------------------------------------------

    static function actionLogin()
    {
        Box::render('login');
        die();
    }

//----------------------------------------------------------------------------------------------------------------------

    static function ajaxLogin()
    {
        $server = $_REQUEST['server'];
        $login = $_REQUEST['login'];
        $pass = $_REQUEST['pass'];

        die($pass);
    }

//----------------------------------------------------------------------------------------------------------------------

    static function route()
    {
        //ajax requests
        if (isset($_REQUEST['ajax']))
        {
            $f = 'ajax'.$_REQUEST['ajax'];
            Box::$f();
            return;
        }

        // is user selected? match proper connection data by user
        if (!isset($_REQUEST['user']))
        {
            Box::actionLogin();
        }

        if (!isset($_REQUEST['db']))
        {
            // database selection
        }

        // all other actions (custom SQL, table select, table structure, variables, status, privileges, processes etc)

        $data['tables'] = Box::getTables();
        Box::render('main', $data);
    }

//----------------------------------------------------------------------------------------------------------------------

    static function renderPartial ($view, $data=null,$return=false)
    {
        if ($data)
            extract ($data);

        if ($return) ob_start();
        $view_file = "./views/$class/".$view.'.php';

        if (!file_exists($view_file))
            Box::error("View file does not exist: $view");

        require ($view_file);
        if ($return) return ob_get_clean();
    }

//----------------------------------------------------------------------------------------------------------------------

    static function render($view, $data=null, $return = false)
    {
        $class = strtolower(str_replace('Controller','',get_class ($this)));

        $content = Box::renderPartial ($view, $data, true);
        if ($return) ob_start();
            require ("views/layout.php");
        if ($return) return ob_get_clean();
    }

//----------------------------------------------------------------------------------------------------------------------

    static function getTables()
    {
        return Box::cmd('show tables')->queryColumn();
    }

//----------------------------------------------------------------------------------------------------------------------
}

?>
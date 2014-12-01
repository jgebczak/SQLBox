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

    static function route()
    {
        // is user selected? match proper connection data by user
        if (!isset($_REQUEST['user']))
        {
            // login
        }

        if (!isset($_REQUEST['db']))
        {
            // database selection
        }

        // all other actions (custom SQL, table select, table structure, variables, status, privileges, processes etc)

        $data['tables'] = Box::getTables();
        Box::render('layout', $data);
    }

//----------------------------------------------------------------------------------------------------------------------

    static function render($view, $data=null,$return=false)
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

    static function getTables()
    {
        return Box::cmd('show tables')->queryColumn();
    }

//----------------------------------------------------------------------------------------------------------------------
}

?>
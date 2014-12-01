<?php

class Box {

//----------------------------------------------------------------------------------------------------------------------

    static $ver = '0.1';

    // db handler
    static $db;
    static $title;

//----------------------------------------------------------------------------------------------------------------------

    static function isLogged()
    {
        return $_REQUEST['user'];
    }


//----------------------------------------------------------------------------------------------------------------------

    static function cmd($q)
    {
        return new Command (Box::$db, $q);
    }

//----------------------------------------------------------------------------------------------------------------------

    static function connect()
    {
        // if user is set, try to make connection
        $user = $_REQUEST['user'];
        $server = $_REQUEST['server'];
        if (!$server) $server='localhost';

        if ($user)
        {
            $data = $_SESSION['users'][$user.'@'.$server];
            if (!$data) return;

            $engine = $data['engine'];
            $engine::connect($server,$data['user'],$data['pass']);
        }
    }

//----------------------------------------------------------------------------------------------------------------------

    static function error($msg)
    {
        die('Error: '.$msg);
    }

//----------------------------------------------------------------------------------------------------------------------

    static function actionLogin()
    {
        Box::$title = 'Login';
        Box::render('login', $data);
        die();
    }

//----------------------------------------------------------------------------------------------------------------------

    static function ajaxLogin()
    {
        $server = $_REQUEST['server'];
        $login  = $_REQUEST['login'];
        $pass   = $_REQUEST['pass'];
        $engine = $_REQUEST['engine'];

        if (!$server) $server='localhost';

        // make a test connection
        $test = $engine::testConnection($server,$login,$pass);

        if ($test != 'ok')
            die($test);

        // if successful, add connection to the session
        $_SESSION['users'][$login.'@'.$server] =
           array(
                'user'   => $login,
                'pass'   => $pass,
                'server' => $server,
                'engine' => $engine
            );

        die('ok');
    }

//----------------------------------------------------------------------------------------------------------------------
// debug view

    static function debug()
    {
        $debug = $_REQUEST['debug'];

        if ($debug=='clear')
        {
            session_unset();
            die('Session reset');
        }

        echo '<pre>';
        echo 'Session:<BR>';
        print_r ($_SESSION);
        echo '<BR><BR>';
        echo 'DB handler:<BR>';
        print_r (Box::$db);
    }


//----------------------------------------------------------------------------------------------------------------------

    static function route()
    {
        // debug mode
        if (isset($_REQUEST['debug']) && isDev())
        {
            Box::debug();
            return;
        }

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
            Box::$title = 'Select database';
            $data['dbs'] = Box::getDatabases();
            Box::render('databases', $data);
        }

        // all other actions (custom SQL, table select, table structure, variables, status, privileges, processes etc)

        // main view (list of tables)
        Box::$title = 'Content';
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

    static function getDatabases()
    {
        return Box::cmd('show databases')->queryColumn();
    }

//----------------------------------------------------------------------------------------------------------------------
}

?>
<?php

class Box {

//----------------------------------------------------------------------------------------------------------------------

    static $ver = '0.1';

    // db handler
    static $dbh;
    static $title;
    static $action;

    // current user
    static $user;
    static $server;
    static $engine;
    static $db;

    // temporary data
    static $query;

    // actions
    static $table;
    static $select;

    // filters
    static $limit;
    static $text_length;
    static $page;


//----------------------------------------------------------------------------------------------------------------------

    static function isLogged()
    {
        return $_REQUEST['user'];
    }


//----------------------------------------------------------------------------------------------------------------------
// trim each line within a string (to remove indentation)

    static function trimLines($s)
    {
        $lines = explode("\n", $s);
        if ($lines) foreach ($lines as $i => $line) {
            $lines[$i] = ltrim($line);
        }
        return implode("\n", $lines);
    }


//----------------------------------------------------------------------------------------------------------------------

    static function cmd($q)
    {
        return new Command (Box::$dbh, $q);
    }

//----------------------------------------------------------------------------------------------------------------------

    static function redirect($url)
    {
        header("Location: $url");
        die();
    }

//----------------------------------------------------------------------------------------------------------------------

    static function value ($v, $column)
    {
        $maxlen = Box::$text_length ? Box::$text_length : 50;

        if (strlen($v) >= $maxlen)
        {
            $v = substr($v,0,$maxlen).' ...';
        }
        return $v;
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

            // no user found or session has expired?
            if (!$data) Box::redirect('/');

            $engine = $data['engine'];
            $engine::connect($server,$data['user'],$data['pass'],$_REQUEST['db']);

            // connection failed or lost?
            if (!Box::$dbh)
                 Box::redirect('/');

            Box::$user   = $user;
            Box::$server = $server;
            Box::$engine = $engine;
            Box::$db     = $db;
        }
    }

//----------------------------------------------------------------------------------------------------------------------

    static function error($msg)
    {
        die('Error: '.$msg);
    }

//----------------------------------------------------------------------------------------------------------------------

    static function formatDataSize($v)
    {
        $k = 1024;

        if ($v > 1024*$k)
        {
            $count = number_format($v / (1024*$k),2);
            return "<strong style='color:green'>$count</strong> MB";
        }
        else
        {
            $count = number_format($v / $k,2);
            return "<span style='color:green'>$count</span> KB";
        }
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
        print_r (Box::$dbh);
    }


//----------------------------------------------------------------------------------------------------------------------

    static function route()
    {
        Box::$db = $_REQUEST['db'];

        // debug mode
        if (isset($_REQUEST['debug']) && isDev())
        {
            Box::$action='debug';
            Box::debug();
            return;
        }

        // logout
        if (isset($_REQUEST['logout']))
        {
            session_unset();
            PT::redirect('/');
            return;
        }


        //ajax requests
        if (isset($_REQUEST['ajax']))
        {
            $f = 'ajax'.$_REQUEST['ajax'];
            Box::$action='ajax';
            Box::$f();
            return;
        }

        // is user selected? match proper connection data by user
        if (!isset($_REQUEST['user']) || !$_SESSION['users'] || !Box::$dbh)
        {
            Actions::login();
        }

        // if no db set, go to selection
        if (!Box::$db)
        {
            // database selection
            Box::$title = 'Select database';
            $data['dbs'] = Box::getDatabases();
            Box::$action='select_db';
            Box::render('databases', $data);
            return;
        }

        // table - structure
        if (isset($_REQUEST['table']))
        {
            Box::$table = $_REQUEST['table'];
            Table::actionIndex();
            return;
        }

        // table - data (select)
        if (isset($_REQUEST['select']))
        {
            Box::$select = $_REQUEST['select'];
            Table::actionData();
            return;
        }


        // db selected, go to tables
        Database::actionIndex();

        // all other actions (custom SQL, table select, table structure, variables, status, privileges, processes etc)

        // main view (list of tables)

        // todo
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
// create URL with new parameters, pass the existing standard ones
// accepts array as argument or [key,value] pair

    // CONTINUE: accept as array key/value, extra parameter ($keep) to move all existing parameters (parse_url).

    // url(field, value, keep)
    static function url($params,$keep=0)
    {
       if (!$params['user'])   $params['user']   = Box::$user;
       if (!$params['server']) $params['server'] = Box::$server;
       if (!$params['db'])     $params['db']     = Box::$db;

       return '/?'.http_build_query($params);
    }


//----------------------------------------------------------------------------------------------------------------------

    static function getDatabases()
    {
        $dbs = Box::cmd('show databases')->queryColumn();

        foreach ($dbs as $db) {

            $rest[$db] = array();

            $tables = Box::cmd('select TABLE_NAME from information_schema.TABLES where table_schema = :db')->bindParam(':db',$db)->queryColumn();

            // count total rows in all tables within the db
            $rows = 0;
            if ($tables) foreach ($tables as $t) {
                $rows += Box::cmd("select count(*) FROM $db.$t")->queryScalar();
            }

            $res[$db]['tables'] = Box::cmd('select count(*) from information_schema.TABLES where table_schema = :db')->bindParam(':db',$db)->queryScalar();
            $res[$db]['rows'] = number_format($rows);
            $res[$db]['data_size'] = Box::cmd('select sum(data_length) from information_schema.TABLES where table_schema = :db')->bindParam(':db',$db)->queryScalar();
        }

        return $res;
    }

//----------------------------------------------------------------------------------------------------------------------
}

?>
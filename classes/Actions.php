<?php

class Actions {

//----------------------------------------------------------------------------------------------------------------------
// login

    static function login()
    {
        Box::$title = 'Login';
        Box::$action='login';
        Box::render('login', $data);
        die();
    }

//----------------------------------------------------------------------------------------------------------------------
// database view (after selecting one)

    static function database()
    {
        Box::$title = 'Database: '.Box::$db;
        Box::$action = 'database';

        $data['tables'] = Box::getTablesWithDetails();

        Box::render('database', $data);
    }


//----------------------------------------------------------------------------------------------------------------------
}

?>
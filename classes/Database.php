<?php

class Database {


//----------------------------------------------------------------------------------------------------------------------

    static function getTablesWithDetails()
    {
        $tables = Box::cmd('SELECT * FROM information_schema.tables WHERE table_schema = :db')
                 ->bindValue(':db', Box::$db)
                 ->queryAll();

        return $tables;
    }

//----------------------------------------------------------------------------------------------------------------------
// database view (after selecting one)

    static function actionIndex()
    {
        Box::$title = 'Database: '.Box::$db;
        Box::$action = 'database';

        $data['tables'] = Database::getTablesWithDetails();

        Box::render('database', $data);
    }


//----------------------------------------------------------------------------------------------------------------------
}

?>
<?php

class Table {


//----------------------------------------------------------------------------------------------------------------------

    static function getColumns ($table)
    {
        $columns = Box::cmd('SELECT *
                             FROM information_schema.columns
                             WHERE table_schema = :db
                             AND table_name = :table
                             ORDER BY ordinal_position ASC
                             ')
         ->bindValue(':db', Box::$db)
         ->bindValue(':table', $table)
         ->queryAll();

        return $columns;
    }

//----------------------------------------------------------------------------------------------------------------------

    static function getData ($table)
    {
        $data = Box::cmd("SELECT * FROM $table
                          ORDER BY id desc
                          LIMIT 10")
         ->queryAll();

        return $data;
    }

//----------------------------------------------------------------------------------------------------------------------
// data view (select)

    static function actionData()
    {
        Box::$title = 'Table: '.Box::$table;
        Box::$action = 'select';

        // get table data
        $data['data']    = Table::getData(Box::$select);
        $data['columns'] = Table::getColumns(Box::$select);

        Box::render('table_data', $data);
    }

//----------------------------------------------------------------------------------------------------------------------
// default view - structure (list of columns)

    static function actionIndex()
    {
        Box::$title = 'Table: '.Box::$table;
        Box::$action = 'table';

        // get table structure
        $data['columns'] = Table::getColumns(Box::$table);

        Box::render('table', $data);
    }


//----------------------------------------------------------------------------------------------------------------------
}

?>
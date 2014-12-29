<?php

class Table {

//----------------------------------------------------------------------------------------------------------------------

static $total_rows;

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
        Table::$total_rows = Box::cmd("SELECT count(*) FROM $table")
                 ->queryScalar();

        $limit = Box::$limit;

        $q = "SELECT * FROM $table
                       ORDER BY id desc
                       LIMIT $limit";

        $data = Box::cmd($q)
         ->queryAll();

        Box::$query = $q;
        return $data;
    }

//----------------------------------------------------------------------------------------------------------------------
// data view (select)

    static function actionData()
    {
        Box::$title = 'Data: '.Box::$select;
        Box::$action = 'select';

        // filters
        Box::$limit = $_REQUEST['limit'];
        if (!Box::$limit) Box::$limit = 10;

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
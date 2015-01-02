<?php

class Table {

//----------------------------------------------------------------------------------------------------------------------

// table properties
static $total_rows;
static $pages;

// table filters
static $fields;

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
        Table::$pages = ceil(Table::$total_rows / $limit);
        $fields = Table::$fields;

        $offset = 0;
        if (Box::$page>1)
        {
            $offset = (Box::$page-1) * $limit;
        }

        $q = Box::trimLines("SELECT $fields FROM $table
              ORDER BY id ASC
              LIMIT $offset,$limit");

        $data = Box::cmd($q)
         ->queryAll();

        Box::$query = $q;
        return $data;
    }

//----------------------------------------------------------------------------------------------------------------------
// data view (select)

    static function actionData()
    {
        // filters (limit, page, text length)
        Box::$limit = $_REQUEST['limit'];
        Box::$page  = $_REQUEST['page'];
        if (!Box::$page) Box::$page=1;
        Box::$text_length = $_REQUEST['text_length'];

        if (!Box::$limit) Box::$limit = 10;
        if (!Box::$text_length) Box::$text_length = 50;
        if (!Box::$page)  Box::$page = 1;

        // fields (columns)
        Table::$fields = $_REQUEST['fields'];
        if (!Table::$fields) Table::$fields = '*';

        // get table data
        $data['data']    = Table::getData(Box::$select);
        $data['columns'] = Table::getColumns(Box::$select);

        Box::$title = 'Data: '.Box::$select.' ('.Table::$total_rows.')';
        Box::$action = 'select';

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
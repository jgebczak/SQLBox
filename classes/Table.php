<?php

class Table {

//----------------------------------------------------------------------------------------------------------------------

// table properties
static $total_rows;
static $pages;

// table filters
static $fields;
static $sort;
static $order;
static $search;

//----------------------------------------------------------------------------------------------------------------------
// get all the columns for a table in a specified order

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
// based on the data return, grab the details for each column (if it is a column)

    static function getColumnDetails ($table,$data)
    {
        if (!$data || !$data[0]) return array();

        $fields = array_keys ($data[0]);
        $details = array();

        foreach ($fields as $f) {

            $details[$f] = Box::cmd('SELECT *
                                 FROM information_schema.columns
                                 WHERE table_schema = :db
                                 AND table_name     = :table
                                 AND column_name    = :field
                                 ')
             ->bindValue(':db', Box::$db)
             ->bindValue(':table', $table)
             ->bindValue(':field', $f)
             ->queryRow();

        }

        return $details;
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

        // specifying order only if used
        $order_block='';
        if (Table::$sort)
            $order_block = 'ORDER BY '.Table::$sort.' '.Table::$order;

        // search (WHERE block)
        $search_block = '';
        if (Table::$search)
            $search_block = 'WHERE '.Table::$search.PHP_EOL;

        $q = Box::trimLines("SELECT $fields FROM $table
              $search_block $order_block
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

        // sorting
        Table::$sort = $_REQUEST['sort'];
        Table::$order = $_REQUEST['order'];
        if (!Table::$order) Table::$order='DESC';

        // searching
        Table::$search = $_REQUEST['search'];
        Table::$search = str_replace('"',"'", Table::$search);

        // get table data
        $data['data']    = Table::getData(Box::$select);
        $data['columns'] = Table::getColumnDetails(Box::$select,$data['data']);

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
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
// get primary key that will be used to build a link for editing a record


    static function getPrimaryKey($columns)
    {
        foreach ($columns as $c) {
            if ($c['COLUMN_KEY']=='PRI')
                return $c['COLUMN_NAME'];
        }
    }


//----------------------------------------------------------------------------------------------------------------------

    static function getShorthand ($s)
    {
        // 5      =>   id = 5
        if (is_numeric($s))
            return 'id = '.$s;

        // 5-10   =>   id between 5 and 10 (with spaces around dash or without)
        if (preg_match('/^\d+\s*-\s*\d+$/', $s))
            return preg_replace('/(\d+)\s*-\s*(\d*)/', 'id BETWEEN $1 AND $2', $s);

        // 5+     =>   id >= 5
        if (preg_match('/^\d+\+$/', $s))
            return preg_replace('/^(\d+)\+$/', 'id >= $1', $s);

        // 5-     =>   id <= 5
        if (preg_match('/^\d+\-$/', $s))
            return preg_replace('/^(\d+)\-$/', 'id <= $1', $s);

        // >5     =>   id > 5
        if (preg_match('/^>\d+$/', $s))
            return preg_replace('/^>(\d+)$/', 'id > $1', $s);

        // <5     =>   id < 5
        if (preg_match('/^<\d+$/', $s))
            return preg_replace('/^<(\d+)$/', 'id < $1', $s);

        // >=5     =>   id >= 5
        if (preg_match('/^>=\d+$/', $s))
            return preg_replace('/^>=(\d+)$/', 'id >= $1', $s);

        // <=5     =>   id <= 5
        else if (preg_match('/^<=\d+$/', $s))
            return preg_replace('/^<=(\d+)$/', 'id <= $1', $s);


        // no matches?
        return $s;
    }

//----------------------------------------------------------------------------------------------------------------------

    static function getData ($table)
    {
        Box::$start_time = microtime(true);

        // specifying order only if used
        $order_block='';
        if (Table::$sort)
            $order_block = 'ORDER BY '.Table::$sort.' '.Table::$order;

        // search (WHERE block)
        $search_block = '';
        if (Table::$search)
        {
            $s = Table::$search;

            // translate shorthand expressions (if used)
            $s = Table::getShorthand($s);
            $search_block = 'WHERE '.$s.PHP_EOL;
        }

        // get totals rows (for pagination)
        Table::$total_rows = Box::cmd("SELECT count(*) FROM $table $search_block")
                 ->queryScalar();

        $limit = Box::$limit;
        Table::$pages = ceil(Table::$total_rows / $limit);
        $fields = Table::$fields;

        $offset = 0;
        if (Box::$page>1)
        {
            $offset = (Box::$page-1) * $limit;
        }

        // make paginated query now
        $q = Box::trimLines("SELECT $fields FROM $table
              $search_block $order_block
              LIMIT $offset,$limit");

        $data = Box::cmd($q)
                ->queryAll();

        Box::$end_time = microtime(true);
        Box::$query_time = number_format(Box::$end_time - Box::$start_time,3);

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
        $data['data']         = Table::getData(Box::$select);
        $data['columns']      = Table::getColumnDetails(Box::$select,$data['data']);
        $data['primary_key']  = Table::getPrimaryKey($data['columns']);

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
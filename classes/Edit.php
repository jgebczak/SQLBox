<?php

class Edit {

//----------------------------------------------------------------------------------------------------------------------

// filters/properties
static $where;


//----------------------------------------------------------------------------------------------------------------------
// default view - list all of fields top to bottom and allow editing

    static function actionIndex()
    {
        Box::$title = 'Edit: '.Box::$table;
        Box::$action = 'edit';

        // get table structure
        $data['columns'] = Table::getColumns(Box::$edit);

        Box::render('edit', $data);
    }


//----------------------------------------------------------------------------------------------------------------------
}

?>
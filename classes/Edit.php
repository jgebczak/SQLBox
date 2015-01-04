<?php

class Edit {

//----------------------------------------------------------------------------------------------------------------------

// filters/properties
static $where;


//----------------------------------------------------------------------------------------------------------------------

    static function getEnumValues( $table, $field )
    {
        $row = Box::cmd( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->queryRow();
        $type = $row['Type'];

        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    }

//----------------------------------------------------------------------------------------------------------------------
// default view - list all of fields top to bottom and allow editing

    static function actionIndex()
    {
        Box::$title = 'Edit: '.Box::$edit;
        Box::$action = 'edit';

        // get table structure
        $data['columns'] = Table::getColumns(Box::$edit);

        $table = Box::$edit;
        $where = Edit::$where;

        // get data
        $data['values'] = Box::cmd("SELECT *
                                    FROM $table
                                    WHERE $where")
         ->queryRow();

        Box::render('edit', $data);
    }


//----------------------------------------------------------------------------------------------------------------------

    static function actionSave()
    {
        $table = Box::$edit;
        $where = Edit::$where;

        // pass record data in POST and additional data (table and select statement) in GET
        $set = '';

        foreach ($_POST as $key => $value) {
            $set.="`$key` = :$key,".PHP_EOL;
        }

        // remove last comma and newline
        $set = trim($set,','.PHP_EOL);

        // prepare query
        $cmd = "UPDATE `$table`
                SET $set
                WHERE $where";

        $q = Box::cmd($cmd);

        // bind all values
        foreach ($_POST as $key => $value) {
            $q->bindValue(':'.$key, $value);
        }
        $q->execute();

        // go back to table
        Box::redirect(Box::url(array('select'=>$table,'msg'=>'Record has been updated')));

        return;
    }


//----------------------------------------------------------------------------------------------------------------------
}

?>
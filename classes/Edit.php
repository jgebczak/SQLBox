<?php

class Edit {

//----------------------------------------------------------------------------------------------------------------------

// filters/properties
static $where;


//----------------------------------------------------------------------------------------------------------------------
// Get possible values for Enum datatype

    static function getEnumValues( $table, $field )
    {
        $row = Box::cmd( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->queryRow();
        $type = $row['Type'];

        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    }

//----------------------------------------------------------------------------------------------------------------------
// Almost identical as getEnumValues

    static function getSetValues( $table, $field )
    {
        $row = Box::cmd( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->queryRow();
        $type = $row['Type'];

        preg_match("/^set\(\'(.*)\'\)$/", $type, $matches);
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

        $data['mode'] = 'edit';
        Box::render('edit', $data);
    }

//----------------------------------------------------------------------------------------------------------------------
// adding a new record - like editing, but without WHERE statement and without existing values

    static function actionAdd()
    {
        Box::$title = 'Insert: '.Box::$edit;
        Box::$action = 'add';

        // get table structure
        $data['columns'] = Table::getColumns(Box::$edit);
        $data['mode'] = 'add';

        $table = Box::$edit;
        Box::render('edit', $data);
    }



//----------------------------------------------------------------------------------------------------------------------
// save is used for editing and adding new records


    static function actionSave()
    {
        $table = Box::$edit;
        $where = Edit::$where;
        $mode = $_GET['mode'];
        $bindings = array();

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

        if ($mode == 'add')
        {
            $cmd = "INSERT INTO `$table`
                    SET $set";
        }

        $q = Box::cmd($cmd);

        // bind all values
        foreach ($_POST as $key => $value) {

            // if value is an array, we have a SET we need to convert to comma-separated string'
            if (is_array($value))
            {
                $set_values = Edit::getSetValues(Box::$edit, $key);
                $set_choices = array();

                foreach ($value as $k => $v) {
                    $set_choices[] = $set_values[$k];
                }

                $value = implode(',', $set_choices);
            }

            $bindings[$key] = $value;
            $q->bindValue(':'.$key, $value);
        }

        // debug
        //debug ($cmd, $bindings);

        $q->execute();

        // go back to table
        if ($mode=='add')
        {
            $msg = 'New record has been added';
        }
        else
        {
            $msg = 'Record has been updated';
        }

        Box::redirect(Box::url(array('select'=>$table,'msg'=>$msg)));
        return;
    }


//----------------------------------------------------------------------------------------------------------------------
}

?>
<?php

class Delete {

//----------------------------------------------------------------------------------------------------------------------

// filters/properties
static $where;

//----------------------------------------------------------------------------------------------------------------------
// normal delete (non-ajax)


    static function actionDelete()
    {
        $table = Box::$delete;
        $where = Delete::$where;

        $cmd = "DELETE FROM $table WHERE $where LIMIT 1";

        Box::cmd($cmd)->execute();

        // go back to tabl
        Box::redirect(Box::url(array('select'=>$table,'msg'=>'Record has been deleted')));
        return;
    }


//----------------------------------------------------------------------------------------------------------------------
}

?>
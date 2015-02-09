<?php
// creating & altering a table

class Alter {

//----------------------------------------------------------------------------------------------------------------------


    static function getEngines ()
    {
        return Box::cmd('SELECT *
                         FROM information_schema.engines
                         WHERE support = "YES"
                         ')
         ->queryColumn();
    }


//----------------------------------------------------------------------------------------------------------------------

    static function getCollations ()
    {
        return Box::cmd('SELECT *
                         FROM information_schema.collations')
         ->queryColumn();
    }

//----------------------------------------------------------------------------------------------------------------------


    static public function actionCreateSave()
    {
        $name      = $_REQUEST['name'];
        $engine    = $_REQUEST['engine'];
        $collation = $_REQUEST['collation'];
        $columns   = $_REQUEST['columns'];

        // build CREATE TABLE syntax

        $s = "CREATE TABLE `NAME` (\n";

            if ($columns) foreach ($columns as $c) {
                $null = $c['null']?'NULL':'';
                $default = $c['default']?"DEFAULT '{$c['default']}'":'';
                $comment = $c['comment']?"COMMENT '{$c['comment']}'":'';

                $s.= "`{$c['name']}` {$c['type']} $null $auto $key $default $comment,\n";
            }

        // remove last comma
        $s = trim($s,",\n");
        $s.="\n)";

        debug($s);
    }


//----------------------------------------------------------------------------------------------------------------------


    static public function actionCreate()
    {
        $data = array();
        Box::$title = 'Create new table';
        Box::$action = 'create';

        $data['engines'] = self::getEngines();
        $data['collations'] = self::getCollations();
        Box::render('create',$data);
    }


//----------------------------------------------------------------------------------------------------------------------


    static public function actionEdit()
    {
        $data = array();
        Box::$title = 'Alter a table: '.Box::$alter;
        Box::$action = 'alter';

        Box::render('alter',$data);
    }


//----------------------------------------------------------------------------------------------------------------------
}

?>
<?php

class SQL {

//----------------------------------------------------------------------------------------------------------------------
// custom query, editing view

    static function actionIndex()
    {
        $data = array();

        Box::$title = 'Custom Query';
        Box::$action = 'sql';

        Box::render('sql', $data);
    }

//----------------------------------------------------------------------------------------------------------------------

    static function processQuery($sql)
    {
        $q = Box::cmd ($sql);
        $h = $q->getHandler();
        $start_time = microtime(true);
        $h->execute();

        $end_time = microtime(true);
        $query_time = number_format($end_time - $start_time,3);

        // check syntax error
        $error = $h->errorInfo();

        if ($error[0] != '00000' && $error[0] != null)
        {
             $_SESSION['queries'][] = array(
                'query' => $sql,
                'error' => $error[0].' : '.$error[2],
             );
             return;
        }

        // fetch_assoc, fetch_named,
        // http://php.net/manual/en/pdostatement.fetch.php

        // fetch data and detect non-select queries
        /*
            CONTINUE: SOLVE PROBLEM WITH JOIN QUERIES (fields with same name ie. id are merged)
            SELECT * FROM users JOIN profiles

            so far works:
            - FETCH_NAMED
            - FETCH_NUM with getColumnMeta

        */

        // TEST ********************************************
        $r = $h->fetchAll(PDO::FETCH_NUM);
        $_SESSION['r'] = $r;
        $m0 = $h->getColumnMeta(0);
        $m11 = $h->getColumnMeta(10);
        debug ($m0,$m11);
        // TEST ********************************************


        $rows = $h->fetchAll(PDO::FETCH_ASSOC);
        $error = ($h->errorInfo());

        // fetching non-SELECT query?
        if ($error[0]=='HY000')
        {
            $_SESSION['queries'][] = array(
                'query'         => $sql,
                'rows_affected' => $h->rowCount(),
                'non_select'    => 1,
                'query_time'    => $query_time,
            );
            return;
        }

        $_SESSION['queries'][] = array(
            'query'         => $sql,
            'rows'          => $rows,
            'non_select'    => 0,
            'query_time'    => $query_time,
        );
    }


//----------------------------------------------------------------------------------------------------------------------

    static function actionProcess()
    {
        unset($_SESSION['queries']);
        unset($_SESSION['sql']);

        $sql = Box::$sql;
        $_SESSION['sql'] = $sql;

        $sql = trim($sql,' ');
        $sql = trim($sql,PHP_EOL);
        $sql = trim($sql,';');

        // split queries and run each one individually with it's own result set
        $queries = explode(';', $sql);
        if ($queries) foreach ($queries as $sql)
        {
            if ($sql)
                 SQL::processQuery($sql);
        }

        die('ok');
    }

//----------------------------------------------------------------------------------------------------------------------
}

?>
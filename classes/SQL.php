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

        // fetch data and detect non-select queries
        $rows = $h->fetchAll();
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
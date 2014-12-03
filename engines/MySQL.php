<?php
//----------------------------------------------------------------------------------------------------------------------

class MySQL
{

//----------------------------------------------------------------------------------------------------------------------

    private static $dbh;
    const ENGINE = 'mysql';

//----------------------------------------------------------------------------------------------------------------------

    static function testConnection ($server, $user,$pass)
    {
        try {
                MySQL::$dbh = new PDO(self::ENGINE.':host='.$server, $user, $pass);
            }
            catch (PDOException $e) {
                return ($e->getMessage());
            }

        return 'ok';
    }

//----------------------------------------------------------------------------------------------------------------------

    static function connect ($server,$user,$pass,$db='')
    {
        try {
                if ($db) $dbsel = ';dbname='.$db;
                $connectionString = self::ENGINE.':host='.$server.$dbsel;
                Box::$dbh = new PDO($connectionString, $user, $pass);
            }
        catch (PDOException $e) {
                Box::error($e->getMessage());
        }
    }

}

//----------------------------------------------------------------------------------------------------------------------
?>
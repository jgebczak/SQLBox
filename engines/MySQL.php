<?php
//----------------------------------------------------------------------------------------------------------------------

class MySQL
{

//----------------------------------------------------------------------------------------------------------------------

    private static $db;
    const ENGINE = 'mysql';

//----------------------------------------------------------------------------------------------------------------------

    static function testConnection ($server, $user,$pass)
    {
        try {
                MySQL::$db = new PDO(self::ENGINE.':host='.$server, $user, $pass);
            }
            catch (PDOException $e) {
                return ($e->getMessage());
            }

        return 'ok';
    }

//----------------------------------------------------------------------------------------------------------------------

    static function connect ($server,$user,$pass)
    {
        try {
                Box::$db = new PDO(self::ENGINE.':host='.$server, $user, $pass);
            }
        catch (PDOException $e) {
                Box::error($e->getMessage());
        }
    }

}

//----------------------------------------------------------------------------------------------------------------------
?>
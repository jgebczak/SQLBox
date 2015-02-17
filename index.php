<?php
//----------------------------------------------------------------------------------------------------------------------

ini_set('session.cookie_lifetime', 64000);
ini_set('session.gc_maxlifetime', 64000);

require('../pt2/PT.php');

//----------------------------------------------------------------------------------------------------------------------

error_reporting(E_ALL);

PT::import('classes/*');
PT::import('engines/*');

//PT::errorHandler(error);
PT::debugMode(PT::ip()=='127.0.0.1'?1:0);

PT::on('error.404',function(){echo 'Whoops, page not found!';});

PT::routeAll('Box.route');
PT::on('pt.start','Box::connect');

PT::start();

//----------------------------------------------------------------------------------------------------------------------

?>

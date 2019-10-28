<?php
include_once 'src/classes/Request.php';
include_once 'src/classes/Router.php';
$request = new Request();
Router::redirect($request);

/*exit;
if($endpoint)
{
    print "está en el home";
}
elseif ($endpoint == $endpoint."/about")
{
    print "está en acerca de ";
}
*/

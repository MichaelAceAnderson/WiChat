<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/view/includes/head.php');
?>
<style>
    b {
        text-shadow: 0 0 1px black;
        color: red;
    }

    span,
    b {
        text-shadow: 0px 0px 5px black, 2px 2px 0px black;
    }

    * {
        font-size: 25px;
    }
</style>
<?php
//SERVER VARS
echo "<h1>Server vars: </h1><br>\n";
echo "<b>PHP_SELF: </font></b><span>" . $_SERVER['PHP_SELF'] . "</span><br>\n";
echo "<b>GATEWAY_INTERFACE: </font></b><span>" . $_SERVER['GATEWAY_INTERFACE'] . "</span><br>\n";
echo "<b>SERVER_ADDR: </font></b><span>" . $_SERVER['SERVER_ADDR'] . "</span><br>\n";
echo "<b>SERVER_NAME: </font></b><span>" . $_SERVER['SERVER_NAME'] . "</span><br>\n";
echo "<b>SERVER_SOFTWARE: </font></b><span>" . $_SERVER['SERVER_SOFTWARE'] . "</span><br>\n";
echo "<b>SERVER_PROTOCOL: </font></b><span>" . $_SERVER['SERVER_PROTOCOL'] . "</span><br>\n";
echo "<b>REQUEST_METHOD: </font></b><span>" . $_SERVER['REQUEST_METHOD'] . "</span><br>\n";
echo "<b>REQUEST_TIME: </font></b><span>" . $_SERVER['REQUEST_TIME'] . "</span><br>\n";
echo "<b>REQUEST_TIME_FLOAT: </font></b><span>" . $_SERVER['REQUEST_TIME_FLOAT'] . "</span><br>\n";
echo "<b>DOCUMENT_ROOT: </font></b><span>" . $_SERVER['DOCUMENT_ROOT'] . "</span><br>\n";
echo "<b>HTTP_ACCEPT: </font></b><span>" . $_SERVER['HTTP_ACCEPT'] . "</span><br>\n";
echo "<b>HTTP_ACCEPT_CHARSET: </font></b><span>" . $_SERVER['HTTP_ACCEPT_CHARSET'] . "</span><br>\n";
echo "<b>HTTP_ACCEPT_ENCODING: </font></b><span>" . $_SERVER['HTTP_ACCEPT_ENCODING'] . "</span><br>\n";
echo "<b>HTTP_CONNECTION: </font></b><span>" . $_SERVER['HTTP_CONNECTION'] . "</span><br>\n";
echo "<b>HTTP_HOST: </font></b><span>" . $_SERVER['HTTP_HOST'] . "</span><br>\n";
echo "<b>HTTP_REFERER: </font></b><span>" . $_SERVER['HTTP_REFERER'] . "</span><br>\n";
echo "<b>HTTP_USER_AGENT: </font></b><span>" . $_SERVER['HTTP_USER_AGENT'] . "</span><br>\n";
echo "<b>HTTPS: </font></b><span>" . $_SERVER['HTTPS'] . "</span><br>\n";
echo "<b>REMOTE_ADDR: </font></b><span>" . $_SERVER['REMOTE_ADDR'] . "</span><br>\n";
echo "<b>REMOTE_HOST: </font></b><span>" . $_SERVER['REMOTE_HOST'] . "</span><br>\n";
echo "<b>REMOTE_PORT: </font></b><span>" . $_SERVER['REMOTE_PORT'] . "</span><br>\n";
echo "<b>REMOTE_USER: </font></b><span>" . $_SERVER['REMOTE_USER'] . "</span><br>\n";
echo "<b>REDIRECT_REMOTE_USER: </font></b><span>" . $_SERVER['REDIRECT_REMOTE_USER'] . "</span><br>\n";
echo "<b>SCRIPT_FILENAME: </font></b><span>" . $_SERVER['SCRIPT_FILENAME'] . "</span><br>\n";
echo "<b>SERVER_ADMIN: </font></b><span>" . $_SERVER['SERVER_ADMIN'] . "</span><br>\n";
echo "<b>SERVER_PORT: </font></b><span>" . $_SERVER['SERVER_PORT'] . "</span><br>\n";
echo "<b>SERVER_SIGNATURE: </font></b><span>" . $_SERVER['SERVER_SIGNATURE'] . "</span><br>\n";
echo "<b>PATH_TRANSLATED: </font></b><span>" . $_SERVER['PATH_TRANSLATED'] . "</span><br>\n";
echo "<b>SCRIPT_NAME: </font></b><span>" . $_SERVER['SCRIPT_NAME'] . "</span><br>\n";
echo "<b>REQUEST_URI: </font></b><span>" . $_SERVER['REQUEST_URI'] . "</span><br>\n";
echo "<b>PHP_AUTH_DIGEST: </font></b><span>" . $_SERVER['PHP_AUTH_DIGEST'] . "</span><br>\n";
echo "<b>PHP_AUTH_USER: </font></b><span>" . $_SERVER['PHP_AUTH_USER'] . "</span><br>\n";
echo "<b>PHP_AUTH_PW: </font></b><span>" . $_SERVER['PHP_AUTH_PW'] . "</span><br>\n";
echo "<b>AUTH_TYPE: </font></b><span>" . $_SERVER['AUTH_TYPE'] . "</span><br>\n";
echo "<b>PATH_INFO: </font></b><span>" . $_SERVER['PATH_INFO'] . "</span><br>\n";
echo "<b>ORIG_PATH_INFO: </font></b><span>" . $_SERVER['ORIG_PATH_INFO'] . "</span><br>\n";
//PHP Vars
echo "<h1>PHP Vars: </h1><br>\n";
echo "<b>Defined vars: </font></b><span>" . str_replace("\n", "<br>", print_r(get_defined_vars(), true)) . "</span><br>\n";
echo "<b>Defined constants: </font></b><span>" . str_replace("\n", "<br>", print_r(get_defined_constants(), true)) . "</span><br>\n";
echo "<b>Current working directory: </font></b><span>" . print_r(getcwd(), true) . "</span><br>\n";
echo "<b>__DIR__: </font></b><span>" . __DIR__ . "</span><br>\n";

//Custom
echo "<h1>Custom Vars:</h1>";
$conflen = strlen('SCRIPT');
$B = substr(__FILE__, 0, strrpos(__FILE__, '/'));
$A = substr($_SERVER['DOCUMENT_ROOT'], strrpos($_SERVER['DOCUMENT_ROOT'], $_SERVER['PHP_SELF']));
$C = substr($B, strlen($A));
$posconf = strlen($C) - $conflen - 1;
$D = substr($C, 1, $posconf);
$host = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $D;

echo "<b>Host: </font></b><span>" . $host . "</span><br>\n";
/* PHP Info
    echo "<b>PHP Info: </font></b><span>".phpinfo()."</span><br>\n";
    //SERVER VARS
    echo "<b>PHP Info 32: </font></b><span>".phpinfo(32)."</span><br>\n";
    */

/* Foreach SERVER VARS
    foreach($_SERVER as $key => $value)
    {
        echo "<b>$key: </b></font><span>$value</span><br>\n";
    }
    */
?>
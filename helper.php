<?php
function version()
{
    return '1.0.0';
}

function sprint()
{
    $date1 = new DateTime('2015-09-02');
    $date2 = new DateTime();
    $interval = $date1->diff($date2);
    $status = array();
    $status['sprint'] = 1 + floor($interval->days / 14);
    $status['day'] = ($interval->days % 14) + 1;

    return $status;
}

function baseUrl()
{
    $url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
    return str_replace("/index.php", "", $url);
}

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>View Subscriptions</title>
</head>
<body>
<a href="viewList.php">View List of Reports</a> -
<a href="newReport.php">Create New Report</a> -
<a href="viewSubscriptions.php">View Subscription List</a> -
<a href="viewLimits.php">View Subscription Limits</a>
<br /><br />
<?php
    require_once('config.php');
    require_once('lib/WSAclient.php');
    require_once('lib/WSAParser.php');
    
    $WSAclient = new WSAclient(WSA_USER_ID,WSA_API_KEY);

    $result=$WSAclient->viewSubscriptions('xml','EN');

    unset($WSAclient);
    
    echo WSAParser::viewSubscriptions($result);
?>
</body>
</html>

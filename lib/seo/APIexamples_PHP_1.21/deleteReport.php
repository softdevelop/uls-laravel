<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Delete Report</title>
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
    
    $reportID=-1;
    if(isset($_GET['reportID']) && is_numeric($_GET['reportID'])) {
        $reportID=$_GET['reportID'];
    }
    else {
        die('Incorrect Report ID');
    }
    
    $WSAclient = new WSAclient(WSA_USER_ID,WSA_API_KEY);

    $result=$WSAclient->deleteReport($reportID,WSA_SUBSCRIPTION_ID,'xml','EN');

    unset($WSAclient);
    
    echo WSAParser::deleteReportResponse($result);
?>
</body>
</html>
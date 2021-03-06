<?php
    require_once('config.php');
    require_once('lib/WSAclient.php');
    require_once('lib/WSAParser.php');
    require_once('lib/WSAParser.php');
    
    $reportID=-1;
    if(isset($_GET['reportID']) && is_numeric($_GET['reportID'])) {
        $reportID=$_GET['reportID'];
    }
    else {
        die('Incorrect Report ID');
    }
    
    $WSAclient = new WSAclient(WSA_USER_ID,WSA_API_KEY);

    $result=$WSAclient->viewReport($reportID,WSA_SUBSCRIPTION_ID,'xml','EN');
    
    unset($WSAclient);
    
    ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PDF Report</title>
    <!--Add your CSS here-->
</head>
<body>    
<?php  
    echo WSAParser::viewReportResponse($result);
?>
</body>
</html>
<?php
    $HTMLoutput = ob_get_contents();
    ob_end_clean();
    

    //Convert HTML 2 PDF by using MPDF PHP library
    require_once('lib/MPDF/mpdf.php');
    $mpdf=new mPDF(); 

    $mpdf->WriteHTML($HTMLoutput);

    $mpdf->Output();

    die();
?>
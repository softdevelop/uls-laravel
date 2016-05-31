<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>View Limits</title>
</head>
<body>
<?php
    $toolID=7;
    if(isset($_GET['toolID']) && is_numeric($_GET['toolID'])){
        $toolID=$_GET['toolID'];
    }
?>
<a href="viewList.php?toolID=<?php echo $toolID;?>">View List of Reports</a> -
<a href="newReport.php?toolID=<?php echo $toolID;?>">Create New Report</a> -
<a href="viewSubscriptions.php">View Subscription List</a> -
<a href="viewLimits.php?toolID=<?php echo $toolID;?>">View Subscription Limits</a>
<br /><br />
<label>Tool:</label>
<select id="toolID" name="toolID" onchange="viewList()">
    <option value="7" <?php if($toolID==7) { echo 'selected="selected"'; } ?>>Keyword Analyzer</option>
    <option value="18" <?php if($toolID==18) { echo 'selected="selected"'; } ?>>Keyword Battle</option>
    <option value="14" <?php if($toolID==14) { echo 'selected="selected"'; } ?>>Site Submitter</option>
    <option value="2" <?php if($toolID==2) { echo 'selected="selected"'; } ?>>Domain Info</option>
    <option value="4" <?php if($toolID==4) { echo 'selected="selected"'; } ?>>Index Pages</option>
    <option value="13" <?php if($toolID==13) { echo 'selected="selected"'; } ?>>Reputation Tracker</option>
    <option value="8" <?php if($toolID==8) { echo 'selected="selected"'; } ?>>Duplicate Content</option>
    <option value="3" <?php if($toolID==3) { echo 'selected="selected"'; } ?>>HTML Validation</option>
    <option value="5" <?php if($toolID==5) { echo 'selected="selected"'; } ?>>Link Popularity</option>
    <option value="6" <?php if($toolID==6) { echo 'selected="selected"'; } ?>>Backlink Analysis</option>
    <option value="12" <?php if($toolID==12) { echo 'selected="selected"'; } ?>>Web SEO Analysis</option>
    <option value="20" <?php if($toolID==20) { echo 'selected="selected"'; } ?>>Link Structure</option>
    <option value="21" <?php if($toolID==21) { echo 'selected="selected"'; } ?>>Backlink Hunter</option>
    <option value="9" <?php if($toolID==9) { echo 'selected="selected"'; } ?>>Domain Battle</option>
    <option value="10" <?php if($toolID==10) { echo 'selected="selected"'; } ?>>SERP Analysis</option>
    <option value="11" <?php if($toolID==11) { echo 'selected="selected"'; } ?>>Blog Analyzer</option>
    <option value="15" <?php if($toolID==15) { echo 'selected="selected"'; } ?>>Keyword Research</option>
    <option value="16" <?php if($toolID==16) { echo 'selected="selected"'; } ?>>Keyword Difficulty</option>
    <option value="23" <?php if($toolID==23) { echo 'selected="selected"'; } ?>>Aged Domain Finder</option>
    <option value="24" <?php if($toolID==24) { echo 'selected="selected"'; } ?>>URL Analyzer</option>
</select>
<script type="text/javascript">
// <![CDATA[
    function viewList() {
        location.href='viewLimits.php?toolID='+document.getElementById('toolID').value;
    }
// ]]>     
</script><br /><br />
<?php
    require_once('config.php');
    require_once('lib/WSAclient.php');
    require_once('lib/WSAParser.php');
    
    $WSAclient = new WSAclient(WSA_USER_ID,WSA_API_KEY);
    
    /*
    $toolID='7';//KEYWORD ANALYZER
    $toolID='18';//KEYWORD BATTLE
    $toolID='14';//SITE SUBMITTER
    $toolID='2';//DOMAIN INFO
    $toolID='4';//INDEXED PAGES
    $toolID='13';//REPUTATION TRACKER
    $toolID='8';//DUPLICATE CONTENT
    $toolID='3';//HTML VALIDATION
    $toolID='5';//LINK POPULARITY
    $toolID='6';//BACKLINK ANALYSIS
    $toolID='12';//WEB SEO ANALYSIS
    $toolID='20';//LINK STRUCTURE
    $toolID='21';//BACKLINK HUNTER
    $toolID='9';//DOMAIN BATTLE
    $toolID='10';//SERP ANALYSIS
    $toolID='11';//BLOG ANALYZER
    $toolID='15';//KEYWORD RESEARCH
    $toolID='16';//KEYWORD DIFFICULTY
    $toolID='23';//AGED DOMAIN FINDER
    $toolID='24';//URL ANALYZER
    */
    
    $result=$WSAclient->viewLimits($toolID,WSA_SUBSCRIPTION_ID,'xml','EN');

    unset($WSAclient);
    
    
    echo WSAParser::viewLimitsResponse($result);
    

?>
</body>
</html>

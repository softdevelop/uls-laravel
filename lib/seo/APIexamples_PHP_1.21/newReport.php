<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>New Report</title>
</head>
<body>
<?php
    require_once('config.php');
    require_once('lib/WSAclient.php');
    require_once('lib/WSAParser.php');
    
    if(!empty($_POST)) {
        $toolID=7;
        if(isset($_POST['toolID']) && is_numeric($_POST['toolID'])){
            $toolID=$_POST['toolID'];
        }
        else {
            die('Incorrect Tool ID');
        }
        
        unset($_POST['toolID']);
        
        $WSAclient = new WSAclient(WSA_USER_ID,WSA_API_KEY);
        
        $toolParamArray=$_POST;
        $result=$WSAclient->newReport($toolID,$toolParamArray,WSA_SUBSCRIPTION_ID,'xml','EN');
        
        unset($WSAclient);
        
        echo WSAParser::viewReportResponse($result);
    }
    else {
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
        <select id="selectToolID" onchange="viewList()">
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
                location.href='newReport.php?toolID='+document.getElementById('selectToolID').value;
            }
        // ]]>     
        </script>
        <form action="newReport.php" method="post">
            <input type="hidden" name="toolID" value="<?php echo $toolID; ?>" />
        <?php
        switch ($toolID) {
            case 3: //HTML VALIDATION
            ?>
            URL List: <textarea cols="30" rows="5" name="urlList" ></textarea><br />
            <?php     
                break;
            case 9: //DOMAIN BATTLE
            ?>
            Domain List: <textarea cols="30" rows="5" name="urlList" ></textarea><br />
            Check All Subdomains: <input type="checkbox" name="checkOtherSubdomain" value="1" checked="checked" /><br />
            <?php     
                break;
            case 24: //URL ANALYZER
            ?>
            URL List: <textarea cols="30" rows="5" name="urlList" ></textarea><br />
            Check All Subdomains: <input type="checkbox" name="checkOtherSubdomain" value="1" checked="checked" /><br />
            <?php     
                break;
            case 14: //SITE SUBMITTER
            ?>
            URL: <input type="text" name="url" value="" /><br />
            Sitemap: <input type="text" name="sitemap" value="" /><br />
            Title: <input type="text" name="title" value="" /><br />
            Description: <input type="text" name="description" value="" /><br />
            Keywords: <input type="text" name="keywords" value="" /><br />
            Fullname: <input type="text" name="name" value="" /><br />
            E-mail: <input type="text" name="mail" value="" /><br />                       
            <?php
                break;
            case 18: //KEYWORD BATTLE
            ?>
            
            Keyword List: <textarea cols="30" rows="5" name="keywordList" ></textarea><br />
            Domain List: <textarea cols="30" rows="5" name="urlList" ></textarea><br />
            <input type="radio" name="searchengineType" value="0" checked="checked" /> Google 
            <input type="radio" name="searchengineType" value="1" /> Bing 
            
            <select name="countryData">
                <option value="en">US</option>
                <option value="fr">France</option>
                <option value="de">Germany</option>
                <option value="el">Greece</option>
                <option value="it">Italy</option>
                <option value="es">Spain</option>
                <!-- For more options check the Search Engine Languages list in the API Documentation -->
            </select><br />
            Check All Subdomains: <input type="checkbox" name="checkOtherSubdomain" value="1" checked="checked" /><br />
            <?php
                break;
            case 10: //SERP ANALYSIS
            ?>
            
            Keyword: <input type="text" name="keyword" value="" /><br />
            <input type="radio" name="searchengineType" value="0" checked="checked" /> Google 
            <input type="radio" name="searchengineType" value="1" /> Bing 
            
            <select name="countryData">
                <option value="en">US</option>
                <option value="fr">France</option>
                <option value="de">Germany</option>
                <option value="el">Greece</option>
                <option value="it">Italy</option>
                <option value="es">Spain</option>
                <!-- For more options check the Search Engine Languages list in the API Documentation -->
            </select><br />
            URL (optional): <input type="text" name="url" value="" /><br />
            <?php
                break;
            case 8: //DUPLICATE CONTENT
            ?>
            URL 1: <input type="text" name="url1" value="" /><br />
            URL 2: <input type="text" name="url2" value="" /><br />
            <?php
                break;
            case 21: //BACKLINK HUNTER
            ?>
            
            Keyword: <input type="text" name="keyword" value="" /><br />
            <select name="type">
                <option value="1">All Websites</option>
                <option value="2">Blogs</option>
                <option value="3">Directories</option>
                <option value="4">Forums</option>
                <option value="5">URL Submission</option>
            </select>
            <?php
                break;
            case 6: //BACKLINK ANALYSIS
            case 2: //DOMAIN INFO
            case 12: //WEB SEO ANALYSIS
            case 20: //LINK STRUCTURE
            case 4: //INDEXED PAGES
            case 11: //BLOG ANALYZER
            case 5: //LINK POPULARITY
            ?>
            URL: <input type="text" name="url" value="" /><br />
            Check All Subdomains: <input type="checkbox" name="checkOtherSubdomain" value="1" checked="checked" /><br />
            <?php
                break;
            case 15: //KEYWORD RESEARCH
            ?>
            Keyword: <input type="text" name="keyword" value="" /><br />
            Find Statistics: <input type="checkbox" name="findStats" value="1" checked="checked" /><br />
            <?php
                break;
            case 16: //KEYWORD DIFFICULTY
            ?>
            URL List: <textarea cols="30" rows="5" name="urlList" ></textarea><br />
            Keyword List: <textarea cols="30" rows="5" name="keywordList" ></textarea><br />
            <input type="radio" name="searchengineType" value="0" checked="checked" /> Google 
            <input type="radio" name="searchengineType" value="1" /> Bing 
            
            <select name="countryData">
                <option value="en">US</option>
                <option value="fr">France</option>
                <option value="de">Germany</option>
                <option value="el">Greece</option>
                <option value="it">Italy</option>
                <option value="es">Spain</option>
                <!-- For more options check the Search Engine Languages list in the API Documentation -->
            </select><br />
            <?php
                break;
            case 23: //AGED DOMAIN FINDER
            ?>
            Keyword List: <textarea cols="30" rows="5" name="keywordList" ></textarea><br />
            Negative Keywords: <input type="text" name="negativeKeywords" value="" />(comma separated)<br />
            TLDs: <input type="text" name="tldList" value="" />(comma separated, leave blank for all)<br />
            No Adult: <input type="checkbox" name="noadult" value="1" checked="checked" /><br />
            No Digits: <input type="checkbox" name="nodigits" value="1" checked="checked" /><br />
            No Dashes: <input type="checkbox" name="nodashes" value="1" checked="checked" /><br />
            Max Price: <input type="text" name="price" value="" />(numeric, leave blank for all)<br />
            <?php
                break;
            case 7: //KEYWORD ANALYZER
            case 13: //REPUTATION TRACKER
            default:
            ?>
            URL: <input type="text" name="url" value="" /><br />
            <?php
        }
        ?>
            <input type="submit" value="submit" />
        </form>
        <?php

    }
?>
</body>
</html>

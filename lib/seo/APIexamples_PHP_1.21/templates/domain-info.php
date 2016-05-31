<h1>Domain Info</h1>


Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

<h2>Domain Section</h2>

Domain: <?php echo (string)$xml->output->domainInfo->domain; ?><br />


<?php
if($xml->attributes()->version>=1.20) {
?>
Domain Score: <?php echo (string)$xml->output->domainInfo->totalRank; ?>/100<br />
Domain Global Ranking: <?php echo (string)$xml->output->domainInfo->totalRankOrder; ?><br />
Domain Global Ranking Delta: <?php echo (string)$xml->output->domainInfo->totalRankDelta; ?><br />
<?php
}
?>


Domain Links: <?php echo (string)$xml->output->domainInfo->domainLinks; ?><br />
Homepage PageRank: <?php echo (string)$xml->output->domainInfo->mainDomainPageRank; ?><br />
<?php
if($xml->attributes()->version>=1.20) {
?>
Domain WebzyRank: <?php echo (string)$xml->output->domainInfo->mainDomainWebzyRank; ?><br />
<?php
}
?>
Server IP: <?php echo (string)$xml->output->domainInfo->serverIP; ?><br />
Country Server: <?php echo (string)$xml->output->domainInfo->countryServer; ?><br />
Creation Date: <?php echo (string)$xml->output->domainInfo->creationDate; ?><br />
Archive Dir: <?php echo $xml->output->domainInfo->archiveDir; ?><br />
DMOZ: <?php 
$dmoz=(string)$xml->output->domainInfo->dmoz;
if($dmoz==1) {
    echo 'Found';
}
else {
    echo 'Not Found';
} 
?><br />
Yahoo Dir: <?php 
$yahoodir=(string)$xml->output->domainInfo->yahooDir; 
if($yahoodir==1) {
    echo 'Found';
}
else {
    echo 'Not Found';
} 
?><br />
WHOIS: <?php echo (string)$xml->output->domainInfo->whois; ?><br />
robots.txt: <?php echo (string)$xml->output->domainInfo->robotsTXT; ?><br />


<?php
if($xml->attributes()->version>=1.20) {
    ?>
Total Pages In Google: <?php echo (string)$xml->output->domainInfo->totalInGoogle; ?><br />
Total Pages In Bing: <?php echo (string)$xml->output->domainInfo->totalInBing; ?><br />

    <?php
}
?>

<?php
if($xml->attributes()->version>=1.01) {
    ?>
    Domain Authority: <?php echo (string)$xml->output->domainInfo->domainAuthority; ?>/100<br />
    Trust: <?php echo (string)$xml->output->domainInfo->trust; ?><br />
    Speed: <?php echo (string)$xml->output->domainInfo->speedsec; ?> seconds<br />
    DMOZ Categories:<br />
    <?php
    if(isset($xml->output->domainInfo->DMOZcategories)) {
        foreach($xml->output->domainInfo->DMOZcategories->category as $category) {
            echo '- '.((string)$category).'<br />';
        }
    }
    ?>
    <br />
    <br />Contact Details:<br />
    Owner Name: <?php echo (string)$xml->output->domainInfo->contactDetails->owner; ?><br />
    Email: <?php echo (string)$xml->output->domainInfo->contactDetails->email; ?><br />
    Telephone: <?php echo (string)$xml->output->domainInfo->contactDetails->phone; ?><br />
    Address: <?php echo (string)$xml->output->domainInfo->contactDetails->address->street . ' ' .(string)$xml->output->domainInfo->contactDetails->address->city . ' ' .(string)$xml->output->domainInfo->contactDetails->address->state . ' ' .(string)$xml->output->domainInfo->contactDetails->address->zip . ' ' .(string)$xml->output->domainInfo->contactDetails->address->country; ?><br />

    <?php
}
?>


<?php
if($xml->attributes()->version>=1.02) {
    if(isset($xml->output->domainInfo->majesticDataDomain)) { //check that the MajesticSEO Data are available
    ?>
<br />
<b>MajesticSEO - Domain's External Backlink Statistics</b><br />
Backlinks (EDU / GOV):    <?php echo (string)$xml->output->domainInfo->majesticDataDomain->ExtBackLinks; ?> (<?php echo (string)$xml->output->domainInfo->majesticDataDomain->ExtBackLinksEDU; ?> / <?php echo (string)$xml->output->domainInfo->majesticDataDomain->ExtBackLinksGOV; ?>)<br />
Domains (EDU / GOV):    <?php echo (string)$xml->output->domainInfo->majesticDataDomain->RefDomains; ?> (<?php echo (string)$xml->output->domainInfo->majesticDataDomain->RefDomainsEDU; ?> / <?php echo (string)$xml->output->domainInfo->majesticDataDomain->RefDomainsGOV; ?>)<br />
IP addresses (Class C subnets):    <?php echo (string)$xml->output->domainInfo->majesticDataDomain->RefIPs; ?> (<?php echo (string)$xml->output->domainInfo->majesticDataDomain->RefSubNets; ?>)<br />
<br />
    <?php
    }
}
?>

<h2>Traffic Section</h2>

AlexaRank: <?php echo (string)$xml->output->trafficInfo->AlexaRank; ?><br />
<?php
if($xml->attributes()->version>=1.01) {
    ?>
Domain Traffic: <?php echo (string)$xml->output->trafficInfo->domainTraffic; ?>/100<br />
    <?php
}
?>
CompeteRank: <?php echo (string)$xml->output->trafficInfo->CompeteRank; ?><br />
Compete Date: <?php echo (string)$xml->output->trafficInfo->CompeteDate; ?><br />
Compete Visitors: <?php echo (string)$xml->output->trafficInfo->CompeteVisitors; ?><br />
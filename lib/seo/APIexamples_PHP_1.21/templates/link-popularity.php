<h1>Link Popularity</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

URL: <?php echo (string)$xml->output->URL; ?><br />

<?php
if($xml->attributes()->version>=1.02) {
    ?>
Domain: <?php echo (string)$xml->output->domain; ?><br />
<?php
}
?>
    
Total Incoming Links: <?php echo (string)$xml->output->totalLinks; ?><br />
<?php
if($xml->attributes()->version>=1.20) {
    ?>
PageRank: <?php echo (string)$xml->output->PageRank; ?><br />
WebzyRank: <?php echo (string)$xml->output->WebzyRank; ?><br />
<?php
}
?>

<table border="1">
    <tr>
        <th>URL</th>
    </tr>
<?php
    foreach($xml->output->URLlist->backlink as $url) {
        ?>
        <tr>
            <td><?php echo (string)$url; ?></td>
        </tr>
        <?php
    }
?>
</table>



<?php
if($xml->attributes()->version>=1.02) {
    if(isset($xml->output->majesticDataDomain)) { //check that the MajesticSEO Data are available
    ?>
<br />
<b>MajesticSEO - Domain's External Backlink Statistics</b><br />
Backlinks (EDU / GOV):    <?php echo (string)$xml->output->majesticDataDomain->ExtBackLinks; ?> (<?php echo (string)$xml->output->majesticDataDomain->ExtBackLinksEDU; ?> / <?php echo (string)$xml->output->majesticDataDomain->ExtBackLinksGOV; ?>)<br />
Domains (EDU / GOV):    <?php echo (string)$xml->output->majesticDataDomain->RefDomains; ?> (<?php echo (string)$xml->output->majesticDataDomain->RefDomainsEDU; ?> / <?php echo (string)$xml->output->majesticDataDomain->RefDomainsGOV; ?>)<br />
IP addresses (Class C subnets):    <?php echo (string)$xml->output->majesticDataDomain->RefIPs; ?> (<?php echo (string)$xml->output->majesticDataDomain->RefSubNets; ?>)<br />
<br />
    <?php
    }
}
?>

<?php
if($xml->attributes()->version>=1.02) {
    if(isset($xml->output->majesticDataURL)) {//check that the MajesticSEO Data are available
    ?>
<br />
<b>MajesticSEO - URL's External Backlink Statistics</b><br />
Backlinks (EDU / GOV):    <?php echo (string)$xml->output->majesticDataURL->ExtBackLinks; ?> (<?php echo (string)$xml->output->majesticDataURL->ExtBackLinksEDU; ?> / <?php echo (string)$xml->output->majesticDataURL->ExtBackLinksGOV; ?>)<br />
Domains (EDU / GOV):    <?php echo (string)$xml->output->majesticDataURL->RefDomains; ?> (<?php echo (string)$xml->output->majesticDataURL->RefDomainsEDU; ?> / <?php echo (string)$xml->output->majesticDataURL->RefDomainsGOV; ?>)<br />
IP addresses (Class C subnets):    <?php echo (string)$xml->output->majesticDataURL->RefIPs; ?> (<?php echo (string)$xml->output->majesticDataURL->RefSubNets; ?>)<br />
<br />
    <?php
    }
}
?>
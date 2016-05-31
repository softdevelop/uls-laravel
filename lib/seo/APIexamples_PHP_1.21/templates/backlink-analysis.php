<h1>Backlink Analysis</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

URL: <?php echo (string)$xml->output->URL; ?><br />

<?php
if($xml->attributes()->version<1.01) {
    ?>
    <br />This feature is available for Reports that were executed with the 1.01 API version (or higher).<br /><br />
    <?php
}
else {
?>

Page Links: <?php echo (string)$xml->output->URLandDomainData->pageLinks; ?><br />
Page PageRank: <?php echo (string)$xml->output->URLandDomainData->PageRank; ?><br />
<?php
if($xml->attributes()->version>=1.20) {
    ?>
Page WebzyRank: <?php echo (string)$xml->output->URLandDomainData->WebzyRank; ?><br />
<?php
}
?>
<br />

Domain: <?php echo (string)$xml->output->domain; ?><br />


Domain Links: <?php echo (string)$xml->output->URLandDomainData->domainLinks; ?><br />
Domain Homepage PageRank: <?php echo (string)$xml->output->URLandDomainData->mainDomainPageRank; ?><br />
<?php
if($xml->attributes()->version>=1.20) {
    ?>
Domain WebzyRank: <?php echo (string)$xml->output->URLandDomainData->mainDomainWebzyRank; ?><br />
<?php
}
?>
Domain Authority: <?php echo (string)$xml->output->URLandDomainData->domainAuthority; ?>/100<br /><br />

<?php
}
?>




Internal Backlinks: <?php echo (string)$xml->output->internalBacklinks; ?><br />
External Backlinks: <?php echo (string)$xml->output->externalBacklinks; ?><br />
Followed Backlinks: <?php echo (string)$xml->output->followedBacklinks; ?><br />
NoFollowed Backlinks: <?php echo (string)$xml->output->nofollowedBacklinks; ?><br />
Text Backlinks: <?php echo (string)$xml->output->textBacklinks; ?><br />
Image Backlinks: <?php echo (string)$xml->output->imageBacklinks; ?><br />
In-Source Backlinks: <?php echo (string)$xml->output->inSourceBacklinks; ?><br />
Other Backlinks: <?php echo (string)$xml->output->otherBacklinks; ?><br />

<?php
if($xml->attributes()->version<1.01) {
    ?>
    <br />This feature is available for Reports that were executed with the 1.01 API version (or higher).<br /><br />
    <?php
}
else {
?>

Backlinks with OBL < 50: <?php echo (string)$xml->output->OBLstats->upto50; ?><br />
Backlinks with OBL 51 - 100: <?php echo (string)$xml->output->OBLstats->from51to100; ?><br />
Backlinks with OBL 101 - 200: <?php echo (string)$xml->output->OBLstats->from101to200; ?><br />
Backlinks with OBL > 201: <?php echo (string)$xml->output->OBLstats->morethan201; ?><br />

<?php
}
?>



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



<br />
Total Incoming Links: <?php echo (string)$xml->output->totalLinks; ?><br />

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

<h2>Anchor Analysis</h2>
<?php
if($xml->attributes()->version<1.01) {
    ?>
    <br />This feature is available for Reports that were executed with the 1.01 API version (or higher).<br /><br />
    <?php
}
else {
?>
<table border="1">
    <tr>
        <th>Anchor</th>
        <th>Number of Backlinks</th>
    </tr>
    <?php
    foreach($xml->output->backlinkTextAnalysis->anchortexts->entry as $entry) {
        ?>
        <tr>
            <td><?php echo (string)$entry->text; ?></td>
            <td><?php echo (string)$entry->count; ?></td>
        </tr>
    <?php
    }
    ?>
</table>
<?php 
}
?>
<h2>Anchor Word Analysis</h2>

<?php
if($xml->attributes()->version<1.01) {
    ?>
    <br />This feature is available for Reports that were executed with the 1.01 API version (or higher).<br /><br />
    <?php
}
else {
?>
<table border="1">
    <tr>
        <th>Anchor Word</th>
        <th>Number of Backlinks</th>
    </tr>
    <?php
    foreach($xml->output->backlinkTextAnalysis->anchorwords->entry as $entry) {
        ?>
        <tr>
            <td><?php echo (string)$entry->text; ?></td>
            <td><?php echo (string)$entry->count; ?></td>
        </tr>
    <?php
    }
    ?>
</table>
<?php
}
?>

<h2>Backlink Analysis List</h2>
<table border="1">
    <tr>
        <th>URL</th>
        <th>OBL</th>
        <th>NoFollow</th>
        <th>Type</th>
        <th>Anchor Text</th>
        <th>Anchor Image</th>
    </tr>
<?php
    foreach($xml->output->backlinkAnalysis->backlinkEntry as $backlinkEntry) {
        ?>
        <tr>
            <td><?php echo (string)$backlinkEntry->URL; ?></td>
            <td><?php echo (string)$backlinkEntry->OBL; ?></td>
            <td><?php 
                $baclinkNoFollow=(string)$backlinkEntry->NoFollow;
                if($baclinkNoFollow==1) {
                    echo 'NoFollowed';
                }
                else {
                    echo 'Followed';
                }
            ?></td>
            <td><?php 
                $backlinkType=(string)$backlinkEntry->Type; 
                if($backlinkType==0) {
                    echo 'text';
                }
                else if($backlinkType==1) {
                    echo 'image';
                }
                else if($backlinkType==2) {
                    echo 'In-Source';
                }
                else {
                    echo 'Other';
                }
            ?></td>
            <td><?php echo (string)$backlinkEntry->AnchorText; ?></td>
            <td><?php 
            if($backlinkType==1) {
                echo (string)$backlinkEntry->AnchorImage;
            }
            else {
                echo '&nbsp;';
            }
             ?></td>
        </tr>
        <?php
    }
?>
</table>
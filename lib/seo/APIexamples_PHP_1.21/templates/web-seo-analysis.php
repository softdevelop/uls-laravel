<h1>Web SEO Analysis</h1>

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
Total Pages In Google: <?php echo (string)$xml->output->domainInfo->totalInGoogle; ?><br />
Total Pages In Bing: <?php echo (string)$xml->output->domainInfo->totalInBing; ?><br />

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

<h2>Page Analysis Section</h2>


URL: <?php echo (string)$xml->output->pageInfo->URL; ?><br />
<?php
if($xml->attributes()->version>=1.01) {
    ?>
WuzzRank: <?php echo (string)$xml->output->pageInfo->reputation->WuzzRank; ?><br />
<?php 
}
?>
Twitter: <?php echo (string)$xml->output->pageInfo->reputation->twitter; ?><br />
Facebook: <?php echo (string)$xml->output->pageInfo->reputation->facebook; ?><br />
Google Blog Search: <?php 
    $googleblogsearch=(string)$xml->output->pageInfo->reputation->googleblogsearch; 
    if($googleblogsearch>=100) {
        echo 'more than '.$googleblogsearch;
    }
    else {
        echo $googleblogsearch;
    }
?><br />
Delicious: <?php echo (string)$xml->output->pageInfo->reputation->delicious; ?><br />
Digg: <?php echo (string)$xml->output->pageInfo->reputation->digg; ?><br />
Stumbleupon: <?php echo (string)$xml->output->pageInfo->reputation->stumbleupon; ?><br />


Indexed Google: <?php 
    $google=(string)$xml->output->pageInfo->indexation->google; 
    if($google=='1') {
        echo 'yes';
    }
    else {
        echo 'no';
    }
?><br />
Indexed Bing: <?php 
    $bing=(string)$xml->output->pageInfo->indexation->bing; 
    if($bing=='1') {
        echo 'yes';
    }
    else {
        echo 'no';
    }
?><br />


HTML Validation: <?php 
    $validity=(string)$xml->output->pageInfo->HTMLvalidation->validity; 
    if($validity=='1') {
        echo 'Valid';
    }
    else {
        echo 'Invalid';
    }
?><br />
HTML Errors: <?php echo (string)$xml->output->pageInfo->HTMLvalidation->errors; ?><br />
HTML Warnings: <?php echo (string)$xml->output->pageInfo->HTMLvalidation->warnings; ?><br />

PageRank: <?php echo (string)$xml->output->pageInfo->PageRank; ?><br />
<?php
if($xml->attributes()->version>=1.20) {
?>
WebzyRank: <?php echo (string)$xml->output->pageInfo->WebzyRank; ?><br />
<?php
}
?>
Total Incoming Links: <?php echo (string)$xml->output->pageInfo->totalLinks; ?><br />

<table border="1">
    <tr>
        <th>URL</th>
    </tr>
<?php
    foreach($xml->output->pageInfo->URLlist->backlink as $url) {
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
    if(isset($xml->output->pageInfo->majesticDataURL)) {//check that the MajesticSEO Data are available
    ?>
<br />
<b>MajesticSEO - URL's External Backlink Statistics</b><br />
Backlinks (EDU / GOV):    <?php echo (string)$xml->output->pageInfo->majesticDataURL->ExtBackLinks; ?> (<?php echo (string)$xml->output->pageInfo->majesticDataURL->ExtBackLinksEDU; ?> / <?php echo (string)$xml->output->pageInfo->majesticDataURL->ExtBackLinksGOV; ?>)<br />
Domains (EDU / GOV):    <?php echo (string)$xml->output->pageInfo->majesticDataURL->RefDomains; ?> (<?php echo (string)$xml->output->pageInfo->majesticDataURL->RefDomainsEDU; ?> / <?php echo (string)$xml->output->pageInfo->majesticDataURL->RefDomainsGOV; ?>)<br />
IP addresses (Class C subnets):    <?php echo (string)$xml->output->pageInfo->majesticDataURL->RefIPs; ?> (<?php echo (string)$xml->output->pageInfo->majesticDataURL->RefSubNets; ?>)<br />
<br />
    <?php
    }
}
?>


<?php
    $status=1;
    foreach($xml->output->pageInfo->pageAnalysis->attributes() as $attrName=>$attrValue) {
        if($attrName=='status') {
            $status=(string)$attrValue;
        }
    }
    
    if($status==1) {
?>

    Blocked by Robots.txt: <?php $blocked= (string)$xml->output->pageInfo->pageAnalysis->robotsTXTblocked;
    if($blocked==1) {
        echo 'Yes';
    }
    else {
        echo 'No';
    }
     ?><br />
    Blocked by META-Robots: <?php $blocked= (string)$xml->output->pageInfo->pageAnalysis->blockedByMETArobots;
    if($blocked==1) {
        echo 'Yes';
    }
    else {
        echo 'No';
    }
     ?><br />
    NoFollowed links with META-Robots: <?php $blocked= (string)$xml->output->pageInfo->pageAnalysis->nofollowLinksWithMETArobots;
    if($blocked==1) {
        echo 'Yes';
    }
    else {
        echo 'No';
    }
     ?><br />
     
    
    
    Canonical URL: <?php echo (string)$xml->output->pageInfo->pageAnalysis->CanonicalURL; ?><br />
    <?php
    
    $canonicalValidity=NULL;
    foreach($xml->output->pageInfo->pageAnalysis->CanonicalURL->attributes() as $attrName=>$attrValue) {
        if($attrName=='validity') {
            $canonicalValidity=(string)$attrValue;
        }
    }
    ?>
    Canonical URL Validity: <?php 
    if($canonicalValidity===NULL) {
        ;
    }
    else if($canonicalValidity=='1') {
        echo 'Valid';
    }
    else {
        echo 'Invalid';
    }
    ?><br />
    
    Language: <?php echo (string)$xml->output->pageInfo->pageAnalysis->language; ?><br />
    Language Confidence: <?php echo (string)$xml->output->pageInfo->pageAnalysis->languageConfidence; ?><br />
    Title Length: <?php echo (string)$xml->output->pageInfo->pageAnalysis->titleLength; ?><br />
    title Relevance: <?php echo (string)$xml->output->pageInfo->pageAnalysis->titleRelevance; ?><br />
    Description Length: <?php echo (string)$xml->output->pageInfo->pageAnalysis->descriptionLength; ?><br />
    Description Relevance: <?php echo (string)$xml->output->pageInfo->pageAnalysis->descriptionRelevance; ?><br />
    Keywords Length: <?php echo (string)$xml->output->pageInfo->pageAnalysis->keywordsLength; ?><br />
    Keywords Relevance: <?php echo (string)$xml->output->pageInfo->pageAnalysis->keywordsRelevance; ?><br />
    Average HTML Headers Relevance: <?php echo (string)$xml->output->pageInfo->pageAnalysis->avgHTMLheadersRelevance; ?><br />
    HTML Title: <?php echo (string)$xml->output->pageInfo->pageAnalysis->HTMLtitle; ?><br />

    <table border="1">
        <tr>
            <th>Metatag name</th>
            <th>Metatag value</th>
        </tr>
    <?php
        foreach($xml->output->pageInfo->pageAnalysis->METAtags->entry as $entry) {
            ?>
            <tr>
                <td><?php echo (string)$entry->metaname; ?></td>
                <td><?php echo (string)$entry->metavalue; ?></td>
            </tr>
            <?php
        }
    ?>
    </table>


    <table border="1">
        <tr>
            <th>Heading</th>
            <th>Num Of Tags</th>
            <th>Heading List</th>
        </tr>
    <?php
        foreach($xml->output->pageInfo->pageAnalysis->HTMLheadings->heading as $heading) {
            ?>
            <tr>
                <td><?php echo (string)$heading->name; ?></td>
                <td><?php echo (string)$heading->numOfTags; ?></td>
                <td>
                    <?php
                        foreach($heading->list->entry as $entry) {
                            echo (string)$entry.'<br />';
                        }
                    ?>
                </td>
            </tr>
            <?php
        }
    ?>
    </table>



    <?php
        $numOfWords=1;
        foreach($xml->output->pageInfo->pageAnalysis->keywordAnalysis->keywordList as $keywordList) {        
            ?>
    <h3><?php echo $numOfWords; ?>-Word Keywords</h3>
    <table border="1">
        <tr>
            <th>Keyword</th>
            <th>Occurrences</th>
            <th>Density</th>
            <th>KeywordRank</th>
            <th>Possible Keyword Stuffing</th>
        </tr>
    <?php
        foreach($keywordList->keyword as $keyword) {
            ?>
            <tr>
                <td><?php echo (string)$keyword->name; ?></td>
                <td><?php echo (string)$keyword->count; ?></td>
                <td><?php echo (string)$keyword->density; ?></td>
                <td><?php echo (string)$keyword->KeywordRank; ?></td>
                <td>
                    <?php
                        $possibleSpam=(string)$keyword->possibleSpam;
                        if($possibleSpam=='1') {
                            echo 'yes';
                        }
                        else {
                            echo '&nbsp;';
                        }
                    ?>
                </td>
            </tr>
            <?php
        }
    ?>
    </table>
    <?php 
        $numOfWords++;
    }
    ?>
<?php
    }
    else {
        echo (string)$xml->output->pageInfo->pageAnalysis->ErrorMessage;
    }
?>


<h2>Link Structure Section</h2>

<?php
if($xml->attributes()->version<1.01) {
    ?>
    <br />This feature is available for Reports that were executed with the 1.01 API version (or higher).<br /><br />
    <?php
}
else {
?>

    <?php 
        if($xml->output->linkstructureInfo->attributes()->status == 1) {
            ?>
                Total BrokenLinks: <?php echo (string)$xml->output->linkstructureInfo->totalBrokenLinks; ?><br />
                Total Valid Links: <?php 
                $temp1=(string)$xml->output->linkstructureInfo->linkstructure->OBLinks;
                $temp2=(string)$xml->output->linkstructureInfo->totalBrokenLinks;
                echo ($temp1 -$temp2); ?><br />

                <table border="1">
                    <tr>
                        <th>Broken Links</th>
                    </tr>
                <?php
                    foreach($xml->output->linkstructureInfo->brokenlinklist->brokenlink as $brokenlink) {
                        ?>
                        <tr>
                            <td><?php echo (string)$brokenlink; ?></td>
                        </tr>
                        <?php
                    }
                ?>
                </table>


                Internal Links: <?php echo (string)$xml->output->linkstructureInfo->linkstructure->InternalLinks; ?><br />
                External Links: <?php echo (string)$xml->output->linkstructureInfo->linkstructure->ExternalLinks; ?><br />
                Internal PR: <?php echo (string)$xml->output->linkstructureInfo->linkstructure->InternalPR; ?><br />
                External PR: <?php echo (string)$xml->output->linkstructureInfo->linkstructure->ExternalPR; ?><br />
                Evaporated PR: <?php echo (string)$xml->output->linkstructureInfo->linkstructure->EvaporatedPR; ?><br />
                Outbound Pages: <?php echo (string)$xml->output->linkstructureInfo->linkstructure->OBPages; ?><br />
                Outbound Links: <?php echo (string)$xml->output->linkstructureInfo->linkstructure->OBLinks; ?><br />
                
                    <?php
                    if($xml->attributes()->version<1.01) {
                        ?>
                        <br />This feature is available for Reports that were executed with the 1.01 API version (or higher).<br /><br />
                        <?php
                    }
                    else {
                    ?>
                    Followed Links: <?php echo (string)$xml->output->linkstructureInfo->linkstructure->FollowedLinks; ?><br />
                    No-Followed Links: <?php echo (string)$xml->output->linkstructureInfo->linkstructure->NofollowedLinks; ?><br />
                    <?php
                    }
                    ?>
                <table border="1">
                    <tr>
                        <th>URL</th>
                        <th>PR flow</th>
                        <th>Anchor List</th>
                    </tr>
                <?php
                    foreach($xml->output->linkstructureInfo->linkstructure->OBLinksList->pageEntry as $pageEntry) {
                        ?>
                        <tr>
                            <td><?php echo (string)$pageEntry->pageURL; ?></td>
                            <td><?php echo (string)$pageEntry->percentageOfPRflow; ?></td>
                            <td>
                                <table border="1">
                                    <tr>
                                        <th>#</th>
                                        <th>NoFollow</th>
                                        <th>Type</th>
                                        <th>AnchorText</th>
                                        <th>AnchorImage</th>
                                    </tr>
                            <?php 
                            $i=0;
                            foreach($pageEntry->anchorList->anchor as $anchor) {
                                    ?>
                                    <tr>
                                        <td><?php echo ++$i; ?></td>
                                        <td><?php 
                                            $anchorNoFollow=(string)$anchor->NoFollow;
                                            if($anchorNoFollow==1) {
                                                echo 'NoFollowed';
                                            }
                                            else {
                                                echo 'Followed';
                                            }
                                        ?></td>
                                        <td><?php 
                                            $anchorType=(string)$anchor->Type; 
                                            if($anchorType==1) {
                                                echo 'image';
                                            }
                                            else {
                                                echo 'text';
                                            }
                                        ?></td>
                                        <td><?php echo (string)$anchor->AnchorText; ?></td>
                                        <td><?php 
                                        if($anchorType==1) {
                                            echo (string)$anchor->AnchorImage;
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
                            </td>
                        </tr>
                        <?php
                    }
                ?>
                </table>
            <?php
        }
        else {            
            echo (string)$xml->output->linkstructureInfo->ErrorMessage;
        }
    ?>


<?php
}
?>
<h2>Diagnostics Section</h2>
<?php
$number=0;
foreach($xml->output->diagnosticsInfo->errorList->attributes() as $attrName=>$attrValue) {
    if($attrName=='number') {
        $number=(string)$attrValue;
    }
}
?>
Errors (<?php echo $number; ?>):<br />
<?php 
    foreach($xml->output->diagnosticsInfo->errorList->entry as $entry) {
        echo (string)$entry.'<br />';
    }
?>
<br />
<?php
$number=0;
foreach($xml->output->diagnosticsInfo->warningList->attributes() as $attrName=>$attrValue) {
    if($attrName=='number') {
        $number=(string)$attrValue;
    }
}
?>
Warnings (<?php echo $number; ?>):<br />
<?php 
    foreach($xml->output->diagnosticsInfo->warningList->entry as $entry) {
        echo (string)$entry.'<br />';
    }
?>
<br />
<?php
$number=0;
foreach($xml->output->diagnosticsInfo->infoList->attributes() as $attrName=>$attrValue) {
    if($attrName=='number') {
        $number=(string)$attrValue;
    }
}
?>
Info (<?php echo $number; ?>):<br />
<?php 
    foreach($xml->output->diagnosticsInfo->infoList->entry as $entry) {
        echo (string)$entry.'<br />';
    }
?>
<br />

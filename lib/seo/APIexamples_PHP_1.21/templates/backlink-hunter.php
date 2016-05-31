<h1>Backlink Hunter</h1>

Report ID: <?php echo (string)$xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo (string)$xml->output->attributes()->toolID; ?><br />
Version: <?php echo (string)$xml->attributes()->version; ?><br /><br />

Keyword: <?php echo (string)$xml->output->keyword; ?><br />
Type: <?php 
if((string)$xml->output->type=='1') {
    echo 'All Websites';
}
else if((string)$xml->output->type=='2') {
    echo 'Blogs';
}
else if((string)$xml->output->type=='3') {
    echo 'Directories';
}
else if((string)$xml->output->type=='4') {
    echo 'Forums';
}
else if((string)$xml->output->type=='5') {
    echo 'URL Submission';
}

?><br />
Total Results Found: <?php echo (string)$xml->output->totalResultsFound; ?><br />
Total Results Analyzed: <?php echo (string)$xml->output->totalResultsAnalyzed; ?><br />
<table border="1">

    <tr>
        <th>#</th>
        <th>Domain Name</th>
        <th>Relevance</th>
        
        <?php
        if($xml->attributes()->version>=1.20) {
        ?>
        <th>Domain Score</th>
        <th>Domain Global Ranking</th>
        <th>Domain Global Ranking Delta</th>
        <?php
        }
        ?>
        <th>Domain Authority</th>
        <th>Domain Traffic</th>
        <th>Homepage PageRank</th>
        
        <?php
        if($xml->attributes()->version>=1.20) {
        ?>
        <th>Domain WebzyRank</th>
        <?php
        }
        ?>
        <th>Domain Links</th>
        <th>AlexaRank</th>
        <th>CompeteRank</th>
        <th>Monthly Visitors</th>
        <th>Estimated Pages</th>
        <th>Creation Date</th>
        <th>trust</th>
        <th>DMOZcategories</th>
        <th>contact info</th>
        <?php
        if($xml->attributes()->version>=1.02) {
            if(isset($xml->output->domainList->domainEntry->majesticDataDomain)) {//check that the MajesticSEO Data are available
            ?>
        <th>MajesticSEO BackLinks ALL</th>
        <th>MajesticSEO BackLinks EDU</th>
        <th>MajesticSEO BackLinks GOV</th>
        <th>MajesticSEO Referring Domains ALL</th>
        <th>MajesticSEO Referring Domains EDU</th>
        <th>MajesticSEO Referring Domains GOV</th>
        <th>MajesticSEO Referring IPs</th>
        <th>MajesticSEO Referring SubNets</th>
            <?php
            }
        }
        ?>
    </tr>
<?php
$i=1;
foreach($xml->output->domainList->domainEntry as $domainEntry) {
    ?>
    <tr>
        <td><?php echo ($i); ?></td>
        <td><?php echo (string)$domainEntry->domainName; ?></td>
        <td><?php echo (string)$domainEntry->relevance; ?></td>
        
        <?php
        if($xml->attributes()->version>=1.20) {
        ?>
        <td><?php echo (string)$domainEntry->totalRank; ?>/100</td>
        <td><?php echo (string)$domainEntry->totalRankOrder; ?></td>
        <td><?php echo (string)$domainEntry->totalRankDelta; ?></td>
        <?php
        }
        ?>
        <td><?php echo (string)$domainEntry->domainAuthority; ?>/100</td>
        <td><?php echo (string)$domainEntry->domainTraffic; ?>/100</td>
        <td><?php echo (string)$domainEntry->PageRank; ?></td>
        <?php
        if($xml->attributes()->version>=1.20) {
        ?>
        <td><?php echo (string)$domainEntry->WebzyRank; ?></td>
        <?php
        }
        ?>
        <td><?php echo (string)$domainEntry->domainLinks; ?></td>
        <td><?php echo (string)$domainEntry->AlexaRank; ?></td>
        <td><?php echo (string)$domainEntry->CompeteRank; ?></td>
        <td><?php echo (string)$domainEntry->CompeteVisitors; ?></td>
        <td><?php echo (string)$domainEntry->estimatedPages; ?></td>
        <td><?php echo (string)$domainEntry->creationDate; ?></td>
        
        <td><?php echo (string)$domainEntry->trust; ?></td>
        <td>
            <?php 
            if(isset($domainEntry->DMOZcategories)) {
                foreach($domainEntry->DMOZcategories->category as $category) {
                    echo ((string)$category).'<br />';
                }
            }
             ?>
        </td>
        <td><?php echo (string)$domainEntry->contactDetails->email; ?><br />
        <?php echo (string)$domainEntry->contactDetails->owner; ?><br />
        <?php echo (string)$domainEntry->contactDetails->phone; ?><br />
        <?php echo (string)$domainEntry->contactDetails->address->street; ?>
        <?php echo (string)$domainEntry->contactDetails->address->city; ?>
        <?php echo (string)$domainEntry->contactDetails->address->state; ?>
        <?php echo (string)$domainEntry->contactDetails->address->zip; ?>
        <?php echo (string)$domainEntry->contactDetails->address->country; ?>
        </td>

        <?php
        if($xml->attributes()->version>=1.02) {
            if(isset($domainEntry->majesticDataDomain)) {//check that the MajesticSEO Data are available
            ?>
        <td><?php echo (string)$domainEntry->majesticDataDomain->ExtBackLinks; ?></td>
        <td><?php echo (string)$domainEntry->majesticDataDomain->ExtBackLinksEDU; ?></td>
        <td><?php echo (string)$domainEntry->majesticDataDomain->ExtBackLinksGOV; ?></td>
        <td><?php echo (string)$domainEntry->majesticDataDomain->RefDomains; ?></td>
        <td><?php echo (string)$domainEntry->majesticDataDomain->RefDomainsEDU; ?></td>
        <td><?php echo (string)$domainEntry->majesticDataDomain->RefDomainsGOV; ?></td>
        <td><?php echo (string)$domainEntry->majesticDataDomain->RefIPs; ?></td>
        <td><?php echo (string)$domainEntry->majesticDataDomain->RefSubNets; ?></td>
            <?php
            }
        }
        ?>
    </tr>
    <?php
    ++$i;
}
?>
</table>
<h1>URL Analyzer</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

<table border="1">
    <tr>
        <th>URL</th>
        <th>Page PageRank</th>
        <th>Page WebzyRank</th>
        <th>Page Links</th>
        <th>Page WuzzRank</th>
        <th>Domain Score</th>
        <th>Domain Global Ranking</th>
        <th>Domain Global Ranking Delta</th>
        <th>Domain Authority</th>
        <th>Domain Traffic</th>
        <th>Homepage PageRank</th>
        <th>Domain WebzyRank</th>
        <th>Domain Links</th>
        <th>Homepage WuzzRank</th>
        <th>AlexaRank</th>
        <th>CompeteRank</th>
        <th>Estimated Visitors</th>
        <th>Indexed Pages in Google</th>
        <th>Indexed Pages in Bing</th>
        <th>Creation Date</th>
        <th>DMOZ indexation</th>
        <th>Speed</th>
        <?php
        
        if(isset($xml->output->list->urlEntry->majesticDataURL)) {//check that the MajesticSEO Data are available
            ?>
        <th>MajesticSEO Page's BackLinks ALL</th>
        <th>MajesticSEO Page's BackLinks EDU</th>
        <th>MajesticSEO Page's BackLinks GOV</th>
        <th>MajesticSEO Page's Referring Domains ALL</th>
        <th>MajesticSEO Page's Referring Domains EDU</th>
        <th>MajesticSEO Page's Referring Domains GOV</th>
        <th>MajesticSEO Page's Referring IPs</th>
        <th>MajesticSEO Page's Referring SubNets</th>
            <?php
        }
        ?>
        <?php
        if(isset($xml->output->list->urlEntry->domainInfo->majesticDataDomain)) {//check that the MajesticSEO Data are available
            ?>
        <th>MajesticSEO Domain's BackLinks ALL</th>
        <th>MajesticSEO Domain's BackLinks EDU</th>
        <th>MajesticSEO Domain's BackLinks GOV</th>
        <th>MajesticSEO Domain's Referring Domains ALL</th>
        <th>MajesticSEO Domain's Referring Domains EDU</th>
        <th>MajesticSEO Domain's Referring Domains GOV</th>
        <th>MajesticSEO Domain's Referring IPs</th>
        <th>MajesticSEO Domain's Referring SubNets</th>
            <?php
        }
        ?>
    </tr>
    <?php 
    foreach($xml->output->list->urlEntry as $resultEntry) {
      ?>
    <tr>
        <td><?php echo (string)$resultEntry->url; ?></td>
        <td><?php echo (string)$resultEntry->PageRank; ?></td>
        <td><?php echo (string)$resultEntry->WebzyRank; ?></td>
        <td><?php echo (string)$resultEntry->pageLinks; ?></td>
        <td><?php echo (string)$resultEntry->WuzzRank; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->totalRank; ?>/100</td>
        <td><?php echo (string)$resultEntry->domainInfo->totalRankOrder; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->totalRankDelta; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->domainAuthority; ?>/100</td>
        <td><?php echo (string)$resultEntry->domainInfo->domainTraffic; ?>/100</td>
        <td><?php echo (string)$resultEntry->domainInfo->PageRank; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->WebzyRank; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->domainLinks; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->WuzzRank; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->AlexaRank; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->CompeteRank; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->CompeteVisitors; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->indexedPagesGoogle; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->indexedPagesBing; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->creationDate; ?></td>
        <td><?php echo ((string)$resultEntry->domainInfo->dmoz==1)?'yes':'no'; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->speedsec; ?> sec</td>

        <?php
        if(isset($resultEntry->majesticDataURL)) {//check that the MajesticSEO Data are available
            ?>
        <td><?php echo (string)$resultEntry->majesticDataURL->ExtBackLinks; ?></td>
        <td><?php echo (string)$resultEntry->majesticDataURL->ExtBackLinksEDU; ?></td>
        <td><?php echo (string)$resultEntry->majesticDataURL->ExtBackLinksGOV; ?></td>
        <td><?php echo (string)$resultEntry->majesticDataURL->RefDomains; ?></td>
        <td><?php echo (string)$resultEntry->majesticDataURL->RefDomainsEDU; ?></td>
        <td><?php echo (string)$resultEntry->majesticDataURL->RefDomainsGOV; ?></td>
        <td><?php echo (string)$resultEntry->majesticDataURL->RefIPs; ?></td>
        <td><?php echo (string)$resultEntry->majesticDataURL->RefSubNets; ?></td>
            <?php
        }
        ?>
        <?php
        if(isset($resultEntry->domainInfo->majesticDataDomain)) {//check that the MajesticSEO Data are available
            ?>
        <td><?php echo (string)$resultEntry->domainInfo->majesticDataDomain->ExtBackLinks; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->majesticDataDomain->ExtBackLinksEDU; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->majesticDataDomain->ExtBackLinksGOV; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->majesticDataDomain->RefDomains; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->majesticDataDomain->RefDomainsEDU; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->majesticDataDomain->RefDomainsGOV; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->majesticDataDomain->RefIPs; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->majesticDataDomain->RefSubNets; ?></td>
            <?php
        }
        ?>
    </tr>
      <?php  
    }
    ?>
</table>
<br /><br />
<b>Results Ordered by Link Strength:</b><br />
<?php
    foreach($xml->output->urlsOrderedByStrength->result as $entry) {
        echo (string)$entry->order . '. '.(string)$entry->URL.'<br />';
    }
?>
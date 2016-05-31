<h1>Domain Battle</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

<table border="1">
    <tr>
        <th>Domain</th>
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
        <th>Homepage WuzzRank</th>
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
        <th>Estimated Visitors</th>
        <th>Indexed Pages in Google</th>
        <th>Indexed Pages in Bing</th>
        <th>Creation Date</th>
        <th>Found in DMOZ</th>
        <th>Speed</th>
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
    foreach($xml->output->domainList->domainEntry as $domainEntry) {
      ?>
    <tr>
        <td><?php echo (string)$domainEntry->domainName; ?></td>
        
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
        <td><?php echo (string)$domainEntry->WuzzRank; ?></td>
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
        <td><?php echo (string)$domainEntry->indexedPagesGoogle; ?></td>
        <td><?php echo (string)$domainEntry->indexedPagesBing; ?></td>
        <td><?php echo (string)$domainEntry->creationDate; ?></td>
        <td><?php echo ((string)$domainEntry->dmoz=='1')?'yes':'no'; ?></td>
        <td><?php echo (string)$domainEntry->speedsec; ?> sec</td>

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
    }
    ?>
</table>
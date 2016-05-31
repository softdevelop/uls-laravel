<h1>SERP Analysis</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

Search Engine: <?php echo (string)$xml->output->searchengine; ?><br />
Keyword: <?php echo (string)$xml->output->keyword; ?><br />

<table border="1">
    <tr>
        <th>Position</th>
        <th>URL</th>
        <th>Language</th>
        <th>Title Optimization</th>
        <th>Page PageRank</th>
        <?php
        if($xml->attributes()->version>=1.20) {
        ?>
        <th>Page WebzyRank</th>
        <?php
        }
        ?>
        <th>Page Links</th>
        <th>Page WuzzRank</th>
        
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
        if($xml->attributes()->version>=1.02) {
            if(isset($xml->output->searchResults->resultEntry->majesticDataURL)) {//check that the MajesticSEO Data are available
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
        }
        ?>
        <?php
        if($xml->attributes()->version>=1.02) {
            if(isset($xml->output->searchResults->resultEntry->domainInfo->majesticDataDomain)) {//check that the MajesticSEO Data are available
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
        }
        ?>
    </tr>
    <?php 
    foreach($xml->output->searchResults->resultEntry as $resultEntry) {
      ?>
    <tr>
        <td><?php echo (string)$resultEntry->attributes()->position; ?></td>
        <td><?php echo (string)$resultEntry->url; ?></td>
        <td><?php echo (string)$resultEntry->language; ?></td>
        <td><?php echo (string)$resultEntry->titleOptimization; ?></td>
        <td><?php echo (string)$resultEntry->PageRank; ?></td>
        <?php
        if($xml->attributes()->version>=1.20) {
        ?>
        <td><?php echo (string)$resultEntry->WebzyRank; ?></td>
        <?php
        }
        ?>
        <td><?php echo (string)$resultEntry->pageLinks; ?></td>
        <td><?php echo (string)$resultEntry->WuzzRank; ?></td>
        
        <?php
        if($xml->attributes()->version>=1.20) {
        ?>
        <td><?php echo (string)$resultEntry->domainInfo->totalRank; ?>/100</td>
        <td><?php echo (string)$resultEntry->domainInfo->totalRankOrder; ?></td>
        <td><?php echo (string)$resultEntry->domainInfo->totalRankDelta; ?></td>
        <?php
        }
        ?>
        <td><?php echo (string)$resultEntry->domainInfo->domainAuthority; ?>/100</td>
        <td><?php echo (string)$resultEntry->domainInfo->domainTraffic; ?>/100</td>
        <td><?php echo (string)$resultEntry->domainInfo->PageRank; ?></td>
        <?php
        if($xml->attributes()->version>=1.20) {
        ?>
        <td><?php echo (string)$resultEntry->domainInfo->WebzyRank; ?></td>
        <?php
        }
        ?>
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
        if($xml->attributes()->version>=1.02) {
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
        }
        ?>
        <?php
        if($xml->attributes()->version>=1.02) {
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
        }
        ?>
    </tr>
      <?php  
    }
    ?>
</table>
<br /><br />

Total Results in SERP: <?php echo (string)$xml->output->totalSERPresults; ?><br />


<?php
if($xml->attributes()->version>=1.10) {
    ?>
    
Search Results: <?php echo (string)$xml->output->totalFoundResults; ?><br />
<?php
}
?>
Average Search Terms in Title: <?php echo (string)$xml->output->avgTermsInTitle; ?><br />
Average Search Terms in Domain: <?php echo (string)$xml->output->avgTermsInDomain; ?><br />
Median Page PageRank: <?php echo (string)$xml->output->medianPagePageRank; ?><br />
Median Homepage PageRank: <?php echo (string)$xml->output->medianDomainPageRank; ?><br />
<?php
if($xml->attributes()->version>=1.20) {
?>
Median Page WebzyRank: <?php echo (string)$xml->output->medianPageWebzyRank; ?><br />
Median Domain WebzyRank: <?php echo (string)$xml->output->medianDomainWebzyRank; ?><br />
<?php
}
?>
Median Page WuzzRank: <?php echo (string)$xml->output->medianPageWuzzRank; ?><br />
Median Homepage WuzzRank: <?php echo (string)$xml->output->medianDomainWuzzRank; ?><br />
<br />
Universal Search Results: 
<?php 
if((string)$xml->output->resultTypes->images=='1') {
    echo 'images, ';
}
if((string)$xml->output->resultTypes->maps=='1') {
    echo 'maps, ';
}
if((string)$xml->output->resultTypes->news=='1') {
    echo 'news, ';
}
if((string)$xml->output->resultTypes->places=='1') {
    echo 'places, ';
}
if((string)$xml->output->resultTypes->products=='1') {
    echo 'products, ';
}
if((string)$xml->output->resultTypes->videos=='1') {
    echo 'videos, ';
}
if((string)$xml->output->resultTypes->webpages=='1') {
    echo 'webpages';
}

?>
<br /><br />
<b>Language Stats:</b><br />
<?php
    foreach($xml->output->rankingStats->languages->entry as $entry) {
        echo (string)$entry->name . ': '.(string)$entry->num.'<br />';
    }
?>
<br /><br />
<b>URL Stats:</b><br />
<?php
    foreach($xml->output->rankingStats->URLtype->entry as $entry) {
        echo (string)$entry->name . ': '.(string)$entry->num.'<br />';
    }
?>
<br /><br />
<b>TLD Stats:</b><br />
<?php
    foreach($xml->output->rankingStats->TLDs->entry as $entry) {
        echo (string)$entry->name . ': '.(string)$entry->num.'<br />';
    }
?>
<br /><br />
<b>DMOZ Stats:</b><br />
<?php
    foreach($xml->output->rankingStats->DMOZ->entry as $entry) {
        echo (string)$entry->name . ': '.(string)$entry->num.'<br />';
    }
?>
<br /><br />
<b>Title Stats:</b><br />
<?php
    foreach($xml->output->rankingStats->titleKeywords->entry as $entry) {
        echo (string)$entry->name . ': '.(string)$entry->num.'<br />';
    }
?>
<br /><br />
<b>Domain Keywords Stats:</b><br />
<?php
    foreach($xml->output->rankingStats->domainKeywords->entry as $entry) {
        echo (string)$entry->name . ' keywords: '.(string)$entry->num.'<br />';
    }
?>
<br /><br />
<b>Results Ordered by Link Strength:</b><br />
<?php
    foreach($xml->output->resultsOrderedByStrength->result as $entry) {
        echo (string)$entry->order . '. '.(string)$entry->URL.'<br />';
    }
?>
<br /><br />
<?php
    if(isset($xml->output->comparePage->URL)) {
        ?>
<h2>Compare your Page</h2>

URL: <?php echo (string)$xml->output->comparePage->URL; ?><br />
Position: <?php echo (string)$xml->output->comparePage->position; ?><br />
Keyword Difficulty vs URL Strength: <?php echo (string)$xml->output->comparePage->kwDifficultyLinkStrength; ?><br />
Title Optimization: <?php echo (string)$xml->output->comparePage->titleOptimization; ?><br />
Text Optimization: <?php echo (string)$xml->output->comparePage->textOptimization; ?><br /><br />

<b>SEO Recommendations:</b><br />
<?php
echo 'IncreasePageLinks: '.(((string)$xml->output->comparePage->SEOrecommendations->IncreasePageLinks=='1')?'True':'False').'<br />';
echo 'IncreaseDomainLinks: '.(((string)$xml->output->comparePage->SEOrecommendations->IncreaseDomainLinks=='1')?'True':'False').'<br />';
echo 'ReformLinkStructure: '.(((string)$xml->output->comparePage->SEOrecommendations->ReformLinkStructure=='1')?'True':'False').'<br />';
echo 'URLkeywords: '.(((string)$xml->output->comparePage->SEOrecommendations->URLkeywords=='1')?'True':'False').'<br />';
echo 'Domainkeywords: '.(((string)$xml->output->comparePage->SEOrecommendations->Domainkeywords=='1')?'True':'False').'<br />';
echo 'DomainAvgNumKeywords: '.(((string)$xml->output->comparePage->SEOrecommendations->DomainAvgNumKeywords=='1')?'True':'False').'<br />';
echo 'Titlekeywords: '.(((string)$xml->output->comparePage->SEOrecommendations->Titlekeywords=='1')?'True':'False').'<br />';
echo 'TitleAvgNumKeywords: '.(((string)$xml->output->comparePage->SEOrecommendations->TitleAvgNumKeywords=='1')?'True':'False').'<br />';
echo 'Onpagekeywords: '.(((string)$xml->output->comparePage->SEOrecommendations->Onpagekeywords=='1')?'True':'False').'<br />';
echo 'GEOTargeting: '.(((string)$xml->output->comparePage->SEOrecommendations->GEOTargeting=='1')?'True':'False').'<br />';
echo 'TLDMatching: '.(((string)$xml->output->comparePage->SEOrecommendations->TLDMatching=='1')?'True':'False').'<br />';
echo 'LanguageTargeting: '.(((string)$xml->output->comparePage->SEOrecommendations->LanguageTargeting=='1')?'True':'False').'<br />';
echo 'UniversalSearchTargeting: '.(((string)$xml->output->comparePage->SEOrecommendations->UniversalSearchTargeting=='1')?'True':'False').'<br />';
echo 'PlacesMapsTargeting: '.(((string)$xml->output->comparePage->SEOrecommendations->PlacesMapsTargeting=='1')?'True':'False').'<br />';
echo 'IncreasePageWuzzRank: '.(((string)$xml->output->comparePage->SEOrecommendations->IncreasePageWuzzRank=='1')?'True':'False').'<br />';
echo 'IncreaseDomainWuzzRank: '.(((string)$xml->output->comparePage->SEOrecommendations->IncreaseDomainWuzzRank=='1')?'True':'False').'<br />';
if($xml->attributes()->version>=1.20) {
    echo 'AddFreshContent: '.(((string)$xml->output->comparePage->SEOrecommendations->AddFreshContent=='1')?'True':'False').'<br />';
}   
?>

        <?php
    }
?>
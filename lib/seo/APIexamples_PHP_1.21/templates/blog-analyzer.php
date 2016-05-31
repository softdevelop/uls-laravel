<h1>Blog Analyzer</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

<h1>Domain Section</h1>

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

DMOZ: <?php 
$dmoz=(string)$xml->output->domainInfo->dmoz;
if($dmoz==1) {
    echo 'Found';
}
else {
    echo 'Not Found';
} 
?><br />
Creation Date: <?php echo (string)$xml->output->domainInfo->creationDate; ?><br />
AlexaRank: <?php echo (string)$xml->output->domainInfo->AlexaRank; ?><br />
CompeteRank: <?php echo (string)$xml->output->domainInfo->CompeteRank; ?><br />
Compete Visitors: <?php echo (string)$xml->output->domainInfo->CompeteVisitors; ?><br />
Trust: <?php echo (string)$xml->output->domainInfo->trust; ?><br />
Domain PageRank: <?php echo (string)$xml->output->domainInfo->PageRank; ?><br />
<?php
if($xml->attributes()->version>=1.20) {
?>
Domain WebzyRank: <?php echo (string)$xml->output->domainInfo->WebzyRank; ?><br />
<?php
}
?>
Domain Links: <?php echo (string)$xml->output->domainInfo->domainLinks; ?><br />
Domain Authority: <?php echo (string)$xml->output->domainInfo->domainAuthority; ?>/100<br />
Domain Traffic: <?php echo (string)$xml->output->domainInfo->domainTraffic; ?>/100<br />
Domain Indexed Pages Google: <?php echo (string)$xml->output->domainInfo->indexedPagesGoogle; ?><br />
Domain Indexed Pages Bing: <?php echo (string)$xml->output->domainInfo->indexedPagesBing; ?><br />
Speed: <?php echo (string)$xml->output->domainInfo->speedsec; ?> seconds<br />


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

<h1>Homepage Blog Section</h1>
<?php
    if($xml->output->blogInfo->attributes()->status == 1) {
        ?>
Blog Home URL: <?php echo (string)$xml->output->blogInfo->blogHomeURL; ?><br />
Title: <?php echo (string)$xml->output->blogInfo->blogHomeTitle; ?><br />
Description: <?php echo (string)$xml->output->blogInfo->blogHomeDescription; ?><br />
PageRank: <?php echo (string)$xml->output->blogInfo->PageRank; ?><br />
<?php
if($xml->attributes()->version>=1.20) {
?>
WebzyRank: <?php echo (string)$xml->output->blogInfo->WebzyRank; ?><br />
<?php
}
?>
Blog Total Links: <?php echo (string)$xml->output->blogInfo->totalLinks; ?><br />
Blog Indexed Pages Google: <?php echo (string)$xml->output->blogInfo->blogIndexedPagesGoogle; ?><br />
Blog Indexed Pages Bing: <?php echo (string)$xml->output->blogInfo->blogIndexedPagesBing; ?><br />

<br />
<?php
  if(!isset($xml->output->blogInfo->technorati->authority))  {
      echo 'No Technorati Info Found<br />';
  }
  else {
      ?>
Technorati Authority: <?php echo (string)$xml->output->blogInfo->technorati->authority; ?><br />
Technorati Rank: <?php echo (string)$xml->output->blogInfo->technorati->rank; ?><br />

<table border="1">
    <tr>
        <th>Category</th>
        <th>Authority</th>
        <th>Rank</th>
    </tr>
<?php
if(isset($xml->output->blogInfo->technorati->blogAuthoritiesInfo->categoryEntry)) {
    foreach($xml->output->blogInfo->technorati->blogAuthoritiesInfo->categoryEntry as $tech) {
        ?>
        <tr>
            <td><?php echo (string)$tech->name;; ?></td>
            <td><?php echo (string)$tech->authority; ?></td>
            <td><?php echo (string)$tech->rank; ?></td>
        </tr>
        <?php
    }   
}
?>
</table>
      <?php
  }
?>

Feed URL: <?php echo (string)$xml->output->blogInfo->feedURL; ?><br />
Feed Type: <?php echo (string)$xml->output->blogInfo->feedType; ?><br />


Recent Articles:
<table border="1">
    <tr>
        <th>Article</th>
        <th>Author</th>
        <th>Date</th>
    </tr>
<?php
foreach($xml->output->blogInfo->recentPosts->entry as $post) {
    ?>
    <tr>
        <td><a href="<?php echo (string)$post->link; ?>" target="_blank"><?php echo (string)$post->title; ?></a></td>
        <td><?php echo (string)$post->author; ?></td>
        <td><?php echo (string)$post->pubDate; ?></td>
    </tr>
    <?php
}
?>
</table>


        <?php
    }
    else {
        echo (string)$xml->output->blogInfo->ErrorCode .': '.(string)$xml->output->blogInfo->ErrorMessage.'<br />';
    }
?>



<h1>Page Analysis</h1>


URL: <?php echo (string)$xml->output->pageInfo->URL; ?><br />
WuzzRank: <?php echo (string)$xml->output->pageInfo->reputation->WuzzRank; ?><br />
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



<?php
    $status=1;
    foreach($xml->output->pageInfo->pageAnalysis->attributes() as $attrName=>$attrValue) {
        if($attrName=='status') {
            $status=(string)$attrValue;
        }
    }
    
    if($status==1) {
?>



    URL length: <?php echo (string)$xml->output->pageInfo->pageAnalysis->blogPostAnalysis->urlLength; ?><br />
    Permalink: <?php echo ((string)$xml->output->pageInfo->pageAnalysis->blogPostAnalysis->seoFriendlyURL=='1')?'yes':'no'; ?><br />
    Total Images: <?php echo (string)$xml->output->pageInfo->pageAnalysis->blogPostAnalysis->numOfImages; ?><br />
    Images without Alt: <?php echo (string)$xml->output->pageInfo->pageAnalysis->blogPostAnalysis->numOfImagesWithoutAlt; ?><br /><br />


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

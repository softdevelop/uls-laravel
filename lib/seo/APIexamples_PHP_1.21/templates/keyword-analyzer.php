<h1>Keyword Analyzer</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

URL: <?php echo (string)$xml->output->pageInfo->URL; ?><br />
Blocked by Robots.txt: <?php $blocked= (string)$xml->output->pageInfo->pageAnalysis->robotsTXTblocked;
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
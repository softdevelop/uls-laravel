<h1>Keyword Research</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

Keyword: <?php echo (string)$xml->output->keyword; ?><br />
Calculate Keyword Statistics: <?php 
$calcStats=(string)$xml->output->findStats;
if($calcStats) {
    echo 'Yes';
}
else {
    echo 'No';
} ?><br />
Total Keywords Found: <?php echo (string)$xml->output->totalKeywordsFound; ?><br />


<table border="1">
    <tr>
        <th>Keyword</th>
        <th>Relevance</th>
        <?php
        if($calcStats) {
            ?>
        <th>Query Popularity</th>
        <th>Search Results</th>
            <?php
        }
        ?>
    </tr>
    <?php 
    foreach($xml->output->keywordRearchList->keywordEntry as $keywordEntry) {
      ?>
    <tr>
        <td><?php echo (string)$keywordEntry->keyword; ?></td>
        <td><?php echo (string)$keywordEntry->relevance; ?></td>
        <?php
        if($calcStats) {
            ?>
        <td><?php $popularity=(string)$keywordEntry->queryPopularity; 
        if($popularity==='') {
            $popularity='N/A';
        }
        echo $popularity;
        ?></td>
        <td><?php $searchResults=(string)$keywordEntry->searchResults; 
        if($searchResults==='') {
            $searchResults='N/A';
        }
        echo $searchResults;
        ?></td>
            <?php
        }
        ?>        
    </tr>
      <?php  
    }
    ?>
</table>
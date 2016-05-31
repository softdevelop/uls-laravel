<h1>Keyword Difficulty</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

Search Engine: <?php echo (string)$xml->output->searchengine; ?><br />
<br />
<b>Statistics:</b><br />
Low Difficulty: <?php
if(isset($xml->output->difficultyStats->lowDifficulty)) {
    echo $xml->output->difficultyStats->lowDifficulty;
}
else {
    echo '0%';
}
?><br />
Medium Difficulty: <?php
if(isset($xml->output->difficultyStats->mediumDifficulty)) {
    echo $xml->output->difficultyStats->mediumDifficulty;
}
else {
    echo '0%';
}
?><br />
High Difficulty: <?php
if(isset($xml->output->difficultyStats->highDifficulty)) {
    echo $xml->output->difficultyStats->highDifficulty;
}
else {
    echo '0%';
}
?><br />


<table border="1">
    <tr>
        <th>Keyword</th>
        <th>Difficulty</th>
        <th>Search Results</th>
        <th>Current Possition</th>
        <th>URL</th>
    </tr>
    <?php 
    foreach($xml->output->keywordDifficultyList->keywordDifficultyEntry as $keywordEntry) {
      ?>
    <tr>
        <td><?php echo (string)$keywordEntry->keyword; ?></td>
        <td><?php echo (string)$keywordEntry->difficulty; ?></td>
        <td><?php echo (string)$keywordEntry->totalFoundResults; ?></td>
        <td><?php echo (string)$keywordEntry->position; ?></td>
        <td><?php echo (string)$keywordEntry->URL; ?></td>
    </tr>
      <?php  
    }
    ?>
</table>

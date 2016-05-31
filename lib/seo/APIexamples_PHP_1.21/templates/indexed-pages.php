<h1>Indexed Pages</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

Domain: <?php echo (string)$xml->output->domain; ?><br />
Total Pages In Google: <?php echo (string)$xml->output->totalInGoogle; ?><br />
Total Pages In Bing: <?php echo (string)$xml->output->totalInBing; ?><br />

<table border="1">
    <tr>
        <th>URL</th>
        <th>Google</th>
        <th>Bing</th>
    </tr>
<?php
    foreach($xml->output->list->entry as $entry) {
        ?>
        <tr>
            <td><?php echo (string)$entry->URL; ?></td>
            <td><?php 
                $validity=(string)$entry->google; 
                if($validity=='1') {
                    echo 'yes';
                }
                else {
                    echo 'no';
                }
            ?></td>
            <td><?php 
                $validity=(string)$entry->bing; 
                if($validity=='1') {
                    echo 'yes';
                }
                else {
                    echo 'no';
                }
            ?></td>
        </tr>
        <?php
    }
?>
</table>
<h1>HTML Validator</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

<table border="1">
    <tr>
        <th>URL</th>
        <th>Validity</th>
        <th>Errors</th>
        <th>Warnings</th>
    </tr>
<?php
    foreach($xml->output->list->entry as $entry) {
        ?>
        <tr>
            <td><?php echo (string)$entry->URL; ?></td>
            <td><?php 
                $validity=(string)$entry->validity; 
                if($validity=='1') {
                    echo 'Valid';
                }
                else {
                    echo 'Invalid';
                }
            ?></td>
            <td><?php echo (string)$entry->errors; ?></td>
            <td><?php echo (string)$entry->warnings; ?></td>
        </tr>
        <?php
    }
?>
</table>
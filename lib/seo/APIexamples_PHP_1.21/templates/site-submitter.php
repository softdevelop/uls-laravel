<h1>Site Submitter</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

URL: <?php echo (string)$xml->output->URL; ?><br />
Title: <?php echo (string)$xml->output->title; ?><br />
Keywords: <?php echo (string)$xml->output->keywords; ?><br />
Description: <?php echo (string)$xml->output->description; ?><br />
Sitemap: <?php echo (string)$xml->output->sitemap; ?><br />
Owner Name: <?php echo (string)$xml->output->name; ?><br />
Email: <?php echo (string)$xml->output->email; ?><br />
Total Submissions: <?php echo (string)$xml->output->totalSubmissions; ?><br />
Successful Submissions: <?php echo (string)$xml->output->successfulSubmissions; ?><br />

<table border="1">
    <tr>
        <th>Search Engine / Directory</th>
        <th>Results</th>
    </tr>
<?php
    foreach($xml->output->list->entry as $entry) {
        ?>
        <tr>
            <td><?php echo (string)$entry->site; ?></td>
            <td><?php 
                $outcome=(string)$entry->outcome; 
                if($outcome=='1') {
                    echo 'success';
                }
                else {
                    echo 'fail';
                }
            ?></td>
        </tr>
        <?php
    }
?>
</table>
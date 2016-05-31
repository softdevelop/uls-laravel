<h1>Duplicate Content</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

URL1: <?php echo (string)$xml->output->URL1; ?><br />
URL2: <?php echo (string)$xml->output->URL2; ?><br />
Similarity: <?php echo (string)$xml->output->duplicate; ?><br />
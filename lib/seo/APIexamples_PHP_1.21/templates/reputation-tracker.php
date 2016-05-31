<h1>Reputation Tracker</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

URL: <?php echo (string)$xml->output->URL; ?><br />
<?php
if($xml->attributes()->version>=1.01) {
    ?>
WuzzRank: <?php echo (string)$xml->output->reputation->WuzzRank; ?><br />
<?php 
}
?>
Twitter: <?php echo (string)$xml->output->reputation->twitter; ?><br />
Facebook: <?php echo (string)$xml->output->reputation->facebook; ?><br />
Google Blog Search: <?php 
    $googleblogsearch=(string)$xml->output->reputation->googleblogsearch; 
    if($googleblogsearch>=100) {
        echo 'more than '.$googleblogsearch;
    }
    else {
        echo $googleblogsearch;
    }
?><br />
Delicious: <?php echo (string)$xml->output->reputation->delicious; ?><br />
Digg: <?php echo (string)$xml->output->reputation->digg; ?><br />
Stumbleupon: <?php echo (string)$xml->output->reputation->stumbleupon; ?><br />
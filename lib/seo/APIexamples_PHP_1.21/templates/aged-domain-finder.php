<h1>Aged Domain Finder</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

Total matched Domains: <?php echo (string)$xml->output->totalResults; ?><br />
Total returned Domains: <?php echo (string)$xml->output->totalFoundResults; ?><br />

Keywords: <?php 
$tmp=array();
foreach($xml->output->requestedKeywordList->keyword as $keywordEntry) {
    $tmp[]=(string)$keywordEntry;
}

echo implode(', ',$tmp); ?><br />
Excluded Terms: <?php 
$tmp=(string)$xml->output->negativeTerms; 
if($tmp==''){
    echo 'No limitation';
}
else {
    echo $tmp;
}
?><br />
TLDs: <?php 
$tmp=(string)$xml->output->TLDlimitation; 
if($tmp==''){
    echo 'No limitation';
}
else {
    echo $tmp;
}
?><br />
No Adult: <?php 
$tmp=(string)$xml->output->noadult; 
if($tmp){
    echo 'Yes';
}
else {
    echo 'No';
}
?><br />
No Digits: <?php 
$tmp=(string)$xml->output->nodigits; 
if($tmp){
    echo 'Yes';
}
else {
    echo 'No';
}
?><br />
No Dashes: <?php 
$tmp=(string)$xml->output->nodashes; 
if($tmp){
    echo 'Yes';
}
else {
    echo 'No';
}
?><br />
Max Price: <?php 
$tmp=(string)$xml->output->maxPriceLimitation; 
if($tmp==''){
    echo 'No limitation';
}
else {
    echo $tmp;
}
?><br /><br />


<b>Sale Types Statistics:</b>
<?php 
foreach($xml->output->salesTypeStats->salesType as $salesType) {
    echo ((string)$salesType->name).': '.((string)$salesType->percentage).'<br />';
}

?><br />


<table border="1">
    <tr>
        <th>Domain Name</th>
        <th>Length</th>
        <th>Price</th>
        <th>Currency</th>
        <th>Sales Category</th>
        <th>Type of Sale</th>
        <th>Available Until</th>
    </tr>
    <?php 
    foreach($xml->output->domainList->domainEntry as $domainEntry) {
      ?>
    <tr>
        <td><?php echo (string)$domainEntry->domain; ?></td>
        <td><?php echo (string)$domainEntry->domainLength; ?></td>
        <td><?php echo (string)$domainEntry->price; ?></td>
        <td><?php echo (string)$domainEntry->currency; ?></td>
        <td><?php echo (string)$domainEntry->salesCategory; ?></td>
        <td><?php echo (string)$domainEntry->salesType; ?></td>
        <td><?php echo (string)$domainEntry->expires; ?></td>
    </tr>
      <?php  
    }
    ?>
</table>


<h1>Keyword Battle</h1>

Report ID: <?php echo $xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo $xml->output->attributes()->toolID; ?><br />
Version: <?php echo $xml->attributes()->version; ?><br /><br />

Search Engine: <?php echo (string)$xml->output->searchengine; ?><br />
Check Other Subdomains: <?php 
$checkOtherSubdomain= (string)$xml->output->checkOtherSubdomain; 
if($checkOtherSubdomain=='1') {
    echo 'Yes';
}
else {
    echo 'No';
}?><br />

<table border="1">
    <tr>
        <th>#</th>
        <th>URL</th>
    </tr>
<?php
    $i=1;
    foreach($xml->output->winners->domain as $domain) {
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo (string)$domain; ?></td>
        </tr>
        <?php
        ++$i;
    }
?>
</table>

<?php
    $showResults=false;
    if($xml->attributes()->version>=1.10) {
        $showResults=true;
    }
    else if(stripos($xml->output->searchengine,'google')!==false) {
        $showResults=true;
    }
?>

<table border="1">
    <tr>
        <th>Keyword</th>
        <th>Round Winner</th>
        <th>Round Winner Position</th>
        <?php
        if($showResults) {
        ?>
        <th>FoundResults</th>
        <?php
        }
        ?>
        <th>SE Results</th>
    </tr>
<?php
    foreach($xml->output->searchResults->query as $query) {
        ?>
        <tr>
            <td><?php echo $query->keyword; ?></td>
            <td><?php echo (string)$query->roundWinner; ?></td>
            <td><?php echo (string)$query->roundWinnerPosition; ?></td>
            <?php
            if($showResults) {
            ?>
            <td><?php echo (string)$query->foundResults; ?></td>
            <?php
            }
            ?>
            <td>
                <table border="1">
                    <tr>
                        <th>Domain Name</th>
                        <th>Page Results</th>
                    </tr>
            <?php 
            $i=0;
            foreach($query->SEresults->domainResults as $domainResults) {
                    $domainName=0;
                    foreach($domainResults->attributes() as $attrName=>$attrValue) {
                        if($attrName=='name') {
                            $domainName=(string)$attrValue;
                        }
                    }
                    ?>
                    <tr>
                        <td><?php echo $domainName; ?></td>
                        <td><?php 
                            foreach($domainResults->page as $page) {
                                echo (string)$page->position . ': '.(string)$page->URL.'<br />';
                            }
                        ?></td>
                    </tr>
                    <?php
            }
            ?>
                </table>
            </td>
        </tr>
        <?php
    }
?>
</table>
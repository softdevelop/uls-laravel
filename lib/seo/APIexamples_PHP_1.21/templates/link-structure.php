<h1>Link Structure</h1>

Report ID: <?php echo (string)$xml->output->attributes()->reportID; ?><br />
Tool ID: <?php echo (string)$xml->output->attributes()->toolID; ?><br />
Version: <?php echo (string)$xml->attributes()->version; ?><br /><br />

URL: <?php echo (string)$xml->output->URL; ?><br />
Domain: <?php echo (string)$xml->output->domain; ?><br />
Total BrokenLinks: <?php echo (string)$xml->output->totalBrokenLinks; ?><br />
Total Valid Links: <?php 
$temp1=(string)$xml->output->linkstructure->OBLinks;
$temp2=(string)$xml->output->totalBrokenLinks;
echo ($temp1 -$temp2); ?><br />

<table border="1">
    <tr>
        <th>Broken Links</th>
    </tr>
<?php
    foreach($xml->output->brokenlinklist->brokenlink as $brokenlink) {
        ?>
        <tr>
            <td><?php echo (string)$brokenlink; ?></td>
        </tr>
        <?php
    }
?>
</table>


Internal Links: <?php echo (string)$xml->output->linkstructure->InternalLinks; ?><br />
External Links: <?php echo (string)$xml->output->linkstructure->ExternalLinks; ?><br />
Internal PR: <?php echo (string)$xml->output->linkstructure->InternalPR; ?><br />
External PR: <?php echo (string)$xml->output->linkstructure->ExternalPR; ?><br />
Evaporated PR: <?php echo (string)$xml->output->linkstructure->EvaporatedPR; ?><br />
Outbound Pages: <?php echo (string)$xml->output->linkstructure->OBPages; ?><br />
Outbound Links: <?php echo (string)$xml->output->linkstructure->OBLinks; ?><br />

<?php
if($xml->attributes()->version<1.01) {
    ?>
    <br />This feature is available for Reports that were executed with the 1.01 API version (or higher).<br /><br />
    <?php
}
else {
?>
Followed Links: <?php echo (string)$xml->output->linkstructure->FollowedLinks; ?><br />
No-Followed Links: <?php echo (string)$xml->output->linkstructure->NofollowedLinks; ?><br />
<?php
}
?>
<table border="1">
    <tr>
        <th>URL</th>
        <th>PR flow</th>
        <th>Anchor List</th>
    </tr>
<?php
    foreach($xml->output->linkstructure->OBLinksList->pageEntry as $pageEntry) {
        ?>
        <tr>
            <td><?php echo (string)$pageEntry->pageURL; ?></td>
            <td><?php echo (string)$pageEntry->percentageOfPRflow; ?></td>
            <td>
                <table border="1">
                    <tr>
                        <th>#</th>
                        <th>NoFollow</th>
                        <th>Type</th>
                        <th>AnchorText</th>
                        <th>AnchorImage</th>
                    </tr>
            <?php 
            $i=0;
            foreach($pageEntry->anchorList->anchor as $anchor) {
                    ?>
                    <tr>
                        <td><?php echo ++$i; ?></td>
                        <td><?php 
                            $anchorNoFollow=(string)$anchor->NoFollow;
                            if($anchorNoFollow==1) {
                                echo 'NoFollowed';
                            }
                            else {
                                echo 'Followed';
                            }
                        ?></td>
                        <td><?php 
                            $anchorType=(string)$anchor->Type; 
                            if($anchorType==1) {
                                echo 'image';
                            }
                            else {
                                echo 'text';
                            }
                        ?></td>
                        <td><?php echo (string)$anchor->AnchorText; ?></td>
                        <td><?php 
                        if($anchorType==1) {
                            echo (string)$anchor->AnchorImage;
                        }
                        else {
                            echo '&nbsp;';
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
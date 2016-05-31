<?php
function getVersionImage()
{
    return 2;
}

function getVersionScript()
{
    return 8;
}
function getVersionCss()
{
    return 29;
}

function isProduction()
{
    // return true;
    return env('APP_ENV', 'local') == 'production' ? true : false;
}

function isDev()
{
    return env('APP_ENV', 'local') == 'development' ? true : false;
}

function isDebug()
{
    return env('APP_DEBUG', false) == true ? 1 : 0;
}
function getUrlProductionVersion()
{
    return env('url_production_version', 'http://ulsinc.com');
}

function getUrlDemoVersion()
{
    return env('url_demo_version', 'http://demo.ulsinc.com');
}
function enableDebugbar()
{
    return env('enable_debugbar', false) == true ? 1 : 0;
}

function isTesting()
{
    return env('is_testing', false);
}
function getDomain()
{
    $domain = substr(\Request::root(), 7);
    return $domain;
}

function getBaseUrlS3()
{
    return env('baseUrlS3', 'http://cdn.ulsinc.com/');
    // return 'http://cdn.ulsinc.com/';
}
function getUri($uri)
{
    $uri = \URL::to($uri);
    session(['uri' => $uri]);
}
/**
 * The main function for converting to an XML document.
 * Pass in a multi dimensional array and this recrusively loops through and builds up an XML document.
 *
 * @param array $data
 * @param string $rootNodeName - what you want the root node to be - defaultsto data.
 * @param SimpleXMLElement $xml - should only be used recursively
 * @return string XML
 */
function toXML($data, $rootNodeName = 'ResultSet', &$xml = null)
{

    // turn off compatibility mode as simple xml throws a wobbly if you don't.
    if (ini_get('zend.ze1_compatibility_mode') == 1) {
        ini_set('zend.ze1_compatibility_mode', 0);
    }

    if (is_null($xml)) {
        $xml = simplexml_load_string("");
    }

    // loop through the data passed in.
    foreach ($data as $key => $value) {

        // no numeric keys in our xml please!
        if (is_numeric($key)) {
            $numeric = 1;
            $key = $rootNodeName;
        }

        // delete any char not allowed in XML element names
        $key = preg_replace('/[^a-z0-9\-\_\.\:]/i', '', $key);

        // if there is another array found recrusively call this function
        if (is_array($value)) {
            $node = is_assoc($value) || $numeric ? $xml->addChild($key) : $xml;

            // recrusive call.
            if ($numeric) {
                $key = 'anon';
            }

            toXml($value, $key, $node);
        } else {

            // add single node.
            $value = htmlentities($value);
            $xml->addChild($key, $value);
        }
    }

    // pass back as XML
    return $xml->asXML();

    // if you want the XML to be formatted, use the below instead to return the XML
    //$doc = new DOMDocument('1.0');
    //$doc->preserveWhiteSpace = false;
    //$doc->loadXML( $xml->asXML() );
    //$doc->formatOutput = true;
    //return $doc->saveXML();
}
/**
 * Convert file to kb
 * @author [vanlinh] <[<vanlinh@httsolution.com>]>
 * @param
 * @return file size
 */
function parse_size($size)
{
    $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
    $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.

    if ($unit) {
        // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
        return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
    } else {
        return round($size);
    }
}
/**
 * upload max file size
 * @author [vanlinh] <[<vanlinh@httsolution.com>]>
 * @param
 * @return file size
 */
function uploadMaxFile()
{
    $maxUpload = ['name' => ini_get('upload_max_filesize'), 'size' => parse_size(ini_get('upload_max_filesize'))];
    return $maxUpload;
}
/**
 * Convert an XML document to a multi dimensional array
 * Pass in an XML document (or SimpleXMLElement object) and this recrusively loops through and builds a representative array
 *
 * @param string $xml - XML document - can optionally be a SimpleXMLElement object
 * @return array ARRAY
 */
function toArray($xml)
{
    if (is_string($xml)) {
        $xml = new SimpleXMLElement($xml);
    }

    $children = $xml->children();
    if (!$children) {
        return (string) $xml;
    }

    $arr = array();
    foreach ($children as $key => $node) {
        $node = toArray($node);

        // support for 'anon' non-associative arrays
        if ($key == 'anon') {
            $key = count($arr);
        }

        // if the node is already set, put it into an array
        if (isset($arr[$key])) {
            // if ( !is_array( $arr[$key] ) || $arr[$key][0] == null ) $arr[$key] = array( $arr[$key] );
            if (!is_array($arr[$key])) {
                $arr[$key] = array($arr[$key]);
            }

            $arr[$key][] = $node;
        } else {
            $arr[$key] = $node;
        }
    }
    return $arr;
}

// determine if a variable is an associative array
function isAssoc($array)
{
    return (is_array($array) && 0 !== count(array_diff_key($array, array_keys(array_keys($array)))));
}

function getUrlFile()
{
    return 'http://dev.admin.ulsinc.com';
}

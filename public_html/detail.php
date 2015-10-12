<?php
// DETAIL.PHP - displays large image & image/specimen details
// called from index.php

// Enable all error reporting.
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// Setting up requirements.
require_once __DIR__.'/../imu-api-php/IMu.php';
require_once __DIR__.'/../imu-api-php/Session.php';
require_once __DIR__.'/../imu-api-php/Module.php';
require_once __DIR__.'/../imu-api-php/Terms.php';
require_once __DIR__.'/../.env';

// Get query string.
$irn = filter_var($_GET['irn'], FILTER_VALIDATE_INT);

// Create a Session and selecting the module we want to query.
$session = new IMuSession(EMU_IP, EMU_PORT);
$module = new IMuModule('emultimedia', $session);

// Adding our search terms.
$terms = new IMuTerms();
$terms->add('irn', $irn);

// Fetching results.
$hits = $module->findTerms($terms);
$columns = array('irn', 'MulIdentifier', 'MulTitle', 'DetSource', 'NotNotes','DetRights','DetMediaRightsRef.(SummaryData)','<etaxonomy:MulMultiMediaRef_tab>.(ClaGenus,ClaSpecies,AutAuthorString)'); 
$results = $module->fetch('start', 0, 1, $columns);
$record = $results->rows[0];
$irn_string = $irn;
$irn_length = strlen($irn_string);
$num_of_divisions = $irn_length / 3;
$multimedia_url = "";
$taxo_irn = $record['NotNotes'];
$sciname = "";
// World Spider Catalog query string.
$wsc = '<p><a href="http://www.wsc.nmbe.ch/search?sFamily=&fMt=begin&sGenus=GGG&gMt=exact&sSpecies=SPSPSP&sMt=exact&multiPurpose=slsid&mMt=begin&searchSpec=s" target="_blank">World Spider Catalog lookup</a></p><!--adds-->';

// Set up vars.
$thiscredit = $record['DetSource'];
$rights = $record['DetRights'];

//$genus =  $record['etaxonomy:MulMultiMediaRef_tab'][0]['ClaGenus'];
// Ensure the attached record is not empty.
if (!empty($record['etaxonomy:MulMultiMediaRef_tab'])) {
  foreach ($record['etaxonomy:MulMultiMediaRef_tab'] as $taxonomy_record) {
  $genus = $taxonomy_record['ClaGenus'];
  $species = $taxonomy_record['ClaSpecies'];
  $authorstring = $taxonomy_record['AutAuthorString'];
  $sciname = $genus . " " . $species;
  // construct World Spider Catalog query string
  $wsc = str_replace('GGG', $genus, $wsc);
  $wsc = str_replace('SPSPSP', $species, $wsc);
  }
}

// This is the attempt to get the url for the the external specimen record
$r = "";
foreach ($record['DetMediaRightsRef'] as $r_record) {
  $r = $r_record;
}

// Build the filepath to image.
$multimedia_url = "";
$multimedia_url = '/' . substr($irn_string, -3, 3) . $multimedia_url;
$irn_string = substr_replace($irn_string, '', -3, 3);
$multimedia_url = "/" . $irn_string . $multimedia_url;
$multimedia_url = 'http://cornelia.fieldmuseum.org' . $multimedia_url . '/' . $record['MulIdentifier'];

// Get the template.
$page = file_get_contents('tpl-detail.html');

// Get the lookup file(s).
$lookup_bold = file_get_contents('lookup-bold.txt');

// Swap in the vars.  
  $page= str_replace('{thisspecies}', $sciname, $page);
  $page= str_replace('{thiscredit}', $thiscredit, $page);
  $page= str_replace('{rights}', $rights, $page);
  $page= str_replace('{rrights}', $r, $page);
  $page= str_replace('{multimedia_url}', $multimedia_url, $page);
  $page= str_replace('{rbar}', $sciname, $page);
  $page= str_replace('{authorstring}', $authorstring, $page);
  $page= str_replace('{taxoirn}', $taxo_irn, $page);
  // add link(s) based on successful lookup
  if (@strpos($lookup_bold,$sciname) !== false) {
    //add a link
    $mysuffix = $sciname;
    $mysuffix = str_replace(' ', '+', $mysuffix);
    $insert = '<p><a href="http://www.boldsystems.org/index.php/TaxBrowser_TaxonPage?taxon=' . $mysuffix . '" target="_blank">';
    $insert = $insert . 'BOLD systems taxon page</a></p><!--adds-->';
    $page= str_replace('<!--adds-->', $insert, $page); //IRL make this safer
  }
  // add link to WSC
  $page= str_replace('<!--adds-->', $wsc, $page); //IRL make this safer
  
// write it out
print $page;

?>
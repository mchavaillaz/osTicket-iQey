<?php
// Get the config and parse it to an array
$jsonStr = file_get_contents('build_phar_config.json');
$json = json_decode($jsonStr, true);

$languageArray = $json["languages"];
$inputDir = $json["inputDir"];
$outputDir = $json["outputDir"];

// For each language present in the config, we create a .phar and move it to the output dir folder
foreach ($languageArray as $key => $language) {
    // Create language.phar
    $pharName = $language . '.phar';
    $phar = new Phar($pharName, 0, $pharName);

    // Build the language.phar for the inputDir + language
    $languagePath = $inputDir . $language;
    $phar->buildFromDirectory(dirname(__FILE__) . $languagePath);

    // Move the language.phar built in the output directory
    $destinationDirectory = $outputDir . '/' . $pharName;
    rename($pharName, $destinationDirectory);
}
?>

<?php

require(INCLUDE_DIR . 'ConfigSectionEnum.php');

class PropertyService
{
    /**
     * Constant name of the file that contains the application properties.
     */
    const APPLICATION_INI_FILE = 'config.ini';


    /**
     * Array that contains the parsed config.ini.
     *
     * @var array
     */
    var $propertiesArray;

    /**
     * PropertyService constructor.
     *
     * @param $configDir the path to the config directory
     */
    function __construct($configDir)
    {
        $parseSection = true;
        $this->propertiesArray = parse_ini_file($configDir . $this::APPLICATION_INI_FILE, $parseSection);
    }

    /**
     * Get the property "isIqeySetupDownloadPageEnable".
     *
     * @return boolean the value of the property isIqeySetupDownloadPageEnable
     */
    function isIQeySetupDownloadPageEnable()
    {
        return filter_var($this->propertiesArray[ConfigSectionEnum::IQEY_SETUP]['isIqeySetupDownloadPageEnable'], FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the property "isMacDownloadEnable" for the given $sectionName.
     *
     * @param $sectionName string the section name
     * @return boolean the value of the property isMacDownloadEnable for the given $sectionName
     */
    function isMacDownloadEnable($sectionName)
    {
        return filter_var($this->propertiesArray[$sectionName]['isMacDownloadEnable'], FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the property "isWindowsDownloadEnable" for the given $sectionName.
     *
     * @param $sectionName string the section name
     * @return boolean the value of the property isWindowsDownloadEnable for the given $sectionName
     */
    function isWindowsDownloadEnable($sectionName)
    {
        return filter_var($this->propertiesArray[$sectionName]['isWindowsDownloadEnable'], FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the property "macDownloadUrl" for the given language for the given $sectionName.
     *
     * @param $sectionName string the section name
     * @param $language string the current language
     * @return string the value of the property macDownloadUrl for the given $sectionName
     */
    function getMacDownloadUrl($sectionName, $language)
    {
        $key = 'macDownloadUrl' . strtoupper($language);
        return filter_var($this->propertiesArray[$sectionName][$key]);
    }

    /**
     * Get the property "windowsDownloadUrl" for the given language for the given $sectionName.
     *
     * @param $sectionName string the section name
     * @param $language string the current language
     * @return string the value of the property windowsDownloadUrl for the given $sectionName
     */
    function getWindowsDownloadUrl($sectionName, $language)
    {
        $key = 'windowsDownloadUrl' . strtoupper($language);
        return filter_var($this->propertiesArray[$sectionName][$key]);
    }

    /**
     * Get the property "iQeySetupManualUrl" Url in the given language.
     *
     * @param $language string the current language
     * @return string the value of the property iQeySetupManualUrl for the given language
     */
    function getIQeySetupManualUrl($language)
    {
        $key = 'iQeySetupManualUrl' . strtoupper($language);
        return filter_var($this->propertiesArray[ConfigSectionEnum::IQEY_SETUP][$key]);
    }
}

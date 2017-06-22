<?php

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
        $this->propertiesArray = parse_ini_file($configDir . $this::APPLICATION_INI_FILE);
    }

    /**
     * Get the property "isIqeySetupDownloadPageEnable".
     *
     * @return boolean the value of the property isIqeySetupDownloadPageEnable
     */
    function isIQeySetupDownloadPageEnable()
    {
        return filter_var($this->propertiesArray['isIqeySetupDownloadPageEnable'], FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the property "isMacDownloadEnable".
     *
     * @return boolean the value of the property isMacDownloadEnable
     */
    function isMacDownloadEnable()
    {
        return filter_var($this->propertiesArray['isMacDownloadEnable'], FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the property "isWindowsDownloadEnable".
     *
     * @return boolean the value of the property isWindowsDownloadEnable
     */
    function isWindowsDownloadEnable()
    {
        return filter_var($this->propertiesArray['isWindowsDownloadEnable'], FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the property "macDownloadUrl".
     *
     * @return string the value of the property macDownloadUrl
     */
    function getMacDownloadUrl($language)
    {
        $key = 'macDownloadUrl' . strtoupper($language);
        return filter_var($this->propertiesArray[$key]);
    }

    /**
     * Get the property "windowsDownloadUrl" for the given language.
     *
     * @param $language string the current language
     * @return string the value of the property windowsDownloadUrl
     */
    function getWindowsDownloadUrl($language)
    {
        $key = 'windowsDownloadUrl' . strtoupper($language);
        return filter_var($this->propertiesArray[$key]);
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
        return filter_var($this->propertiesArray[$key]);
    }
}

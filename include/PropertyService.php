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
}

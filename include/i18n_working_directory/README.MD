# oSTicket App translation

To translate texts that are not available in the admin panel, use the following steps:

1. Download the language you want to translate http://osticket.com/download-edge (if fr/de/it already present under /inclide/i18n_working_directory/, jump to step 3)
2. UnPhar the file using the following command line: `php -r '$phar = new Phar("XXX.phar"); $phar->extractTo("./MyDirectory");'`

	!!Already done and result available under /include/i18n_working_directory!!
	
3. You can now edit the the translation files in include/i18n_working_directory/YOUR_LANGUAGE/LC_MESSAGES/messages.mo.php
4. Once you are done, open a Terminal in the folder include/i18n_working_directory/ and execute the following command: `php build-phar.php`

	You have just compiled the language into .phar file at the right place in the project (i18n). You can now refresh you page an check the result

# Translation builder tool configuration

The file `build_phar_config.json` contains the config used by `build_phar.php`.

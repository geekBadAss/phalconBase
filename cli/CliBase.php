<?php
require __DIR__ . '/../app/bootstrap.php';
/**
 * CliBase
 *
 * PHP Version 5.3
 *
 * @package   Cli
 * @author    aidan lydon <alyo@loc.gov>
 * @copyright 2014 The Library of Congress
 * @license   Copyright 2014 The Library of Congress
 * @version   $Id:$
 * @link      TBD
 * @since     Sept 24, 2014
 */
abstract class CliBase
{
    /**
     * run
     *
     * @return null
     */
    public function run()
    {
        try {
            $this->_run();
        } catch (Exception $e) {
            xlog($e);
        }
    }

    /**
     * _run
     *
     * @return null
     */
    protected abstract function _run();

    /**
     * _getFilesInDirectory
     *
     * @param string $directory      - directory to search
     * @param array  $fileExtensions - optional list of file extensions to include
     *
     * @return array of full path strings for all files in $directory and sub
     * directories
     */
    protected function _getFilesInDirectory($directory, $fileExtensions = null)
    {
        $files = array();

        if (is_dir($directory) && $dh = opendir($directory)) {
            while (($file = readdir($dh)) !== false) {
                //skip . .. and .svn
                if (in_array($file, array('.', '..', '.svn'))) {
                    continue;
                }

                $path = realpath($directory . '/' . $file);

                //get the file extension
                $extension = pathinfo($path, PATHINFO_EXTENSION);

                if (is_dir($path)) {
                    //directory... recurse
                    $files = array_merge(
                        $files,
                        $this->_getFilesInDirectory(
                            $path,
                            $fileExtensions
                        )
                    );

                } elseif (empty($fileExtensions)
                    || in_array($extension, $fileExtensions)
                ) {
                    $files[] = $path;
                }
            }
            closedir($dh);
        }

        return $files;
    }
}

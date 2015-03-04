<?php
/**
 * AssetCompressor
 *
 * @package Lib
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class AssetCompressor extends Singleton
{
    protected static $_instance;

    const COMPRESSION_ATTEMPTS = 2;

    private $_useMinifiedFiles;
    private $_useCombinedFiles;

    private $_yuiCompressorJarPath;

    private $_publicDir;

    private $_jsCacheDir;
    private $_cssCacheDir;

    private $_jsMinDir;
    private $_cssMinDir;

    private $_jsExtDir;
    private $_cssExtDir;

    private $_jsFiles;
    private $_cssFiles;

    private $_includedJsFileIds;
    private $_includedHeaderJsFileIds;
    private $_includedFooterJsFileIds;
    private $_includedCssFileIds;

    /**
     * __construct
     *
     * @return $this
     */
    protected function __construct()
    {
        //TODO: change this, put yui compressor jar somewhere
        $config = Zend_Registry::get('clientAssets');

        $this->_useMinifiedFiles = (boolean) $config['useMinifiedFiles'];
        $this->_useCombinedFiles = (boolean) $config['useCombinedFiles'];

        $this->_yuiCompressorJarPath = realpath(
            APPLICATION_PATH . '/../' . $config['yuiCompressorJarPath']
        );

        $this->_publicDir = realpath(APPLICATION_PATH . '/../public');

        $this->_jsCacheDir = $this->_publicDir . '/js/cache/';
        $this->_cssCacheDir = $this->_publicDir . '/css/cache/';

        $this->_jsMinDir = $this->_jsCacheDir . 'min/';
        $this->_cssMinDir = $this->_cssCacheDir . 'min/';

        $this->_jsExtDir = $this->_jsMinDir . 'ext/';
        $this->_cssExtDir = $this->_cssMinDir . 'ext/';

        $configDir = realpath(APPLICATION_PATH . '/configs');
        $this->_jsFiles = include $configDir . '/javascript.php';
        $this->_cssFiles = include $configDir . '/css.php';

        $tokens = array(
            '{cdn}'   => $config['cdn'],
            '{media}' => $config['media'],
        );

        $tokenPattern = '/' . implode('|', array_keys($tokens)) . '/';

        foreach ($this->_jsFiles as $jsId => &$jsFile) {
            $matches = array();
            if (preg_match($tokenPattern, $jsFile['file'], $matches)) {
                $jsFile['file'] = str_replace($matches[0], $tokens[$matches[0]], $jsFile['file']);
                $jsFile['origin'] = 'external';
                $jsFile['compressedFullPath'] = $this->_getCompressedExternalJsFilePath(
                    $jsFile['file']
                );

            } else {
                $jsFile['origin'] = 'local';
                $jsFile['compressedFullPath'] = $this->_getCompressedLocalJsFilePath(
                    $jsFile['file']
                );
            }

            if (!is_readable($jsFile['compressedFullPath'])) {
                $this->_useMinifiedFiles = false;
                $this->_useCombinedFiles = false;
            }

            $jsFile['compressedRelativePath'] = $this->_getRelativePath(
                $jsFile['compressedFullPath']
            );

            //js default values
            if (!isset($jsFile['dependencies'])) {
                $jsFile['dependencies'] = array();
            }
            if (!isset($jsFile['head'])) {
                $jsFile['head'] = false;
            }
        }

        foreach ($this->_cssFiles as $cssId => &$cssFile) {
            $matches = array();
            if (preg_match($tokenPattern, $cssFile['file'], $matches)) {
                $cssFile['file'] = str_replace($matches[0], $tokens[$matches[0]], $cssFile['file']);
                $cssFile['origin'] = 'external';
                $cssFile['compressedFullPath'] = $this->_getCompressedExternalCssFilePath(
                    $cssFile['file']
                );

            } else {
                $cssFile['origin'] = 'local';
                $cssFile['compressedFullPath'] = $this->_getCompressedLocalCssFilePath(
                    $cssFile['file']
                );
            }

            if (!is_readable($cssFile['compressedFullPath'])) {
                $this->_useMinifiedFiles = false;
                $this->_useCombinedFiles = false;
            }

            $cssFile['compressedRelativePath'] = $this->_getRelativePath(
                $cssFile['compressedFullPath']
            );

            //css default values
            if (!isset($cssFile['media'])) {
                $cssFile['media'] = 'all';
            }
            if (!isset($cssFile['conditional'])) {
                $cssFile['conditional'] = null;
            }
            if (!isset($cssFile['extras'])) {
                $cssFile['extras'] = null;
            }
        }

        $this->_includedJsFileIds = array();
        $this->_includedHeaderJsFileIds = array();
        $this->_includedFooterJsFileIds = array();
        $this->_includedCssFileIds = array();

        $fileErrors = array();

        if (!is_readable($this->_yuiCompressorJarPath)) {
            $fileErrors[] = 'Unable to find the yui compressor jar file at: ' .
                $this->_yuiCompressorJarPath;
        }
        if (!is_writable($this->_jsCacheDir)) {
            $fileErrors[] = $this->_jsCacheDir . ' has to be writable';
        }
        if (!is_writable($this->_jsMinDir)) {
            $fileErrors[] = $this->_jsMinDir . ' has to be writable';
        }
        if (!is_writable($this->_jsExtDir)) {
            $fileErrors[] = $this->_jsExtDir . ' has to be writable';
        }
        if (!is_writable($this->_cssCacheDir)) {
            $fileErrors[] = $this->_cssCacheDir . ' has to be writable';
        }
        if (!is_writable($this->_cssMinDir)) {
            $fileErrors[] = $this->_cssMinDir . ' has to be writable';
        }
        if (!is_writable($this->_cssExtDir)) {
            $fileErrors[] = $this->_cssExtDir . ' has to be writable';
        }

        if (!empty($fileErrors)) {
            $this->_useMinifiedFiles = false;
            $this->_useCombinedFiles = false;

            if (function_exists('posix_getpwuid') && function_exists('posix_getpwuid')) {
                $user = posix_getpwuid(posix_geteuid());
                $username = $user['name'];

                $fileErrors[] = 'The current user is ' . $username;
            }

            //this will only output in local and development environments
            pre($fileErrors);
        }
    }

    /**
     * addJs
     *
     * @param int/array $fileIds - file id or array of file ids
     *
     * @return null
     */
    public function addJs($fileIds)
    {
        $this->_includedJsFileIds = array_merge($this->_includedJsFileIds, (array) $fileIds);
    }

    /**
     * _resolveJsDependencies
     *
     * @param array   $fileIds - file ids
     * @param boolean $head    - whether files should be included in the header
     *                           only set to true when recursively adding
     *                           dependencies of files that should be included
     *                           in the head
     *
     * @return null
     */
    private function _resolveJsDependencies($fileIds, $head = false)
    {
        //if head = true and a file has dependencies, include them in the head
        //if head = false and a file has dependencies that are already included
        //in the head, don't include them again in the foot
        foreach ($fileIds as &$id) {
            if (!isset($this->_jsFiles[$id])) {
                throw new Exception('unable to locate javascript file with id: ' . $id);
            }
            if ($head || $this->_jsFiles[$id]['head']) {
                if (!in_array($id, $this->_includedHeaderJsFileIds)) {
                    $this->_includedHeaderJsFileIds[] = $id;
                    if (!empty($this->_jsFiles[$id]['dependencies'])) {
                        $this->_resolveJsDependencies(
                            $this->_jsFiles[$id]['dependencies'],
                            true
                        );
                    }
                }
            } else {
                if (!in_array($id, $this->_includedFooterJsFileIds)
                    && !in_array($id, $this->_includedHeaderJsFileIds)
                ) {
                    $this->_includedFooterJsFileIds[] = $id;

                    if (!empty($this->_jsFiles[$id]['dependencies'])) {
                        $this->_resolveJsDependencies(
                            $this->_jsFiles[$id]['dependencies'],
                            false
                        );
                    }
                }
            }
        }
    }

    /**
     * addCss
     *
     * @param int/array $fileIds - file id or array of file ids
     *
     * @return null
     */
    public function addCss($fileIds)
    {
        $fileIds = (array) $fileIds;

        foreach ($fileIds as &$id) {
            if (!isset($this->_cssFiles[$id])) {
                throw new Exception('unable to locate css file with id: ' . $id);
            }

            if (!in_array($id, $this->_includedCssFileIds)) {
                $this->_includedCssFileIds[] = $id;
            }
        }
    }

    /**
     * getHeaderJavascriptFiles - called from html header
     *
     * @return array
     */
    public function getHeaderJavascriptFiles()
    {
        $this->_resolveJsDependencies($this->_includedJsFileIds);
        return $this->_getJs($this->_includedHeaderJsFileIds);
    }

    /**
     * getFooterJavascriptFiles - called from the footer partial view
     *
     * @return array
     */
    public function getFooterJavascriptFiles()
    {
        return $this->_getJs($this->_includedFooterJsFileIds);
    }

    /**
     * _getJs
     *
     * @param array $fileIds
     *
     * @return array
     */
    private function _getJs($fileIds)
    {
        $files = array();

        sort($fileIds);

        foreach ($fileIds as &$fileId) {
            $info = $this->_jsFiles[$fileId];

            if ($this->_useMinifiedFiles && is_readable($info['compressedFullPath'])) {
                $info['file'] = $info['compressedRelativePath'];
            }

            $files[] = $info['file'];
        }

        if ($this->_useCombinedFiles) {
            //check for a combined file
            $combinedFile = $this->_jsCacheDir . md5(implode('-', $fileIds)) . '.js';

            $recombine = true;

            if (file_exists($combinedFile)) {
                $lastModified = filemtime($combinedFile);

                if ($lastModified > mktime(0, 0, 0)) {
                    //the combined file was written today
                    $recombine = false;
                }
            }

            if ($recombine) {
                $h = fopen($combinedFile, 'w');
                foreach ($files as &$file) {
                    if (substr($file, 0, 1) == '/') {
                        $file = realpath($this->_publicDir . $file);
                    }

                    fwrite($h, file_get_contents($file) . "\n");
                }

                fclose($h);
            }

            $files = array($this->_getRelativePath($combinedFile));
        }

        return $files;
    }

    /**
     * getCss - called in html header
     *
     * @return array
     */
    public function getCss()
    {
        $rawFiles = array();

        sort($this->_includedCssFileIds);

        //exclude files that shouldn't be combined
        //put them at the end of the return array
        $doNotCombine = array();

        foreach ($this->_includedCssFileIds as $index => &$fileId) {
            $info = $this->_cssFiles[$fileId];

            if ($this->_useMinifiedFiles && is_readable($info['compressedFullPath'])) {
                $info['file'] = $info['compressedRelativePath'];
            }

            if ($info['media'] != 'all'
                || !is_null($info['conditional'])
                || !is_null($info['extras'])
            ) {
                //do not combine this file
                $doNotCombine[] = $info;
                unset($this->_includedCssFileIds[$index]);
            } else {
                $rawFiles[] = $info;
            }
        }

        $usingCombinedFile = false;

        if ($this->_useCombinedFiles) {

            $usingCombinedFile = true;

            //check for a combined file
            $combinedFile = $this->_cssCacheDir . md5(implode('-', $this->_includedCssFileIds)) .
                '.css';

            $recombine = true;

            if (file_exists($combinedFile)) {
                //check the last modified date
                $lastModified = filemtime($combinedFile);

                if ($lastModified > mktime(0, 0, 0)) {
                    //the combined file was written today
                    $recombine = false;
                }
            }

            if ($recombine) {
                $h = fopen($combinedFile, 'w');
                foreach ($rawFiles as &$file) {
                    if (is_readable($file['compressedFullPath'])) {
                        fwrite($h, file_get_contents($file['compressedFullPath']) . "\n");
                    } else {

                        $usingCombinedFile = false;
                    }
                }

                fclose($h);
            }

            $files = array(
                array(
                    'file'        => $this->_getRelativePath($combinedFile),
                    'media'       => 'all',
                    'conditional' => null,
                    'extras'      => null,
                ),
            );
        }

        if (!$usingCombinedFile) {
            //return all files
            $files = $rawFiles;
        }

        $files = array_merge($files, $doNotCombine);

        return $files;
    }

    /**
     * compress
     *
     * @param string $filePath - full path to uncompressed file
     * @param array  $options  - array of compression options
     *
     * @return string
     */
    public function compress($filePath, $options = array())
    {
        $ret = false;

        if (!is_readable($filePath)) {
            throw new Exception('unable to read file: ' . $filePath);
        }

        $pathInfo = pathInfo($filePath);

        if (!in_array($pathInfo['extension'], array('css', 'js'))) {
            throw new Exception('unsupported file type: ' . $filePath);
        }

        $cmd = "java -Xmx32m -jar " . escapeshellarg($this->_yuiCompressorJarPath) .
            ' ' . escapeshellarg($filePath) . " --charset UTF-8 --type " .
            $pathInfo['extension'];

        /**
         * these options are not currently used
         *
        if (array_key_exists('lineBreak', $options) && intval($options['lineBreak']) > 0) {
            $cmd .= ' --line-break ' . intval($options['lineBreak']);
        }

        if (array_key_exists('verbose', $options) && $options['verbose']) {
            $cmd .= " -v";
        }

        if (array_key_exists('noMunge', $options) && $options['noMunge']) {
            $cmd .= ' --nomunge';
        }

        if (array_key_exists('semi', $options) && $options['semi']) {
            $cmd .= ' --preserve-semi';
        }

        if (array_key_exists('noOptimize', $options) && $options['noOptimize']) {
            $cmd .= ' --disable-optimizations';
        }
         */

        exec($cmd . ' 2>&1', $raw);

        if (!empty($raw)) {
            $ret = trim(implode("\n", $raw));
        }

        return $ret;
    }

    /**
     * clearCssCache
     *
     * @return null
     */
    public function clearCssCache()
    {
        $this->_deleteFiles($this->_cssCacheDir . '*.css');
        $this->_deleteFiles($this->_cssMinDir   . '*.css');
        $this->_deleteFiles($this->_cssExtDir   . '*.css');

        //delete (most but not all) jquery ui images
        //animated-overlay.gif
        //and
        //ui-bg_flat_0_aaaaa_40x100.png
        //do not exist on the cdn, that's why they are checked into svn and not
        //deleted here
        $dir = $this->_cssCacheDir . 'images/';
        $this->_deleteFiles($dir . 'ui-bg_flat_100_cccccc_40x100.png');
        $this->_deleteFiles($dir . 'ui-bg_flat_100_eeeeee_40x100.png');
        $this->_deleteFiles($dir . 'ui-bg_flat_100_ffffff_40x100.png');
        $this->_deleteFiles($dir . 'ui-bg_glass_55_fbf9ee_1x400.png');
        $this->_deleteFiles($dir . 'ui-bg_glass_95_fef1ec_1x400.png');
        $this->_deleteFiles($dir . 'ui-icons_2e83ff_256x240.png');
        $this->_deleteFiles($dir . 'ui-icons_333333_256x240.png');
        $this->_deleteFiles($dir . 'ui-icons_888888_256x240.png');
        $this->_deleteFiles($dir . 'ui-icons_cd0a0a_256x240.png');

        $dir = $this->_cssExtDir . 'images/';
        $this->_deleteFiles($dir . 'ui-bg_flat_100_cccccc_40x100.png');
        $this->_deleteFiles($dir . 'ui-bg_flat_100_eeeeee_40x100.png');
        $this->_deleteFiles($dir . 'ui-bg_flat_100_ffffff_40x100.png');
        $this->_deleteFiles($dir . 'ui-bg_glass_55_fbf9ee_1x400.png');
        $this->_deleteFiles($dir . 'ui-bg_glass_95_fef1ec_1x400.png');
        $this->_deleteFiles($dir . 'ui-icons_2e83ff_256x240.png');
        $this->_deleteFiles($dir . 'ui-icons_333333_256x240.png');
        $this->_deleteFiles($dir . 'ui-icons_888888_256x240.png');
        $this->_deleteFiles($dir . 'ui-icons_cd0a0a_256x240.png');

        //delete other images
        $this->_deleteFiles($this->_cssCacheDir . 'sprite_carousel.png');
        $this->_deleteFiles($this->_cssExtDir . 'sprite_carousel.png');
    }

    /**
     * clearJsCache
     *
     * @return null
     */
    public function clearJsCache()
    {
        $this->_deleteFiles($this->_jsCacheDir . '*.js');
        $this->_deleteFiles($this->_jsMinDir   . '*.js');
        $this->_deleteFiles($this->_jsExtDir   . '*.js');
    }

    /**
     * _deleteFiles
     *
     * @param string $path
     *
     * @return null
     */
    private function _deleteFiles($path)
    {
        exec('rm -f ' . $path);
    }

    /**
     * compressAllJsFiles
     *
     * @return null
     */
    public function compressAllJsFiles()
    {
        //compress all javascript files
        foreach ($this->_jsFiles as $info) {
            if ($info['origin'] == 'local') {
                $this->_compressLocalJsFile($info['file']);
            } else {
                $this->_compressExternalJsFile($info['file']);
            }
        }
    }

    /**
     * _compressLocalJsFile
     *
     * @param string $file    - absolute path from public docroot; e.g. /js/accounts.js
     * @param int    $attempt - the number of the attempts
     *
     * @return null
     */
    private function _compressLocalJsFile($file, $attempt = 1)
    {
        $success = false;

        $path = $this->_getFullPathToLocalFile($file);

        if ($compressedContent = $this->compress($path)) {

            $compressedPath = $this->_getCompressedLocalJsFilePath($path);

            $result = file_put_contents($compressedPath, $compressedContent);

            if ($result !== false) {
                $success = true;
            }
        }

        if (!$success) {
            if ($attempt >= self::COMPRESSION_ATTEMPTS) {
                throw new Exception($file . ' failed to compress');
            } else {
                $attempt++;
                $this->_compressLocalJsFile($file, $attempt);
            }
        }
    }

    /**
     * _compressExternalJsFile
     *
     * @param string $url     - url of external js file
     * @param int    $attempt -
     *
     * @return null
     */
    private function _compressExternalJsFile($url, $attempt = 1)
    {
        $success = false;

        $compressedPath = $this->_getCompressedExternalJsFilePath($url);

        if (copy($url, $compressedPath)) {
            if (strpos($compressedPath, '.min.') === false) {
                if ($compressedContent = $this->compress($compressedPath)) {

                    $result = file_put_contents($compressedPath, $compressedContent);

                    if ($result !== false) {
                        $success = true;
                    }
                }
            } else {
                //the file is already compressed
                $success = true;
            }
        }

        if (!$success) {
            if ($attempt >= self::COMPRESSION_ATTEMPTS) {
                throw new Exception($file . ' failed to compress');
            } else {
                $attempt++;
                $this->_compressExternalJsFile($file, $attempt);
            }
        }
    }

    /**
     * compressAllCssFiles
     *
     * @return null
     */
    public function compressAllCssFiles()
    {
        //compress all css files
        foreach ($this->_cssFiles as $info) {
            if ($info['origin'] == 'local') {
                $this->_compressLocalCssFile($info['file']);
            } else {
                $this->_compressExternalCssFile($info['file']);
            }
        }
    }

    /**
     * _compressLocalCssFile
     *
     * @param string $file - absolute path from public docroot; e.g. /css/accordion.css
     *
     * @return null
     */
    private function _compressLocalCssFile($file, $attempts = 0)
    {
        $success = false;

        $path = $this->_getFullPathToLocalFile($file);

        if ($compressedContent = $this->compress($path)) {

            $compressedPath = $this->_getCompressedLocalCssFilePath($path);

            $result = file_put_contents($compressedPath, $compressedContent);

            if ($result !== false) {
                $success = true;
            }
        }

        if (!$success) {
            if ($attempt >= self::COMPRESSION_ATTEMPTS) {
                throw new Exception($file . ' failed to compress');
            } else {
                $attempt++;
                $this->_compressLocalCssFile($file, $attempt);
            }
        }
    }

    /**
     * _compressExternalCssFile
     *
     * @param string $url - url of external css file
     *
     * @return null
     */
    private function _compressExternalCssFile($url)
    {
        $success = false;

        $compressedPath = $this->_getCompressedExternalCssFilePath($url);

        if (copy($url, $compressedPath)) {
            //if the external css file contains references to external images
            //copy the images to css/cache (for compressed and combined files)
            //and css/cache/ext for compressed but not combined files
            //which image will be used depends on config settings

            //NOTE: images are only copied once if they don't exist locally
            //so if they are updated on the cdn, the local copies have to be
            //manually deleted. since this only happens with the jquery-ui,
            //it doesn't seem like a problem that's going to come up very
            //often, but I'm still not happy about it. - aidan
            $matches = array();

            $content = file_get_contents($compressedPath);

            $urls = $this->extractCssUrls($content);

            if (array_key_exists('property', $urls) && !empty($urls['property'])) {

                $pathInfo = pathinfo($url);

                $imageUrls = array_unique($urls['property']);

                foreach ($imageUrls as $imageUrl) {
                    if (substr($imageUrl, 0, 4) !== 'http') {
                        //create the full url
                        if (substr($imageUrl, 0, 1) == '/') {
                            //absolute path based on external docroot
                            //NOTE: this hasn't come up, but just in case
                            //get the directories from the $url
                            $imageUrlPathInfo = pathinfo($imageUrl);
                            $directories = explode('/', substr($imageUrlPathInfo['dirname'], 1));

                            $lastIndex = count($directories) - 1;

                            $notFound = array();

                            for ($i = $lastIndex; $i > -1; $i--) {
                                $foundPosition = strpos(
                                    $pathInfo['dirname'],
                                    $directories[$i]
                                );

                                if ($foundPosition === false) {
                                    $notFound[] = $directories[$i];
                                }
                            }

                            $fullUrl = $pathInfo['dirname'] . '/' .
                                implode('/', $notFound) . '/' .
                                $imageUrlPathInfo['basename'];

                        } else {
                            $fullUrl = $pathInfo['dirname'] . '/' . $imageUrl;
                        }

                        if (!file_exists($this->_cssCacheDir . $imageUrl)) {
                            //copy the file to $this->_cssCacheDir . $url
                            $this->_safeCssImageCopy($fullUrl, $this->_cssCacheDir . $imageUrl);
                        }
                        if (!file_exists($this->_cssExtDir . $imageUrl)) {
                            //copy the file to $this->_cssExtDir . $url
                            $this->_safeCssImageCopy($fullUrl, $this->_cssExtDir . $imageUrl);
                        }
                    }
                }

                if (strpos($compressedPath, '.min.') === false) {
                    if ($compressedContent = $this->compress($compressedPath)) {

                        $result = file_put_contents($compressedPath, $compressedContent);

                        if ($result !== false) {
                            $success = true;
                        }
                    }
                } else {
                    //the file is already compressed
                    $success = true;
                }
            }
        }

        if (!$success) {
            if ($attempt >= self::COMPRESSION_ATTEMPTS) {
                throw new Exception($file . ' failed to compress');
            } else {
                $attempt++;
                $this->_compressExternalCssFile($file, $attempt);
            }
        }
    }

    /**
     * _safeCssImageCopy
     *
     * @param string $origin -
     * @param string $path   -
     *
     * @return null
     */
    private function _safeCssImageCopy($origin, $path)
    {
        $pathInfo = pathinfo($path);

        $relativePath = str_replace(substr($this->_cssCacheDir, 0, -1), '', $pathInfo['dirname']);

        if (substr($relativePath, 0, 1) == '/') {
            $relativePath = substr($relativePath, 1);
        }

        //ensure directory structure exists
        $subDirectories = explode('/', $relativePath);

        $subDir = $this->_cssCacheDir;

        foreach ($subDirectories as $dir) {
            $subDir .= '/' . $dir;

            if (!file_exists($subDir)) {
                exec('mkdir ' . $subDir);
            }
        }

        //If this fails, check to make sure the image file exists on the external
        //server.

        copy($origin, $path);
    }

    /**
     * extractCssUrls - Extract URLs from CSS text.
     *
     * @param string $text
     *
     * @return array
     */
    function extractCssUrls($text)
    {
        $urls = array();

        $url_pattern     = '(([^\\\\\'", \(\)]*(\\\\.)?)+)';
        $urlfunc_pattern = 'url\(\s*[\'"]?' . $url_pattern . '[\'"]?\s*\)';
        $pattern         = '/(' .
             '(@import\s*[\'"]' . $url_pattern     . '[\'"])' .
            '|(@import\s*'      . $urlfunc_pattern . ')'      .
            '|('                . $urlfunc_pattern . ')'      .  ')/iu';

        if (!preg_match_all($pattern, $text, $matches)) {
            return $urls;
        }

        // @import '...'
        // @import "..."
        foreach ($matches[3] as $match) {
            if (!empty($match)) {
                $urls['import'][] = preg_replace('/\\\\(.)/u', '\\1', $match);
            }
        }

        // @import url(...)
        // @import url('...')
        // @import url("...")
        foreach ($matches[7] as $match) {
            if (!empty($match)) {
                $urls['import'][] = preg_replace('/\\\\(.)/u', '\\1', $match);
            }
        }

        // url(...)
        // url('...')
        // url("...")
        foreach ($matches[11] as $match) {
            if (!empty($match)) {
                $urls['property'][] = preg_replace('/\\\\(.)/u', '\\1', $match);
            }
        }

        return $urls;
    }

    /**
     * _getFullPathToLocalFile
     *
     * @param string $file - path from the public document root; e.g. /js/accounts.js
     *
     * @return string
     */
    private function _getFullPathToLocalFile($file)
    {
        return $this->_publicDir . $file;
    }

    /**
     * _getCompressedLocalJsFilePath - get the full path to the local compressed copy of a LOCAL
     * javascript file
     *
     * @param string $path - full path to the original file
     *
     * @return string
     */
    private function _getCompressedLocalJsFilePath($path)
    {
        $pathInfo = pathInfo($path);
        return $this->_jsMinDir . $pathInfo['basename'];
    }

    /**
     * _getCompressedExternalJsFilePath - get the full path to the local compressed copy of an
     * EXTERNAL javascript file
     *
     * @param string $url - url of external file
     *
     * @return string
     */
    private function _getCompressedExternalJsFilePath($url)
    {
        $pathInfo = pathInfo($url);
        return $this->_jsExtDir . $pathInfo['basename'];
    }

    /**
     * _getCompressedLocalCssFilePath - get the full path to the local compressed copy of a LOCAL
     * css file
     *
     * @param string $path - full path to the original file
     *
     * @return string
     */
    private function _getCompressedLocalCssFilePath($path)
    {
        $pathInfo = pathInfo($path);
        return $this->_cssMinDir . $pathInfo['basename'];
    }

    /**
     * _getCompressedExternalCssFilePath - get the full path to the local compressed copy of an
     * EXTERNAL css file
     *
     * @param string $url
     *
     * @return string
     */
    private function _getCompressedExternalCssFilePath($url)
    {
        $pathInfo = pathInfo($url);
        return $this->_cssExtDir . $pathInfo['basename'];
    }

    /**
     * _getRelativePath
     *
     * @param string $fullPath
     *
     * @return string
     */
    private function _getRelativePath($fullPath)
    {
        return str_replace($this->_publicDir, '', $fullPath);
    }
}

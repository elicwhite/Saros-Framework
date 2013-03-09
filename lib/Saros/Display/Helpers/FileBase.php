<?php
namespace Saros\Display\Helpers;
/**
 * This class helps create a list of script tags in layout headers
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
abstract class FileBase extends HelperBase
{
    protected $files = array();
    protected $pageFiles = array();

    public function appendFile($path)
    {
        $this->files[] = $path;

        return $this;
    }

    public function appendPageFile($path) {
        $this->pageFiles[] = $path;

        return $this;
    }

    public function prependFile($path)
    {
        array_unshift($this->files, $path);

        return $this;
    }

    public function prependPageFile($path)
    {
        array_unshift($this->pageFiles, $path);

        return $this;
    }

    public function getFiles() {
        return array_merge($this->files, $this->pageFiles);
    }

    public function __toString()
    {
        $output = "";
        foreach ($this->getFiles() as $file)
        {
            $output .= $this->displayFile($file);
        }

        return $output;
    }

    protected abstract function displayFile($file);
}
<?php
namespace Saros\Display\Helpers;

/**
 * This class helps create a list of style tags in layout headers
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class HeadStyles extends HelperBase
{
	public $files = array();

    public function appendFile($path)
    {
        $this->files[] = $path;

        return $this;
    }
    
    public function prependFile($path) 
    {
        array_unshift($this->files, $style);

        return $this;
    }

	public function __toString()
	{
		$output = "";
		foreach ($this->files as $file)
		{
			$output .= '<link rel="stylesheet" type="text/css" href="'.$GLOBALS['registry']->config["siteUrl"].$file.'" />';
		}

		return $output;
	}
}
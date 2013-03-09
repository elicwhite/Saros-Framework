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
class HeadScripts extends FileBase
{
    protected function displayFile($file) {
        return '<script src="'.$GLOBALS['registry']->config["siteUrl"].$file.'" type="text/javascript"></script>';
    }
}
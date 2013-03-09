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
class HeadStyles extends FileBase
{
    protected function displayFile($file) {
        return '<link rel="stylesheet" type="text/css" href="'.$GLOBALS['registry']->config["siteUrl"].$file.'" />';
    }
}
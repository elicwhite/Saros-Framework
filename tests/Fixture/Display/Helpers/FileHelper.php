<?php
namespace Fixture\Display\Helpers;

class FileHelper extends \Saros\Display\Helpers\FileBase
{
    protected function displayFile($file) {
        return '-'.$file.'-';
    }
}
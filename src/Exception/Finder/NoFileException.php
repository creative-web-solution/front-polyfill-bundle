<?php

namespace Cws\Bundle\FrontPolyfillBundle\Exception\Finder;

/**
 * Class NoFileException
 * @package Cws\Bundle\FrontPolyfillBundle\Exception\Finder
 */
class NoFileException extends \Exception
{
    protected $message = 'File not found.';
}

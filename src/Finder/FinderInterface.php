<?php

namespace Cws\Bundle\FrontPolyfillBundle\Finder;

use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Finder\Finder;

/**
 * Interface FinderInterface
 * @package Cws\Bundle\FrontPolyfillBundle\Finder
 */
interface FinderInterface
{
    /**
     * @param string $path
     * @param string $filename
     *
     * @return SplFileInfo|null
     */
    public function find(string $path, string $filename);

    /**
     * @return Finder|null
     */
    public function getFinder();
}

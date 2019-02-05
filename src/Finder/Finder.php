<?php

namespace Cws\Bundle\FrontPolyfillBundle\Finder;

use Symfony\Component\Finder\Finder as FinderComponent;

/**
 * Class Finder
 * @package Cws\Bundle\FrontPolyfillBundle\Finder
 */
class Finder implements FinderInterface
{
    private $finder = null;
    
    /**
     * {@inheritdoc}
     */
    public function find(string $path, string $filename)
    {
        $finder = $this->getFinder();
        $finder->in($path)->files()->name($filename);

        foreach ($finder->getIterator() as $file) {
            return $file;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFinder()
    {
        if (is_null($this->finder)) {
            return new FinderComponent();
        }

        return $this->finder;
    }
}

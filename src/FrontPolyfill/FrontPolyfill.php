<?php

namespace Cws\Bundle\FrontPolyfillBundle\FrontPolyfill;

use Cws\Bundle\FrontPolyfillBundle\Exception\Finder\NoFileException;
use Cws\Bundle\FrontPolyfillBundle\Finder\FinderInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;

/**
 * Class FrontPolyfill
 * @package Cws\Bundle\FrontPolyfillBundle\FrontPolyfill
 */
class FrontPolyfill
{
    const CACHE_KEY_BEGIN = 'front_polyfill';

    /** @var FinderInterface */
    protected $finder;

    /** @var array */
    protected $config;

    /** @var string */
    protected $rootDir;

    /**
     * FrontPolyfill constructor.
     *
     * @param FinderInterface $finder
     * @param string $rootDir
     *
     * @throws NoFileException
     */
    public function __construct(FinderInterface $finder, string $rootDir)
    {
        $file = $finder->find(sprintf('%s/../frontend/polyfill', $rootDir), 'config.yaml');

        $this
            ->setConfig($file)
            ->setFinder($finder)
            ->setRootDir($rootDir)
        ;
    }

    /**
     * Create a file with the needed polyfill
     *
     * @param array $names
     *
     * @return string
     *
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getContent(array $names = [])
    {
        if (count($names) < 1) {
            return '';
        }

        $keys = array_unique($names);

         sort($keys);
         $cacheKey = implode('_', $keys);

         $cache = new FilesystemAdapter();
         $polyfillCache = $cache->getItem(sprintf('%s.%s', self::CACHE_KEY_BEGIN, $cacheKey));

         if ($polyfillCache->isHit()) {
             return $polyfillCache->get();
         }

        $result = [];
        $polyfillList = $this->getConfig()['polyfill'];

        foreach ($keys as $name) {
            if (isset($polyfillList[$name])) {
                $result[] = file_get_contents(sprintf(
                    '%s/../Resources/js/%s',
                    __DIR__,
                    $polyfillList[$name]['file']
                ));
            }
        }

        $strResult = implode(PHP_EOL, $result);

         $polyfillCache->set($strResult);
         $cache->save($polyfillCache);

        return $strResult;
    }

    /**
     * Return an array of currently active polyfill
     *
     * @return array
     */
    public function getActivePolyfill()
    {
        $activePolyfill = [];
        $activePolyfillCount = 0;

        foreach ($this->getConfig()['polyfill'] as $key => $polyfill) {
            if ($polyfill['active']) {
                $activePolyfill[$key] = $polyfill;
                ++$activePolyfillCount;
            }
        }

        return [
            'list' => $activePolyfill,
            'count' => $activePolyfillCount,
        ];
    }

    /**
     * - - - - - - - - - - - -
     *       ACCESSORS
     * - - - - - - - - - - - -
     */

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param null|SplFileInfo $file
     *
     * @return FrontPolyfill
     *
     * @throws NoFileException
     */
    public function setConfig($file = null)
    {
        if (is_null($file)) {
            throw new NoFileException();
        }

        $this->config = Yaml::parse(file_get_contents($file));

        return $this;
    }

    /**
     * @return FinderInterface
     */
    public function getFinder()
    {
        return $this->finder;
    }

    /**
     * @param FinderInterface $finder
     *
     * @return FrontPolyfill
     */
    public function setFinder(FinderInterface $finder)
    {
        $this->finder = $finder;

        return $this;
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return $this->rootDir;
    }

    /**
     * @param string $rootDir
     *
     * @return FrontPolyfill
     */
    public function setRootDir(string $rootDir)
    {
        $this->rootDir = $rootDir;

        return $this;
    }
}
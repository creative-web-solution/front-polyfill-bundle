<?php

namespace Cws\Bundle\FrontPolyfillBundle\FrontPolyfill;

use Cws\Bundle\FrontPolyfillBundle\FrontPolyfill\FrontPolyfill;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class FrontPolyfillTwigExtension
 * @package Cws\Bundle\FrontPolyfillBundle\FrontPolyfill
 */
class FrontPolyfillTwigExtension extends AbstractExtension
{
    /** @var FrontPolyfill */
    protected $polyfill;

    /** @var RequestStack */
    protected $request;

    /**
     * FrontPolyfillTwigExtension constructor.
     *
     * @param FrontPolyfill $polyfill
     */
    public function __construct(FrontPolyfill $polyfill, RequestStack $request)
    {
        $this->polyfill = $polyfill;
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('get_front_polyfill_list', [$this, 'getFrontPolyfillList']),
            new TwigFunction('get_front_polyfill_content', [$this, 'getFrontPolyfillContent'])
        ];
    }

    /**
     * @return string
     */
    public function getFrontPolyfillList()
    {
        return $this->polyfill->getActivePolyfill();
    }

    /**
     * @return string
     */
    public function getFrontPolyfillContent()
    {
        $request = $this->request->getCurrentRequest();

        return $this->polyfill->getContent(array_keys($request->query->all()));
    }
}

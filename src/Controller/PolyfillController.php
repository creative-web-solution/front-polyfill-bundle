<?php

namespace Cws\Bundle\FrontPolyfillBundle\Controller;

use Cws\Bundle\FrontPolyfillBundle\Response\ResponseConfig;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PolyfillController
 * @package Cws\Bundle\FrontPolyfillBundle\Controller
 */
class PolyfillController extends AbstractController
{
    /**
     * @return Response
     *
     * @throws \Exception
     */
    public function jsConfig()
    {
        $response = new ResponseConfig();

        return $this->render('@CwsFrontPolyfill/system/config.js.twig', [
            'polyfillList' => $this->get('cws.polyfill.front_polyfill')->getActivePolyfill()
        ], $response->buildJs());
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \Exception
     */
    public function jsPolyfill(Request $request)
    {
        $polyfill = $this->get('cws.polyfill.front_polyfill');
        $responseConfig = new ResponseConfig();

        return $responseConfig->buildJs(new Response($polyfill->getContent(array_keys($request->query->all()))));
    }
}

<?php

namespace Cws\Bundle\FrontPolyfillBundle\Controller;

use Cws\Bundle\FrontPolyfillBundle\FrontPolyfill\FrontPolyfill;
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
        $response = new Response($polyfill->getContent(array_keys($request->query->all())));
        $response->setMaxAge(31536000); // 1 year in seconds

        $expirationDate = new \DateTime();
        $expirationDate->modify('+'.$response->getMaxAge().' seconds');

        $response->setExpires($expirationDate);
        $response->headers->set('Content-Type', 'text/javascript');
        $response->setCache(['public' => true]);

        return $response;
    }
}

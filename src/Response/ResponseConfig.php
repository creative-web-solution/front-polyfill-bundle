<?php

namespace Cws\Bundle\FrontPolyfillBundle\Response;

use Cws\Bundle\FrontPolyfillBundle\Helper\TimeHelper;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResponseConfig
 * @package Cws\Bundle\FrontPolyfillBundle\Response
 */
class ResponseConfig
{
    /**
     * @param Response $response
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function buildJs(Response $response = null)
    {
        $response = $this->build($response);
        $response->headers->set('Content-Type', 'text/javascript');

        return $response;
    }

    /**
     * @param Response|null $response
     *
     * @return Response
     *
     * @throws \Exception
     */
    private function build(Response $response = null)
    {
        if (is_null($response)) {
            $response = new Response();
        }

        $response->setMaxAge(TimeHelper::YEAR_IN_SECONDS);

        $expirationDate = new \DateTime();
        $expirationDate->modify('+'.$response->getMaxAge().' seconds');

        $response->setExpires($expirationDate);
        $response->setCache(['public' => true]);

        return $response;
    }
}

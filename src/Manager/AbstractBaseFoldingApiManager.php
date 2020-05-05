<?php

namespace App\Manager;

use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractBaseFoldingApiManager
{
    protected CurlHttpClient $httpClient;
    protected SerializerInterface $serializer;
    protected string $foldingApiUrl;

    /**
     * Constructor.
     */
    public function __construct(string $foldingApiUrl)
    {
        $this->foldingApiUrl = $foldingApiUrl;
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->httpClient = new CurlHttpClient();
    }

    /**
     * @return ResponseInterface
     *
     * @throws TransportExceptionInterface
     */
    protected function makeFoldingApiHttpServerRequestToEndPoint(string $endPoint)
    {
        return $this->httpClient->request(Request::METHOD_GET, $this->foldingApiUrl.$endPoint);
    }
}

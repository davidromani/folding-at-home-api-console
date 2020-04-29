<?php

namespace App\Manager;

use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class FoldingCrawlerManager
{
    private string $foldingApiUrl;
    private int    $foldingTeamNumber;
    private CurlHttpClient $httpClient;
    private ResponseInterface $response;

    /**
     * Constructor
     *
     * @param string $foldingApiUrl
     * @param int $foldingTeamNumber
     */
    public function __construct(string $foldingApiUrl, int $foldingTeamNumber)
    {
        $this->foldingApiUrl = $foldingApiUrl;
        $this->foldingTeamNumber = $foldingTeamNumber;
        $this->httpClient = new CurlHttpClient();
        $this->response = $this->makeFoldingHttpServerRequest();
    }

    public function getGreetingsMsg(): string
    {
        $result = 'Hello World! ';
        if ($this->response->getStatusCode() == 200) {
            $result .= $this->response->getContent();
        }

        return $result;
    }

    /**
     * @return ResponseInterface
     *
     * @throws TransportExceptionInterface
     */
    private function makeFoldingHttpServerRequest()
    {
        return $this->httpClient->request('GET', $this->foldingApiUrl.$this->foldingTeamNumber);
    }
}

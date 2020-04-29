<?php

namespace App\Manager;

use Symfony\Component\HttpClient\CurlHttpClient;

class FoldingCrawlerManager
{
    private string $foldingCrawlerUrl;
    private int    $foldingTeamNumber;
    private CurlHttpClient $httpClient;
    private $response;

    /**
     * Constructor
     */
    public function __construct(string $foldingCrawlerUrl, int $foldingTeamNumber)
    {
        $this->foldingCrawlerUrl = $foldingCrawlerUrl;
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

    private function makeFoldingHttpServerRequest()
    {
      return $this->httpClient->request('GET', $this->foldingCrawlerUrl.$this->foldingTeamNumber);
    }
}

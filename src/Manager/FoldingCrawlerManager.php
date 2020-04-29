<?php

namespace App\Manager;

use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
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

    public function getCurrentTotalTeams(): string
    {
        $result = 'getCurrentTotalTeams = ';
        try {
            $response = $this->httpClient->request(Request::METHOD_GET, $this->foldingApiUrl.'count');
            $result .= $response->getContent();
        } catch (TransportExceptionInterface $exception) {
            $result .= '[ERROR] TransportExceptionInterface';
        } catch (ClientExceptionInterface $e) {
            $result .= '[ERROR] ClientExceptionInterface';
        } catch (RedirectionExceptionInterface $e) {
            $result .= '[ERROR] RedirectionExceptionInterface';
        } catch (ServerExceptionInterface $e) {
            $result .= '[ERROR] ServerExceptionInterface';
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
        return $this->httpClient->request(Request::METHOD_GET, $this->foldingApiUrl.$this->foldingTeamNumber);
    }
}

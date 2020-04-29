<?php

namespace App\Manager;

use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class FoldingCrawlerManager
{
    private string $foldingApiUrl;
    private int    $foldingTeamNumber;
    private CurlHttpClient $httpClient;

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
    }

    /**
     * Get Folding@Home team | or negative string on API connection error
     *
     * @param int|null $id
     *
     * @return string
     */
    public function getTeamByIdNumber(?int $id = null): string
    {
        $teamNumberString = (string)$this->foldingTeamNumber;
        if (!is_null($id)) {
            $teamNumberString = (string)$id;
        }

        try {
//            $result = implode(
//                ' · ',
//                $this->makeFoldingApiHttpServerRequestToEndPoint($teamNumberString)->toArray(false)
//            );
            $result = $this->makeFoldingApiHttpServerRequestToEndPoint($teamNumberString)->getContent(false);
        } catch (DecodingExceptionInterface $exception) {
            $result = '-1';
        } catch (TransportExceptionInterface $exception) {
            $result = '-2';
        } catch (ClientExceptionInterface $e) {
            $result = '-3';
        } catch (RedirectionExceptionInterface $e) {
            $result = '-4';
        } catch (ServerExceptionInterface $e) {
            $result = '-5';
        }

        return $result;
    }

    /**
     * Get Folding@Home current teams amount | or negative number on API connection error
     *
     * @return int
     */
    public function getCurrentTotalTeams(): int
    {
        try {
            $result = intval($this->makeFoldingApiHttpServerRequestToEndPoint('count')->getContent());
        } catch (TransportExceptionInterface $exception) {
            $result = -6;
        } catch (ClientExceptionInterface $e) {
            $result = -7;
        } catch (RedirectionExceptionInterface $e) {
            $result = -8;
        } catch (ServerExceptionInterface $e) {
            $result = -9;
        }

        return $result;
    }

    /**
     * @param string $endPoint
     *
     * @return ResponseInterface
     *
     * @throws TransportExceptionInterface
     */
    private function makeFoldingApiHttpServerRequestToEndPoint(string $endPoint)
    {
        return $this->httpClient->request(Request::METHOD_GET, $this->foldingApiUrl.$endPoint);
    }
}

<?php

namespace App\Manager;

use App\Model\FoldingTeam;
use App\Model\FoldingTeamAccount;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class FoldingApiManager
{
    private CurlHttpClient $httpClient;
    private SerializerInterface $serializer;
    private string $foldingApiUrl;
    private int $foldingTeamNumber;

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
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->httpClient = new CurlHttpClient();
    }

    /**
     * Get Folding@Home team | or negative string on API connection error
     *
     * @param int|null $id
     *
     * @return string
     */
    public function getTeamByIdNumberHttpContentResponse(?int $id = null): string
    {
        try {
            $result = $this->makeFoldingApiHttpServerRequestToEndPoint($this->getTeamIdString($id))->getContent(false);
        } catch (TransportExceptionInterface $exception) {
            $result = '-1';
        } catch (ClientExceptionInterface $e) {
            $result = '-2';
        } catch (RedirectionExceptionInterface $e) {
            $result = '-3';
        } catch (ServerExceptionInterface $e) {
            $result = '-4';
        }

        return $result;
    }

    /**
     * Get Folding@Home team object | or null on API connection error
     *
     * @param int|null $id
     *
     * @return FoldingTeam|null
     */
    public function getFoldingTeamByIdNumber(?int $id = null): ?FoldingTeam
    {
        $result = null;

        try {
            $response = $this->makeFoldingApiHttpServerRequestToEndPoint($this->getTeamIdString($id))->getContent(false);
            $result = new FoldingTeam();
            $this->serializer->deserialize(
                $response,
                FoldingTeam::class,
                'json',
                [
                    AbstractNormalizer::OBJECT_TO_POPULATE => $result,
                ]
            );
            $accounts = $this->getFoldingTeamAccountsByTeamIdNumber($id);
            if (count($accounts) > 0) {
                /** @var FoldingTeamAccount $account */
                foreach ($accounts as $account) {
                    $result->addAccount($account);
                }
            }
        } catch (TransportExceptionInterface $exception) {
            $result = null;
        } catch (ClientExceptionInterface $e) {
            $result = null;
        } catch (RedirectionExceptionInterface $e) {
            $result = null;
        } catch (ServerExceptionInterface $e) {
            $result = null;
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
            $result = -5;
        } catch (ClientExceptionInterface $e) {
            $result = -6;
        } catch (RedirectionExceptionInterface $e) {
            $result = -7;
        } catch (ServerExceptionInterface $e) {
            $result = -8;
        }

        return $result;
    }

    /**
     * Get Folding@Home team accounts array | empty array on API connection error
     *
     * @param int|null $id
     *
     * @return array
     */
    public function getFoldingTeamAccountsByTeamIdNumber(?int $id = null): array
    {
        $result = [];

        try {
            $response = $this->makeFoldingApiHttpServerRequestToEndPoint($this->getTeamIdString($id).'/members')->toArray(false);
            /** @var array $item */
            foreach ($response as $item) {
                if (is_string($item[0]) && is_int($item[1]) && !is_null($item[2]) && is_int($item[3]) && is_int($item[4])) {
                    $account = new FoldingTeamAccount();
                    $account
                        ->setName($item[0])
                        ->setRank($item[2])
                        ->setScore($item[3])
                        ->setWus($item[4])
                    ;
                    $result[] = $account;
                }
            }
        } catch (DecodingExceptionInterface $exception) {
            $result = null;
        } catch (TransportExceptionInterface $exception) {
            $result = null;
        } catch (ClientExceptionInterface $e) {
            $result = null;
        } catch (RedirectionExceptionInterface $e) {
            $result = null;
        } catch (ServerExceptionInterface $e) {
            $result = null;
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

    /**
     * @param int|null $id
     *
     * @return string
     */
    private function getTeamIdString(?int $id = null)
    {
        $teamNumberString = (string)$this->foldingTeamNumber;
        if (!is_null($id)) {
            $teamNumberString = (string)$id;
        }

        return $teamNumberString;
    }
}

<?php

namespace App\Manager;

use App\Model\FoldingTeam;
use App\Model\FoldingTeamMemberAccount;
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

class FoldingTeamsApiManager
{
    private CurlHttpClient $httpClient;
    private SerializerInterface $serializer;
    private string $foldingApiUrl;
    private int $foldingTeamNumber;

    /**
     * Constructor.
     */
    public function __construct(string $foldingApiUrl, int $foldingTeamNumber)
    {
        $this->foldingApiUrl = $foldingApiUrl.'team/';
        $this->foldingTeamNumber = $foldingTeamNumber;
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->httpClient = new CurlHttpClient();
    }

    public function getFoldingTeamNumber(): int
    {
        return $this->foldingTeamNumber;
    }

    /**
     * Get Folding@Home current total teams amount | negative number on API connection error.
     */
    public function getCurrentTotalTeams(): int
    {
        try {
            $result = intval($this->makeFoldingApiHttpServerRequestToEndPoint('count')->getContent());
        } catch (TransportExceptionInterface $exception) {
            $result = -1;
        } catch (ClientExceptionInterface $e) {
            $result = -2;
        } catch (RedirectionExceptionInterface $e) {
            $result = -3;
        } catch (ServerExceptionInterface $e) {
            $result = -4;
        }

        return $result;
    }

    /**
     * Get Folding@Home team HTTP content response.
     *
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getFoldingTeamByIdHttpContentResponse(?int $id = null): string
    {
        return $this->makeFoldingApiHttpServerRequestToEndPoint($this->getTeamIdString($id))->getContent(false);
    }

    /**
     * Get Folding@Home team object | null on API connection error.
     */
    public function getFoldingTeamById(?int $id = null): ?FoldingTeam
    {
        $result = null;
        try {
            $response = $this->getFoldingTeamByIdHttpContentResponse($this->getTeamIdString($id));
            $result = new FoldingTeam();
            $this->serializer->deserialize(
                $response,
                FoldingTeam::class,
                'json',
                [
                    AbstractNormalizer::OBJECT_TO_POPULATE => $result,
                ]
            );
            $teamMemberAccounts = $this->getFoldingTeamMemberAccountsByTeamId($this->getTeamIdString($id));
            if (count($teamMemberAccounts) > 0) {
                /** @var FoldingTeamMemberAccount $teamMemberAccount */
                foreach ($teamMemberAccounts as $teamMemberAccount) {
                    $result->addMemberAccount($teamMemberAccount);
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
     * Get Folding@Home team accounts array HTTP content response.
     *
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws DecodingExceptionInterface
     */
    public function getFoldingTeamMemberAccountsByTeamIdHttpContentResponse(?int $id = null): array
    {
        return $this->makeFoldingApiHttpServerRequestToEndPoint($this->getTeamIdString($id).'/members')->toArray(false);
    }

    /**
     * Get Folding@Home team accounts array | empty array on API connection error.
     */
    public function getFoldingTeamMemberAccountsByTeamId(?int $id = null): array
    {
        $result = [];
        try {
            $response = $this->getFoldingTeamMemberAccountsByTeamIdHttpContentResponse($this->getTeamIdString($id));
            /** @var array $item */
            foreach ($response as $item) {
                if (is_string($item[0]) && is_int($item[1]) && (is_null($item[2]) || is_int($item[2])) && is_int($item[3]) && is_int($item[4])) {
                    $teamMemberAccount = new FoldingTeamMemberAccount();
                    $teamMemberAccount
                        ->setName($item[0])
                        ->setId($item[1])
                        ->setRank($item[2])
                        ->setScore($item[3])
                        ->setWus($item[4]);
                    $result[] = $teamMemberAccount;
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
     * @return ResponseInterface
     *
     * @throws TransportExceptionInterface
     */
    private function makeFoldingApiHttpServerRequestToEndPoint(string $endPoint)
    {
        return $this->httpClient->request(Request::METHOD_GET, $this->foldingApiUrl.$endPoint);
    }

    /**
     * @return string
     */
    private function getTeamIdString(?int $id = null)
    {
        $teamNumberString = (string) $this->foldingTeamNumber;
        if (!is_null($id)) {
            $teamNumberString = (string) $id;
        }

        return $teamNumberString;
    }
}

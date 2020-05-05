<?php

namespace App\Manager;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class FoldingUsersApiManager extends AbstractBaseFoldingApiManager
{
    /**
     * Get Folding@Home current total users (machines) amount | negative number on API connection error.
     */
    public function getCurrentTotalUsers(): int
    {
        try {
            $result = intval($this->makeFoldingApiHttpServerRequestToEndPoint('user-count')->getContent());
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
}

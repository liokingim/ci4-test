<?php
namespace App\Services;

use App\Exceptions\NetworkRequestException;
use CodeIgniter\HTTP\ResponseInterface;

class NetworkRequestService
{
    public function sendRequest(string $url): string
    {
        $client = \Config\Services::curlrequest();
        $response = $client->get($url);

        if (!$response->isOK()) {
            throw new NetworkRequestException("Request failed. Status code: {$response->getStatusCode()}");
        }

        return $response->getBody();
    }
}
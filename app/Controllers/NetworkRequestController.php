<?php
namespace App\Controllers;

use App\Exceptions\NetworkRequestException;
use App\Services\NetworkRequestService;
use CodeIgniter\Controller;

class NetworkRequestController extends Controller
{
    public function index()
    {
        $url = $this->request->getGet('url');

        if ($url === null) {
            return $this->fail("URL parameter is required", 400);
        }

        $networkRequestService = new NetworkRequestService();
        try {
            $content = $networkRequestService->sendRequest($url);
        } catch (NetworkRequestException $e) {
            return $this->fail($e->getMessage(), 500);
        }

        return $this->respond($content);
    }
}
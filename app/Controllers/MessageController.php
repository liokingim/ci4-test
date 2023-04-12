<?php
namespace App\Controllers;

use App\Services\MessageInterface;
use CodeIgniter\Controller;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageInterface $messageService)
    {
        $this->messageService = $messageService;
    }

    public function index()
    {
        $message = $this->messageService->getMessage();
        return view('message', ['message' => $message]);
    }
}
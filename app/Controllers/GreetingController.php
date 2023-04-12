<?php
namespace App\Controllers;

use App\Services\GreetingService;
use CodeIgniter\Controller;

class GreetingController extends Controller
{
    protected $greetingService;

    public function __construct(GreetingService $greetingService)
    {
        $this->greetingService = $greetingService;
    }

    public function greet(string $name)
    {
        $greeting = $this->greetingService->greet($name);
        return view('greet', ['greeting' => $greeting]);
    }
}
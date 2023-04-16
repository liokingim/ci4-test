<?php
namespace App\Controllers;

use App\Libraries\Session\SessionReader;
use CodeIgniter\Controller;

class HomeController extends Controller {

    public function index() {
        $sessionReader = new SessionReader(session());

        if ($sessionReader->isLoggedIn()) {
            $data['user'] = $sessionReader->getUser();
            return view('home/logged_in', $data);
        } else {
            return view('home/guest');
        }
    }
}
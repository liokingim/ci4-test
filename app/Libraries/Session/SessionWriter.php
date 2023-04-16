<?php
namespace App\Libraries\Session;

use CodeIgniter\Session\SessionInterface;

class SessionWriter
{
    protected $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function setUser($user)
    {
        $this->session->set('user', $user);
    }

    public function removeUser()
    {
        $this->session->remove('user');
    }
}
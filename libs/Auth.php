<?php

class Auth
{

    private $session;
    private $config;

    public function __construct($session, $config)
    {
        $this->session = $session;
        $this->config = $config;
    }

    public function connect($user)
    {
        $this->session->write('auth', $user);
        return true;
    }

    public function login($email, $password)
    {
        foreach ($this->config->get("users") as $user) {
            if ($user->email == $email && password_verify($password, $user->password))
                return $this->connect($user);
        }
        return false;
    }

    public function logout()
    {
        $this->session->delete('auth');
    }

    public function isConnected()
    {
        return $this->session->read('auth') != null;
    }

    public function isKey($key)
    {
        return $this->config->get("key") == $key;
    }
}
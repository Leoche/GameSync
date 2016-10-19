<?php

class Config
{
    private $config = array();
    private $default = array(
        "users" => array(),
        "online" => true,
        "whitelist" => array(
            "launcher.settings",
            "database/*",
            "hats/*",
            "logs/*",
            "resourcepacks/*",
            "saves/*"
        )
    );
    private $file_url = "./config/options.json";
    private $initialized = false;

    public function __construct()
    {
        if (is_file($this->file_url)) {
            $this->initialized = true;
            $this->config = json_decode(file_get_contents($this->file_url));
        }
    }

    public function init($email, $password)
    {
        $this->default["id"] = $this->generate_key_string();
        $this->default["users"][] = array(
            "email" => $email,
            "password" => password_hash($password, PASSWORD_BCRYPT)
        );
        $this->config = $this->default;
        $this->save();
        return true;
    }

    public function changePassword($newpassword)
    {
        $this->config->users[0]->password = password_hash($newpassword, PASSWORD_BCRYPT);
        $this->save();
        return true;
    }

    public function isInitialized()
    {
        return $this->initialized;
    }

    public function save()
    {
        error_reporting(0);
        file_put_contents($this->file_url, json_encode($this->config)) or die(json_encode(array("code" => "401")));
    }

    public function get($key)
    {
        return $this->config->$key;
    }

    public function getJSON()
    {
        return json_encode($this->config);
    }

    public function set($key, $value)
    {
        $this->config->$key = $value;
        $this->save();
    }

    public function webroot()
    {
        return "./template/";
    }

    public function generate_key_string()
    {
        $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $segment_chars = 5;
        $num_segments = 4;
        $key_string = '';

        for ($i = 0; $i < $num_segments; $i++) {
            $segment = '';
            for ($j = 0; $j < $segment_chars; $j++)
                $segment .= $tokens[rand(0, 35)];
            $key_string .= $segment;
            if ($i < ($num_segments - 1))
                $key_string .= '-';
        }
        return $key_string;
    }
}
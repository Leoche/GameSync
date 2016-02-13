<?php 
class Config{
	private $config = array();
	private $default = array(
		"users" => array(),
		"online" => true,
		"whitelist" => array(
			"mods/Optifine.jar",
			"launcher.settings",
			"options.php",
			"options.php",
			"database/*",
			"hats/*",
			"logs/*",
			"resourcepacks/*",
			"saves/*"
		)
	);
	private $file_url = "./config/options.json";
	private $initialized = false;
    static $instance;
    static function getInstance(){
        if(!self::$instance){
            self::$instance = new Config();
        }
        return self::$instance;
    }
    public function __construct(){
    	if(is_file($this->file_url)){
    		$this->initialized = true;
			$this->config = json_decode(file_get_contents($this->file_url));
    	}
    }
    public function init($email,$password){
		$this->default["id"] = $this->generate_key_string();
		$this->default["users"][] = array(
			"email"=>$email,
			"password"=>hash("SHA256",$password)
		);
		$this->config = $this->default;
		$this->save();
		return true;
    }
    public function isInitialized(){
    	return $this->initialized;
    }
	public function save(){
		if(!file_put_contents($this->file_url, json_encode($this->config)))
			throw new ConfigException("Can't write config.json, make sure /config/ is writable");
	}
	public function get($key){
		return $this->config->$key;
	}
	public function getJSON(){
		return json_encode($this->config);
	}
	public function set($key,$value){
		$this->config->$key = $value;
		$this->save();
	}
	public function webroot(){
		return "./template/";
	}
	public function generate_key_string() {
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
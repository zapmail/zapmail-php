<?php

  namespace Zapmail;

  class Client {
    const API_ENDPOINT = "https://zapmail.io/api/v1/verify";
    
    protected   $access_token, $curl, $error, $response, $headers, $info;
    
    public function __construct($access_token) {
      $this->access_token = $access_token;
    }
    
    public function verify($email_address, $options = array()) {
      return $this->_request(array_merge(array('email' => $email_address, 'timeout' => 6000), $options));
    }
    
    // Accessor
    public function headers($name = null) {
      if (trim($name) && array_key_exists($name, $this->headers)) return $this->headers[$name];
      return $this->headers;
    }
    
    // Accessor
    public function response($name = null) {
      if (trim($name) && array_key_exists($name, $this->response)) return $this->response[$name];
      return $this->response;
    }
    
    public function getErrorCode() {
      return trim($this->error) ? $this->error : false;
    }
    
    protected function _request($options = array()) {
      if (!isset($this->curl)) $this->curl = curl_init();
      
      curl_setopt($this->curl, CURLOPT_URL, static::API_ENDPOINT . '?' . http_build_query(array_merge($options, array('token' => $this->access_token))));
      curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($this->curl, CURLOPT_HEADER, 0);
      curl_setopt($this->curl, CURLOPT_HEADERFUNCTION, array(&$this, '_parse_header'));
      
      $this->headers  = array();
      $this->response = json_decode(curl_exec($this->curl), true);
      $this->info     = curl_getinfo($this->curl);
      
      if ($this->info['http_code'] != 200) {
        $this->error = $this->info['http_code'];
        return false;
      }
      
      return $this->response;
    }
    
    public function _parse_header($curl, $header_line) {
      $e = array_map(function($e) { return trim($e); }, explode(':', trim($header_line), 2));
      if ($x = strtolower($e[0])) $this->headers[$x] = $e[1];
      return strlen($header_line);
    }
  }
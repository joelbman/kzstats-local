<?php

  abstract class BaseApi {

    private $error = '';
    private $status = 200;

    protected $args = [];
    protected $endpoint = '';

    public function __construct($request) {
      $this->args = explode('/', $request);
      $this->endpoint = preg_replace('/[^a-zA-Z0-9]+/', '', array_shift($this->args));
    }

    protected function _response($data = []) {
      if ($data === null)
        $this->_error('Unknown endpoint', 404);

      if ($this->error) {
        http_response_code($this->status);
        echo json_encode(array('error' => $this->error));
      }
      else
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    protected function _error($msg, $status = 400) {
      $this->error = $msg;
      $this->status = $status;
    }

    public function _process() {
      if (method_exists($this, $this->endpoint))
        return $this->_response($this->{$this->endpoint}());
      else
        $this->_error('Unknown endpoint', 404); 
    }

  }
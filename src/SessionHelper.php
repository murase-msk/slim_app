<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/09/12
 * Time: 20:11
 */

namespace src;

class SessionHelper
{

    public $session;

    public function __construct()
    {
        $this->session = [];
    }

    public function get($key, $default = null)
    {
        $this->presetSession();
        return $this->exists($key) ? $this->session[$key] : $default;
    }

    public function set($key, $value){
        $this->presetSession();
        $this->session[$key] = $value;
        $this->afterSetSession();
    }

    public function delete($key)
    {
        $this->presetSession();
        if ($this->exists($key)) {
            unset($this->session[$key]);
        }
        $this->afterSetSession();
    }
    public function clear()
    {
        $this->presetSession();
        $this->session = [];
        $this->afterSetSession();
    }
    private function exists($key){
        return array_key_exists($key, $this->session);
    }

    private function presetSession()
    {
        if (isset($_SESSION)) {
            $this->session = $_SESSION;
        }
    }
    private function afterSetSession()
    {
        if (isset($_SESSION)) {
            $_SESSION = $this->session;
        }
    }
}
<?php
namespace CompleteSolar\MVC;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ControllerBase{
    protected $db = null;
    protected $log;

    /**
     * Constructor
     *
     * @param  StsConfig $stsConfig
     * @param  StsDb $stsdb
     * @return StsController
     */
    public function __construct($db = null) {
        $this->db = $db;
        $this->log = new Logger(get_class($this));
        // Default handler
        $this->log->pushHandler(new StreamHandler(get_class($this).'log', Logger::ERROR));
    }

    public function pushLogHandler($handler){
        $this->log->pushHandler($handler);
    }
}
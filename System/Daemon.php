<?php

namespace Denofi\DaemonBundle\System;

use Denofi\DaemonBundle\System\SystemDaemon;
use Denofi\DaemonBundle\Handlers\DaemonHandler;
use Denofi\DaemonBundle\Handlers\TimedDaemonHandler;
use Denofi\DaemonBundle\System\Daemon\Exception as DenofiDaemonBundleException;

/**
 * Daemon is a php5 wrapper class for the PEAR library System_Daemon
 *
 * @category  Denofi
 * @package   DaemonBundle
 * @author    Jesse Greathouse <jesse.greathouse@gmail.com>
 * @author    Trent Thacker <trent@unchartedcoffee.com>
 * @copyright 2011 CodeMeme (https://github.com/organizations/CodeMeme)
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
 * @link      https://github.com/CodeMeme/CodeMemeDaemonBundle
 */
class Daemon
{
    private $_config = array();
    private $_pid;
    private $_interval;
    private $_handler;
    
    public function __construct(array $options, DaemonHandler $handler = null, $interval = 2)
    {
        if (!empty($options)) {
            $options = $this->validateOptions($options);
            $this->setConfig($options);
        } else {
            throw new DenofiDaemonBundleException('Daemon instantiated without a config');
        }

        if ($handler != null)
            $this->_handler = $handler;
        else
            $this->_handler = new TimedDaemonHandler();

        $this->_interval = $interval;
    }

    public function setHandler(DaemonHandler $handler)
    {
        $this->_handler = $handler;
    }

    private function validateOptions($options)
    {
        if (null === ($options['appRunAsUID'])) {
            throw new DenofiDaemonBundleException('Daemon instantiated without user or group');
        }
            
        if (!isset($options['appRunAsGID'])) {
            try {
                $user = posix_getpwuid($options['appRunAsUID']);
                $options['appRunAsGID'] = $user['gid'];
            } catch (DenofiDaemonBundleException $e) {
                echo 'Exception caught: ',  $e->getMessage(), "\n";
            }
        }
        
        return $options;
    }
    
    public function setConfig($config)
    {
        $this->_config = $config;
    }
    
    public function getPid()
    {
        if (file_exists($this->_config['appPidLocation'])) {
            $fh = fopen($this->_config['appPidLocation'], "r");
            $pid = fread($fh, filesize($this->_config['appPidLocation']));
            fclose($fh);
            return trim($pid);
        } else {
            return null;
        }
    }
    
    public function setPid($pid)
    {
        $this->_pid = $pid;
    }
    
    public function setInterval($interval)
    {
        $this->_interval = $interval;
    }
    
    public function getInterval()
    {
        return $this->_interval;
    }
    
    public function getConfig()
    {
        return $this->_config;
    }
    
    public function start()
    {
        SystemDaemon::setOptions($this->getConfig());
        SystemDaemon::setHandler($this->_handler);
        SystemDaemon::setInterval($this->_interval);
        
        SystemDaemon::start();
        
        $this->setPid($this->getPid());
    }
    
    public function reStart()
    {
        if ($this->isRunning()) {
            $pid = $this->getPid();

            $this->stop();

            exec("ps ax | awk '{print $1}'", $pids);
            while(in_array($pid, $pids, true)) {
                unset($pids);
                sleep(1);
                exec("ps ax | awk '{print $1}'", $pids);
            }

            SystemDaemon::info('{appName} System Daemon flagged for restart.');
        }
        else {
            SystemDaemon::info('{appName} daemon not found. Skipping shutdown.');
        }

        SystemDaemon::setHandler($this->_handler);
        $this->start();
    }
    
    public function iterate($sec) {
        SystemDaemon::iterate($sec);
    }
    
    public function isRunning() 
    {
        SystemDaemon::setOptions($this->getConfig());
        return !SystemDaemon::isDying() && SystemDaemon::isRunning();
    }
    
    public function stop()
    {
        SystemDaemon::setOptions($this->getConfig());
        SystemDaemon::stop();
    }
}

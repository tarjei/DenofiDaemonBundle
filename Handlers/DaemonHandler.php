<?php

namespace Denofi\DaemonBundle\Handlers;

use Denofi\DaemonBundle\System\SystemDaemon;
/**
 * Abstract class that can be derived to create a class that
 * can be run by a System Daemon.
 *
 * @author Trent Thacker <trent@unchartedcoffee.com>
 */
abstract class DaemonHandler
{
    /**
     * Logging shortcut, will log as an
     * 'emerg' to the Daemon's log file.
     *
     * @return boolean
     */
    protected final function emerg($message)
    {
        return SystemDaemon::emerg($message);
    }

    /**
     * Logging shortcut, will log as an
     * 'crit' to the Daemon's log file.
     *
     * @return boolean
     */
    protected final function crit($message)
    {
        return SystemDaemon::crit($message);
    }

    /**
     * Logging shortcut, will log as an
     * 'err' to the Daemon's log file.
     *
     * @return boolean
     */
    protected final function err($message)
    {
        return SystemDaemon::err($message);
    }

    /**
     * Logging shortcut, will log as an
     * 'warning' to the Daemon's log file.
     *
     * @return boolean
     */
    protected final function warning($message)
    {
        return SystemDaemon::warning($message);
    }

    /**
     * Logging shortcut, will log as an
     * 'notice' to the Daemon's log file.
     *
     * @return boolean
     */
    protected final function notice($message)
    {
        return SystemDaemon::notice($message);
    }

    /**
     * Logging shortcut, will log as an
     * 'info' to the Daemon's log file.
     *
     * @return boolean
     */
    protected final function info($message)
    {
        return SystemDaemon::info($message);
    }

    /**
     * Logging shortcut, will log as an
     * 'debug' to the Daemon's log file.
     *
     * @return boolean
     */
    protected final function debug($message)
    {
        return SystemDaemon::debug($message);
    }

    /**
     * Method run by the daemon.
     */
    abstract function start();

    /**
     * Method run by the start method.
     */
    abstract function run();
}

<?php

namespace Denofi\DaemonBundle\System;

/**
 * Class to derive from for creating a class that can be run
 * by a System Daemon.
 *
 * @author Trent Thacker <trent@unchartedcoffee.com>
 */
class DaemonHandler
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
     * Method run by the daemon. Should be overwritten by a child class or the
     * daemon will be stuck doing nothing for all eternity...Muhahahahha.
     *
     * Unless that's the goal, of course, cruel person you.
     * Daemons have feelings too, you know. :-P
     */
    public function run()
    {
        //Do nothing
    }
}

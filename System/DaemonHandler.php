<?php

namespace Denofi\DaemonBundle\System;

/**
 * DaemonHandlerInterface should be implemented by classes that what to be run
 * by a System Daemon.
 *
 * @author Trent Thacker <trent@unchartedcoffee.com>
 *
 * @api
 */
class DaemonHandler
{
    /**
     * Runs the handler
     */
    public function run()
    {
        //Do nothing
    }
}

<?php

namespace Denofi\DaemonBundle\Handlers;

use Denofi\DaemonBundle\System\SystemDaemon;
/**
 * Class that can be derived to create a class that can be run
 * by a System Daemon that execute a time delayed loop.
 * .
 *
 * @author Trent Thacker <trent@unchartedcoffee.com>
 */
class TimedDaemonHandler extends DaemonHandler
{
    /**
     * Method run by the daemon. And only by the daemon. Don't even think about
     * it buster! This method is not for you!
     */
    public final function start()
    {
        while (true) {
            $this->run();
            SystemDaemon::iterate();
        }
    }

    /**
     * Method run by the start method. Should be overwritten by child classes
     * or the daemon will be stuck doing nothing for all eternity...Muhahahahha.
     *
     * Unless that's the goal, of course, cruel person you.
     * Daemons have feelings too, you know. :-P
     */
    public function run()
    {
        //Do nothing
    }
}

<?php

namespace Denofi\DaemonBundle\System\Daemon\OS;

/**
 * A System_Daemon_OS driver for Ubuntu. Based on Debian
 *
 * @category  System
 * @package   Daemon
 * @author    Trent Thacker <trent@unchartedcoffee.com>
 * @copyright 2010 Uncharted, LLC.
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
 *
 */

use Denofi\DaemonBundle\System\Daemon\OS\RedHat;

class Amazon extends RedHat
{
    /**
     * On Linux, a distro-specific version file is often telling us enough
     *
     * @var string
     */
    protected $_osVersionFile = "/etc/system-release";

}
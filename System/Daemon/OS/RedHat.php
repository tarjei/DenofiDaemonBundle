<?php

namespace Denofi\DaemonBundle\System\Daemon\OS;

/**
 * A System_Daemon_OS driver for RedHat based Operating Systems
 *
 * @category  System
 * @package   Daemon
 * @author    Kevin van Zonneveld <kevin@vanzonneveld.net>
 * @author    Igor Feghali <ifeghali@php.net>
 * @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
 * @version   SVN: Release: $Id$
 * @link      http://trac.plutonia.nl/projects/system_daemon
 * *
 */

use Denofi\DaemonBundle\System\Daemon\OS\Linux;

class RedHat extends Linux
{
    /**
     * On Linux, a distro-specific version file is often telling us enough
     *
     * @var string
     */
    protected $_osVersionFile = "/etc/redhat-release";

    /**
     * Path of init.d scripts
     *
     * @var string
     */
    protected $_autoRunDir = '/etc/rc.d/init.d';

    /**
     * Template path
     *
     * @var string
     */
    protected $_autoRunTemplatePath = '#datadir#/template_RedHat';

    /**
     * Replace the following keys with values to convert a template into
     * a read autorun script
     *
     * @var array
     */
    protected $_autoRunTemplateReplace = array(
        "@author_name@"  => "{PROPERTIES.authorName}",
        "@author_email@" => "{PROPERTIES.authorEmail}",
        '@name@'         => '{PROPERTIES.appName}',
        '@desc@'         => '{PROPERTIES.appDescription}',
        '@bin_file@'     => '{PROPERTIES.appDir}/{PROPERTIES.appExecutable}',
        '@bin_name@'     => '{PROPERTIES.appExecutable}',
        '@pid_file@'     => '{PROPERTIES.appPidLocation}',
        '@chkconfig@'    => '{PROPERTIES.appChkConfig}',
        '@start_cmd@'    => '{PROPERTIES.appName}:{PROPERTIES.startCommand}',
    );

    public function addToSystemStartup($properties)
    {
        $message = exec("sudo /sbin/chkconfig --levels 2345 ". $properties["appName"] ." on\n");
        $result = intval(exec("echo $?"));

        if ($result) $this->errors[] = $message;

        return $result;
    }

    public function removeFromSystemStartup($properties)
    {
        exec("/sbin/chkconfig --del ". $properties["appName"] ."\n");
        $result = intval(exec("echo $?"));

        return $result;
    }

}

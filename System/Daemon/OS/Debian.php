<?php

namespace Uncharted\DaemonBundle\System\Daemon\OS;

/**
 * A System_Daemon_OS driver for Debian based Operating Systems (including Ubuntu)
 *
 * @category  System
 * @package   Daemon
 * @author    Kevin van Zonneveld <kevin@vanzonneveld.net>
 * @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
 * @version   SVN: Release: $Id$
 * @link      http://trac.plutonia.nl/projects/system_daemon
 * * 
 */

use Uncharted\DaemonBundle\System\Daemon\OS\Linux;

class Debian extends Linux
{
    /**
     * On Linux, a distro-specific version file is often telling us enough
     *
     * @var string
     */
    protected $_osVersionFile = "/etc/debian_version";
    
    /**
     * Template path
     *
     * @var string
     */
    protected $_autoRunTemplatePath = '#datadir#/template_Debian';

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
    );
    
}

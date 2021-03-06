<?php

namespace Denofi\DaemonBundle\System\Daemon\OS;

/**
 * A System_Daemon_OS driver for Linux based Operating Systems
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
 
use Denofi\DaemonBundle\System\Daemon\OS;

class Linux extends OS
{
    /**
     * On Linux, a distro-specific version file is often telling us enough
     *
     * @var string
     */
    protected $_osVersionFile = "";
    
    /**
     * Path to autoRun script
     *
     * @var string
     */
    protected $_autoRunDir = "/etc/init.d";
    
    
    
    /**
     * Determines wether the system is compatible with this OS
     *
     * @return boolean
     */
    public function isInstalled() 
    {
        if (!stristr(PHP_OS, "Linux")) {
            return false;
        }
        
        // Find out more specific
        // This is used by extended classes that inherit
        // this function
        if ($this->_osVersionFile) {
            if (!file_exists($this->_osVersionFile)) {
                return false;
            } 
        } 
        
        return true;
    }
}

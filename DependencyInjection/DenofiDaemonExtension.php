<?php

namespace Denofi\DaemonBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\Config\FileLocator;
use Denofi\DaemonBundle\System\Daemon\DaemonException;

class DenofiDaemonExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('daemon.xml');
        
        $config = $this->mergeExternalConfig($configs);
        $this->_init($config, $container);
    }
    
    private function mergeExternalConfig($config)
    {
        $mergedConfig = array();

        foreach ($config as $cnf)
        {
            $mergedConfig = array_merge($mergedConfig, $cnf);
        }
        
        return $mergedConfig;
    }
    
    private function getDefaultConfig($name, $container)
    {
        $defaults = array(
            'appName'               => $name,
            'appDir'                => $container->getParameter('kernel.root_dir'),
            'appDescription'        => 'Symfony2 System Daemon',
            'logLocation'           => $container->getParameter('kernel.logs_dir') . '/'. $name . '/' . $container->getParameter('kernel.environment'). '.' . $name . '.log',
            'authorName'            => 'Symfony2',
            'authorEmail'           => 'symfony2.kernel@127.0.0.1',
            'appPidLocation'        => $container->getParameter('kernel.cache_dir') . '/'. $name . '/' . $name . '.pid',
            'sysMaxExecutionTime'   => 0,
            'sysMaxInputTime'       => 0,
            'sysMemoryLimit'        => '1024M',
        );

        //Set the default appUser and appGroup to the version of apache that is
        //installed in their specific flavor of linux. If they want a different
        //user or group (say they are using a different webserver), they will
        //need to specify it in their daemon's configuration.
        if (function_exists('posix_getpwnam')) {
            $user  = posix_getpwnam('www-data');
            if (!$user) $user = posix_getpwnam('apache');
            if (!$user) $user = posix_getpwnam('httpd');
            if (!$user) $user = posix_getpwnam(get_current_user());
        }
        $defaults['appUser'] = $user['name'];
        $defaults['appRunAsUID'] = $user['uid'];

        if (function_exists('posix_getgrnam')) {
            $grp = posix_getgrnam('www-data');
            if (!$grp) $grp = posix_getgrnam('apache');
            if (!$grp) $grp = posix_getpwnam('httpd');
            if (!$grp) $grp = posix_getgrnam(get_current_user());
        }
        $defaults['appGroup'] = $grp['name'];
        $defaults['appRunAsGID'] = $grp['gid'];

        return $defaults;
    }

    /**
     * Merges each configured daemon with default configs and makes sure the
     * id directory is writable.
     * @param type $config
     * @param type $container
     * @return type
     */
    private function _init($config, $container)
    {
        //If there are no configuation defined, or no daemons defined within the
        //config, then we can safely skip all this. Allows for passive installs
        //of the Daemon Bundle.
        if (!$config || !$config['daemons']) return;

        foreach ($config['daemons'] as $name => $cnf)
        {
            if (NULL == $cnf)
                $cnf = array();

            //Setup appUser and appGroup and assosiated UID/GID if set my user.
            if (isset($cnf['appUser']) || isset($cnf['appGroup'])) {
                if (isset($cnf['appUser']) && function_exists('posix_getpwnam')) {
                    $user  = posix_getpwnam($cnf['appUser']);
                    if ($user) {
                        $cnf['appRunAsUID'] = $user['uid'];
                    }
                }

                if (isset($cnf['appGroup']) && function_exists('posix_getgrnam')) {
                    $group = posix_getgrnam($cnf['appGroup']);
                    if ($group) {
                        $cnf['appRunAsGID'] = $group['gid'];
                    }
                }
            }

            //Merge the defaults with the settings from the configuration.
            $cnf = array_merge($this->getDefaultConfig($name, $container), $cnf);

            //Create cache directory and set owner/group
            try {
                $pidLocation = dirname($cnf['appPidLocation']) . "/";
                $filesystem = $container->get('denofi.daemon.filesystem');

                if (!$filesystem->mkdir($pidLocation, 0777))
                    throw new \Uncharted\MainBundle\Exception\TestingException(false, "Could not create PID directory.");

                if (!file_exists($pidLocation))
                    throw new \Uncharted\MainBundle\Exception\TestingException(false, "PID directory was not created correctly.");

                @chown($pidLocation, $cnf['appUser']);
                @chgrp($pidLocation, $cnf['appGroup']);
            }
            catch (\Exception $e) {
                throw new DaemonException($e->getMessage());
            }

            //Create the log file and set owner/group
            if (!file_exists($cnf['logLocation'])) {
                if (!isdir(dirname($cnf['logLocation']))) {
                    mkdir(dirname($cnf['logLocation']));
                }
                file_put_contents($cnf['logLocation'], '');

                @chown($cnf['logLocation'], $cnf['appUser']);
                @chgrp($cnf['logLocation'], $cnf['appGroup']);
            }

            $container->setParameter($name.'.daemon.options', $cnf);
        }
    }
    
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/';
    }
}

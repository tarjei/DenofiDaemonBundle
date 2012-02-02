DenofiDaemonBundle Configuration Reference
=============================================

All available configuration options are listed below with their default values.

#### RunAs
You can run the daemon as a different user or group depending on what is best for your application.
By default it will resolve the user and group of the user who is running the daemon,
but if you want to run as a different user you can use the appUser, appGroup or appRunAsGID, appRunAsUID options.

Remember if you need to run as a different user you must start the daemon as sudo or a superuser.

To find out the group and user id of a specific user you can use the following commands.

``` bash
    johndoe@your-pc:~/$ id -u www-data
    johndoe@your-pc:~/$ id -g www-data
```


#### Full Configuration Example

There is a separate configuration for each daemon you create,
please replace _%name%_ below with the name of your daemon.

``` yaml
# app/config/config.yml

denofi_daemon:
    daemons:
        example:
            appName:                %name%
            appDir:                 %kernel.root_dir%
            appDescription:         Symfony2 System Daemon
            logLocation:            %kernel.logs_dir%/%name%/%kernel.environment%.%name%.log
            authorName:             Symfony2
            authorEmail:            symfony2.kernel@127.0.0.1
            appPidLocation:         %kernel.cache_dir%/%name%/%name%.pid
            sysMaxExecutionTime:    0
            sysMaxInputTime:        0
            sysMemoryLimit:         1024M
            appUser:                apache
            appGroup:               apache
            appRunAsGID:            33
            appRunAsUID:            33
```

Getting Started With The DenofiDaemonBundle
==============================================

DenofiDaemonBundle is a Symfony2 bundle that wraps the PEAR library
System_Daemon created by Kevin Vanzonneveld and is a fork of CodeMeme's
Daemon Bundle which can be found at:

https://github.com/CodeMeme/CodeMemeDaemonBundle

This bundle allows you to easily create System Daemons in PHP that interact
tightly with your Symfony2 project, with the added functionality of allowing
your daemons to be autostarted on a system reboot.


## Installation

Installation includes the following 3 steps:

1. Download DenofiDaemonBundle
2. Configure the Autoloader
3. Enable the Bundle


### Step 1: Download DenofiDaemonBundle

Ultimately, the DenofiDaemonBundle files should be downloaded to the
`vendor/bundles/Denofi/DaemonBundle` directory.

This can be done in several ways, depending on your preference. The first
method is the standard Symfony2 method.

**Using the vendors script**

Add the following lines in your `deps` file:

```
[DenofiDaemonBundle]
    git=git://github.com/tthacker/DenofiDaemonBundle.git
    target=bundles/Denofi/DaemonBundle
```

Now, run the vendors script to download the bundle:

``` bash
$ php bin/vendors install
```

**Using submodules**

If you prefer instead to use git submodules, the run the following:

``` bash
$ git submodule add git://github.com/tthacker/DenofiDaemonBundle.git vendor/bundles/Denofi/DaemonBundle
$ git submodule update --init
```

### Step 2: Configure the Autoloader

Add the `Denofi` namespace to your autoloader:

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'Denofi' => __DIR__.'/../vendor/bundles',
));
```

### Step 3: Enable the bundle

Finally, enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Denofi\DaemonBundle\DenofiDaemonBundle(),
    );
}
```


### Next Steps

Now that you have completed the basic installation and configuration of the
DenofiDaemonBundle, you are ready to learn about more advanced features
and usages of the bundle.

The following documents are available:

1. [Creating A Daemon](https://github.com/tthacker/DenofiDaemonBundle/blob/master/Resources/docs/creating_daemons.md)
2. [Running Daemons from the Commandline](https://github.com/tthacker/DenofiDaemonBundle/blob/master/Resources/docs/commanding_daemons.md)
3. [Configuration Reference](https://github.com/tthacker/DenofiDaemonBundle/blob/master/Resources/docs/configuration_reference.md)

Creating a new Daemon
---------------------

Start by creating a class that extends one of the abstract handler classes::

```MyDaemon.php
    use Denofi\DaemonBundle\Handlers\DaemonHandler;
    
    class MyDaemon extends DaemonHandler {
      
        public function start() {
          while(true) {
            $this->run();
            // this will make your daemon sleep between runs.
            SystemDaemon::iterate();

            clearstatcache();

            // Garbage Collection (PHP >= 5.3)
            if (function_exists('gc_collect_cycles')) {
                gc_collect_cycles();
            }
          }
        }
      
        public function run() {
          // do cool stuff here. 
        }
    }
```

Then create a simple command to start the daemon:

```src/My/DaemonBundle/Command/StartServer.php:
    
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputOption;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
    use Denofi\DaemonBundle\System\Daemon;
    
    class StartCommand extends ContainerAwareCommand
    {
        
        protected function configure()
        {   
            $this->setName('jobserver:start')
                 ->setDescription('Starts the jobserver daemon')
                 ->setHelp(<<<EOT
    The <info>{$this->getName()}</info> Run the example daemon in the background.
    EOT
            );
        }
    
        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $daemon = new Daemon($this->getContainer()->getParameter('jobserver.daemon.options'),
                    $this->getContainer()->get('my.jobserver.control')
                    );
            $daemon->start();
        }
    
    }
```

You should also create versions that call the ->stop() and ->reStart() methods. 


<?php
/**
 * ANGIE - The site restoration script for backup archives created by Akeeba Backup and Akeeba Solo
 *
 * @package   angie
 * @copyright Copyright (c)2009-2021 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

namespace Akeeba\Engine\Restore\Container;

use Akeeba\Engine\Restore\Application\Application;
use Akeeba\Engine\Restore\Dispatcher\Dispatcher;
use Akeeba\Engine\Restore\Input\Input;
use Akeeba\Engine\Restore\Pimple\Pimple;
use Akeeba\Engine\Restore\Session\Session;

defined('_AKEEBA') or die();

/**
 * Dependency injection container. Based on AWF
 *
 * @property  string                         $application_name      The name of the application
 *
 * @property-read  Application              $application           The application instance
 * @property-read  Dispatcher               $dispatcher            The application dispatcher
 * @property-read  Input                    $input                 The global application input object
 * @property-read  Session                  $session               The session manager
 */
class Container extends Pimple
{
    public function __construct(array $values = array())
    {
        parent::__construct($values);

        // Application service
        if (!isset($this['application']))
        {
            $this['application'] = function (Container $c)
            {
                return Application::getTmpInstance($c->application_name, array(), 'Angie', $c);
            };
        }

        // Input Access service
        if (!isset($this['input']))
        {
            $this['input'] = function (Container $c)
            {
                return new Input();
            };
        }

        // Application Dispatcher service
        if (!isset($this['dispatcher']))
        {
            $this['dispatcher'] = function (Container $c)
            {
                return Dispatcher::getTmpInstance(null, null, array(), $c);
            };
        }

        if(!isset($this['session']))
        {
            $this['session'] = function(Container $c){
                return Session::getInstance();
            };
        }
    }
}

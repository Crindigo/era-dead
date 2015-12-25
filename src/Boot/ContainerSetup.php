<?php
/**
 * Created by PhpStorm.
 * User: stevenh
 * Date: 12/24/15
 * Time: 11:38 PM
 */

namespace Era\Boot;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;

class ContainerSetup extends ContainerConfig
{
    public function define(Container $di)
    {
        //$di->set('era:payload_factory', $di->lazyNew(\Aura\Payload\PayloadFactory::class));
        //$di->params[\Era\Domain\Home\AppService\Home::class]['payload'] = $di->lazyGetCall('era:payload_factory', 'newInstance');

        $di->params['Era\Domain\Home\AppService\Home']['payload'] = $di->lazyNew('Aura\Payload\Payload');

        $di->set('era:twig', $di->lazyNew('Twig_Environment'));
        $di->set('era:twig-loader', $di->lazyNew('Twig_Loader_Filesystem'));
        $di->params['Era\Http\Responder\TwigResponder']['twig'] = $di->lazyGet('era:twig');

        $di->params['Twig_Environment']['loader'] = $di->lazyGet('era:twig-loader');
        $di->params['Twig_Environment']['options'] = [
            'cache' => ERA_ROOT . '/cache/twig',
            'auto_reload' => true,
        ];

        $di->params['Twig_Loader_Filesystem']['paths'] = [ERA_ROOT . '/views'];
    }

    public function modify(Container $di)
    {

    }
}
<?php
/**
 * Created by PhpStorm.
 * User: stevenh
 * Date: 12/25/15
 * Time: 2:19 AM
 */

namespace Era\Http\Responder;

use Aura\Payload_Interface\PayloadInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TwigResponder
{
    protected $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    protected function render(string $file, array $context = []) : string
    {
        return $this->twig->render($file, $context);
    }

    public function __invoke(Request $request, Response $response, PayloadInterface $payload = null) : Response
    {
        $file = $this->getTemplateFile();
        $html = $this->render($file, $payload->getOutput());

        $response->getBody()->write($html);
        return $response;
    }

    /**
     * Gets a template file based off of the responder class name. A class of "Era\User\EditProfile\Responder"
     * would become "user/editProfile.html.twig".
     *
     * @return string
     */
    protected function getTemplateFile() : string
    {
        $class = get_class($this);
        if ( $class === 'Era\Http\Responder\TwigResponder' ) {
            return 'default.html.twig';
        }

        $class = str_replace(['Era\\', '\Responder'], '', $class);
        $parts = explode('\\', $class);
        $newParts = [];
        foreach ( $parts as $part ) {
            $newParts[] = strtolower($part[0]) . substr($part, 1);
        }

        return implode(DIRECTORY_SEPARATOR, $newParts) . '.html.twig';
    }
}
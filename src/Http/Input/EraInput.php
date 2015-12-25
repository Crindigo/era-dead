<?php
/**
 * Created by PhpStorm.
 * User: stevenh
 * Date: 12/25/15
 * Time: 3:00 AM
 */

namespace Era\Http\Input;

use Psr\Http\Message\ServerRequestInterface;

class EraInput
{
    public function __invoke(ServerRequestInterface $request)
    {
        return [
            array_merge(
                (array) $request->getQueryParams(),
                (array) $request->getAttributes(),
                (array) $request->getParsedBody(),
                (array) $request->getUploadedFiles()
            )
        ];
    }
}
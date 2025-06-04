<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadServices
{
    public function __construct(
        private ParameterBagInterface $params,
    ){}

    public function upload(UploadedFile $file): string,{}
}
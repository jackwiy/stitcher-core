<?php

namespace Stitcher\Application;

use GuzzleHttp\Psr7\Response;
use Stitcher\Task\PartialParse;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class DevelopmentServer extends Server
{
    /** @var string */
    protected $rootDirectory;

    /** @var null|string */
    protected $path;

    /** @var \Stitcher\Task\PartialParse */
    protected $partialParse;

    public function __construct(
        string $rootDirectory,
        PartialParse $partialParse,
        string $path = null
    ) {
        $this->rootDirectory = $rootDirectory;
        $this->path = $path;
        $this->partialParse = $partialParse;
    }

    public static function make(
        string $rootDirectory,
        PartialParse $partialParse,
        string $path = null
    ): DevelopmentServer
    {
        return new self($rootDirectory, $partialParse, $path);
    }

    protected function handleStaticRoute(): ?Response
    {
        $path = $this->path ?? $this->getCurrentPath();

        $this->partialParse->setFilter($path);

        try {
            $this->partialParse->execute();

            $filename = ltrim($path === '/' ? 'index.html' : "{$path}.html", '/');

            $body = @file_get_contents("{$this->rootDirectory}/{$filename}");

            return $body ? new Response(200, [], $body) : null;
        } catch (ResourceNotFoundException $e) {
            return null;
        }
    }
}

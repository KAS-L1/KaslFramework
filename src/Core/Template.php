<?php

namespace Kasl\KaslFw\Core;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;

class Template
{
    protected $viewFactory;

    public function __construct()
    {
        $container = new Container;

        // Register Filesystem and Events
        $filesystem = new Filesystem();
        $container->instance('files', $filesystem);
        $container->instance('events', new Dispatcher($container));

        // Blade Compiler
        $cachePath = __DIR__ . '/../../storage/framework/cache/blade';
        $container->singleton('blade.compiler', function () use ($filesystem, $cachePath) {
            return new BladeCompiler($filesystem, $cachePath);
        });

        // Engine Resolver
        $engineResolver = new EngineResolver;
        $engineResolver->register('blade', function () use ($container) {
            return new CompilerEngine($container['blade.compiler']);
        });
        $container->instance('view.engine.resolver', $engineResolver);

        // View Finder
        $viewPath = [__DIR__ . '/../../src/View'];
        $viewFinder = new FileViewFinder($filesystem, $viewPath);
        $container->instance('view.finder', $viewFinder);

        // View Factory
        $this->viewFactory = new Factory($engineResolver, $viewFinder, $container['events']);
        $container->instance('view', $this->viewFactory);
    }

    public function render($view, $data = [])
    {
        return $this->viewFactory->make($view, $data)->render();
    }
}

<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Formatter;

use Flarum\Foundation\AbstractServiceProvider;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Container\Container;

class FormatterServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('flarum.formatter', function (Container $container) {
            return new Formatter(
                new Repository($container->make('cache.filestore')),
                $container->make('events'),
                $this->app['flarum']->storagePath().'/formatter'
            );
        });

        $this->app->alias('flarum.formatter', Formatter::class);
    }
}

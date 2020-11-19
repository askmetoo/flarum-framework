<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Discussion;

use Flarum\Database\AbstractModel;
use Flarum\Http\SlugDriverInterface;
use Flarum\User\User;

class IdWithSlugDriver implements SlugDriverInterface
{
    public function toSlug(AbstractModel $instance): string
    {
        return $instance->id.(trim($instance->slug) ? '-'.$instance->slug : '');
    }

    public function fromSlug(string $slug, User $actor): AbstractModel
    {
        if (strpos($slug, '-') == true) {
            $slug_array = explode('-', $slug);
            $slug = $slug_array[0];
        }

        return Discussion::where('id', $slug)->whereVisibleTo($actor)->firstOrFail();
    }
}
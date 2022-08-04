<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Tests\integration\extenders;

use Carbon\Carbon;
use Flarum\Extend\Link;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;

class LinkTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    public function prepDb()
    {
        $this->prepareDatabase([
            'discussions' => [
                ['id' => 1, 'title' => 'DISCUSSION 1', 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
                ['id' => 2, 'title' => 'DISCUSSION 2', 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 2, 'first_post_id' => 2, 'comment_count' => 1],
            ],
            'posts' => [
                ['id' => 1, 'discussion_id' => 1, 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 2, 'type' => 'comment', 'content' => '<t><p><r><URL url="https://google.com">google.com</URL></p></r></r></p></t>'],
            ],
            'users' => [
                $this->normalUser(),
            ],
        ]);
    }

    /**
     * @test
     */
    public function sets_rel()
    {
        $this->extend((new Link)->setRel(function () { return 'rel-test'; }));

        $response = $this->send(
            $this->request('GET', '/api/discussions/1', [
                'authenticatedAs' => $this->normalUser()['id'],
            ])->withQueryParams([
                'include' => 'firstPost'
            ])
        );

        $json = json_decode($response->getBody()->getContents(), true);
    }
}

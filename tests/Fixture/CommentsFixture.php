<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CommentsFixture
 */
class CommentsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'author' => 'Lorem ipsum dolor sit amet',
                'content' => 'Lorem ipsum dolor sit amet',
                'likes' => 1,
                'article_id' => 1,
                'created' => '2022-12-11 10:09:51',
                'modified' => '2022-12-11 10:09:51',
            ],
        ];
        parent::init();
    }
}

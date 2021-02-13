<?php

declare(strict_types=1);

namespace JeroenG\Hummingbird\Tests\Integration\Validators;

use JeroenG\Hummingbird\Domain\Validators\NoAutoplayingVideos;
use JeroenG\Hummingbird\Tests\Support\WithCollector;
use PHPUnit\Framework\TestCase;

class NoAutoplayingVideosTest extends TestCase
{
    use WithCollector;

    private NoAutoplayingVideos $validator;

    protected function setUp(): void
    {
        $this->validator = new NoAutoplayingVideos();
    }

    public function test_it_accepts_a_nice_video_not_autoplaying(): void
    {
        $parser = $this->collector()->collect(
            '<video controls><source src="movie.mp4" type="video/mp4"><source src="movie.ogg" type="video/ogg"></video>'
        );
        $result = $this->validator->validate($parser);

        self::assertTrue($result);
    }

    public function test_it_fails_for_the_annoying_autoplaying_video(): void
    {
        $parser = $this->collector()->collect(
            '<video controls autoplay><source src="movie.mp4" type="video/mp4"><source src="movie.ogg" type="video/ogg"></video>'
        );
        $result = $this->validator->validate($parser);

        self::assertFalse($result);
    }

    public function test_it_also_fails_for_autoplaying_youtube_video(): void
    {
        $parser = $this->collector()->collect(
            '<iframe src="https://www.youtube.com/embed/VIDEO_ID?autoplay=1" allow=\'autoplay\'></iframe>'
        );
        $result = $this->validator->validate($parser);

        self::assertFalse($result);
    }
}

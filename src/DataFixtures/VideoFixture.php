<?php

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Video;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class VideoFixture extends BaseFixture implements DependentFixtureInterface
{
    private $videos;

    public function __construct()
    {
        $this->videos = [
            [
                "url" => "https://www.youtube.com/embed/Br6ZJM01I6s",
                "trick" => "Trick-0"
            ],[
                "url" => "https://www.youtube.com/embed/2Ul5P-KucE8",
                "trick" => "Trick-1",
            ],[
                "url" => "https://www.youtube.com/embed/XATkSnCFsRU",
                "trick" => "Trick-3",
            ],[
                "url" => "https://www.youtube.com/embed/vquZvxGMJT0",
                "trick" => "Trick-4",
            ]
        ];
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->videos as $index => $videoData) {
            $video = new Video();

            $video->setUrl($videoData["url"]);
            $video->setTrick($this->getReference($videoData["trick"]));
            $video->setAddedAt(new \DateTime());
            $this->addReference("Video-" . $index, $video);

            $manager->persist($video);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [TrickFixture::class];
    }
}

<?php
/**
 * Task fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TaskFixtures.
 */
class TaskFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'tasks', function ($i) {
            $task = new Task();
            $task->setName($this->faker->word);
            $task->setTerm($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $task->setDescription($this->faker->sentence);
            $task->setCategory($this->getRandomReference('categories'));
            $task->setAlarm($this->getRandomReference('alarms'));
            $task->setPriority($this->getRandomReference('priorities'));
            $task->setAuthor($this->getRandomReference('users'));

            $tags = $this->getRandomReferences(
                'tags',
                $this->faker->numberBetween(0, 5)
            );

            foreach ($tags as $tag) {
                $task->addTag($tag);
            }

            return $task;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class, TagFixtures::class, UserFixtures::class, AlarmFixtures::class, PriorityFixtures::class];
    }
}

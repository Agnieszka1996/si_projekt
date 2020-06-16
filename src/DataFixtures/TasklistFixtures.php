<?php
/**
 * Tasklist fixture.
 */

namespace App\DataFixtures;

use App\Entity\Tasklist;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TasklistFixtures.
 */
class TasklistFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'tasklists', function ($i) {
            $tasklist = new Tasklist();
            $tasklist->setName($this->faker->word);
            $tasklist->setTerm($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $tasklist->setDescription($this->faker->sentence);
            $tasklist->setComment($this->faker->sentence);
            $tasklist->setCategory($this->getRandomReference('categories'));
            //$tasklist->setTasklistAlarm($this->getRandomReference('tasklistalarms'));
            //$tasklist->setTasklistPriority($this->getRandomReference('tasklistpriorities'));

            $tags = $this->getRandomReferences(
                'tags',
                $this->faker->numberBetween(0, 5)
            );

            foreach ($tags as $tag) {
                $tasklist->addTag($tag);
            }

            $tasklist->setAuthor($this->getRandomReference('users'));
            return $tasklist;
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
        return [UserFixtures::class, CategoryFixtures::class];
    }
}
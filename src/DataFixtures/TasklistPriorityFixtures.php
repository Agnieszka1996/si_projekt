<?php
/**
 * TasklistPriority fixture.
 */

namespace App\DataFixtures;

use App\Entity\TasklistPriority;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TasklistPriorityFixtures.
 */
class TasklistPriorityFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'tasklistpriorities', function ($i) {
            $tasklistpriority = new TasklistPriority();
            $tasklistpriority->setSlug($this->faker->word);
            $tasklistpriority->setName($this->faker->word);

            return $tasklistpriority;
        });

        $manager->flush();
    }
}
<?php
/**
 * TasklistAlarm fixture.
 */

namespace App\DataFixtures;

use App\Entity\TasklistAlarm;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TasklistAlarmFixtures.
 */
class TasklistAlarmFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'tasklistalarms', function ($i) {
            $tasklistalarm = new TasklistAlarm();
            $tasklistalarm->setSlug($this->faker->word);
            $tasklistalarm->setName($this->faker->word);

            return $tasklistalarm;
        });

        $manager->flush();
    }
}
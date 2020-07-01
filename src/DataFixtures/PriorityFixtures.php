<?php
/**
 * Priority fixture.
 */

namespace App\DataFixtures;

use App\Entity\Priority;
use Doctrine\Persistence\ObjectManager;

/**
 * Class PriorityFixtures.
 */
class PriorityFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(2, 'priorities', function ($i) {
            $priority = new Priority();
            if (0 == $i) {
                $priority->setName('low');
            } else {
                $priority->setName('high');
            }

            return $priority;
        });

        $manager->flush();
    }
}

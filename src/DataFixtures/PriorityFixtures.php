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
            if ($i = 1) {
                $priority->setName('low');
            } else {
                $priority->setName('high');
            }

            return $priority;
        });

        $manager->flush();
    }
}

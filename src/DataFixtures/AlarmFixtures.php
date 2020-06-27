<?php
/**
 * Alarm fixture.
 */

namespace App\DataFixtures;

use App\Entity\Alarm;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AlarmFixtures.
 */
class AlarmFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(2, 'alarms', function ($i) {
            $alarm = new Alarm();
            if ($i = 1) {
                $alarm->setName('no');
            } else {
                $alarm->setName('yes');
            }

            return $alarm;
        });

        $manager->flush();
    }
}

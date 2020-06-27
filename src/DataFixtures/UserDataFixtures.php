<?php
/**
 * UserData fixtures.
 */

namespace App\DataFixtures;

use App\Entity\UserData;
use Doctrine\Persistence\ObjectManager;

/**
 * Class UserDataFixtures.
 */
class UserDataFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'usersData', function ($i) {
            $usersData = new UserData();
            $usersData->setNick($this->faker->word);
            $usersData->setFirstname($this->faker->word);
            $usersData->setSurname($this->faker->word);
            $usersData->setBio($this->faker->sentence);

            return $usersData;
        });

        $this->createMany(3, 'usersDataAdmin', function ($i) {
            $usersData = new UserData();
            $usersData->setNick($this->faker->word);
            $usersData->setFirstname($this->faker->word);
            $usersData->setSurname($this->faker->word);
            $usersData->setBio($this->faker->sentence);

            return $usersData;
        });

        $manager->flush();
    }
}

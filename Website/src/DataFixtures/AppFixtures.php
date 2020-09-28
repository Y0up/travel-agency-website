<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Tour;
use App\Entity\Image;
use App\Entity\Activity;
use App\Entity\Agencies;
use App\Entity\Booking;
use App\Entity\Comment;
use App\Entity\Incl;
use App\Entity\Requ;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('Fr-fr');

        //gerer les roles
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $genres = ['male', 'female'];

        $birth = $faker->dateTime();
        $phoneNumber = $faker->tollFreePhoneNumber();
        $adresse = $faker->address();
        $country = $faker->country();

        $genre = $faker->randomElement($genres);

        $picture = 'https://randomuser.me/api/portraits/';
        $pictureId = $faker->numberBetween(1, 99) . '.jpg';

        $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

        $adminUser = new User();
        $adminUser->setFirstName('Alexis')
            ->setLastName('D\'angelo')
            ->setEmail('us80@hotmail.fr')
            ->setHash($this->encoder->encodePassword($adminUser, 'y0up1land'))
            ->addUserRole($adminRole)
            ->setBirth($birth)
            ->setPhoneNumber($phoneNumber)
            ->setPicture($picture)
            ->setAdresse($adresse)
            ->setCountry($country);

        $manager->persist($adminUser);

        // gerer les inclus
        for ($i = 0; $i <= 9; $i++) {
            $incl = new Incl();

            $incl->setTitle($faker->word(1));

            $manager->persist($incl);
        }

        // gerer les requis
        for ($i = 0; $i <= 9; $i++) {
            $requ = new Requ();

            $requ->setTitle($faker->word(1));

            $manager->persist($requ);
        }

        // gerer les user
        $users = [];
        $genres = ['male', 'female'];

        for ($i = 0; $i <= 9; $i++) {
            $user = new User();

            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            $hash = $this->encoder->encodePassword($user, 'password');

            $birth = $faker->dateTime();
            $phoneNumber = $faker->tollFreePhoneNumber();
            $adresse = $faker->address();
            $country = $faker->country();

            $user->setFirstName($faker->firstname)
                ->setLastName($faker->lastname)
                ->setEmail($faker->email)
                ->setHash($hash)
                ->setPicture($picture)
                ->setBirth($birth)
                ->setPhoneNumber($phoneNumber)
                ->setAdresse($adresse)
                ->setCountry($country);

            $manager->persist($user);
            $users[] = $user;
        }

        // gerer les tours

        for ($i = 0; $i <= 2; $i++) {
            $tour = new Tour();

            $title = $faker->sentence(3);
            $coverImage = $faker->imageUrl(1000, 350);
            $description = $faker->paragraph(2);
            $category = $faker->word(1);

            $tour->setTitle($title)
                ->setCategory($category)
                ->setCoverImage($coverImage)
                ->setPrice(mt_rand(50000, 300000))
                ->setDescription($description)
                ->addIncl($incl);

            // gestion des images dans tour

            for ($j = 0; $j <= 2; $j++) {
                $image = new Image();

                $image->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setTour($tour);

                $manager->persist($image);
            }


            $manager->persist($tour);
        }

        // gerer les activitees

        for ($i = 0; $i <= 30; $i++) {
            $activity = new Activity();

            $title = $faker->sentence(3);
            $coverImage = $faker->imageUrl(1000, 850);
            $description = $faker->paragraph(5);
            $category = $faker->word(1);
            $content = $faker->paragraph(20);

            $activity->setTitle($title)
                ->setCategory($category)
                ->setCoverImage($coverImage)
                ->setPrice(mt_rand(50000, 300000))
                ->setDescription($description)
                ->setContent($content);

            // gestion des images dans activitees

            for ($j = 0; $j <= 8; $j++) {
                $image = new Image();


                $image->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setActivity($activity);

                $activity->addIncl($incl);

                $manager->persist($image);
            }

            // gestion des reservations

            for ($j = 0; $j <= mt_rand(0, 10); $j++) {
                $booking = new Booking();

                $createdAt = $faker->dateTimeBetween('-6 months');
                $startDate = $faker->dateTimeBetween('-3 months');

                $duration = mt_rand(3, 10);

                $endDate = (clone $startDate)->modify("+$duration days");
                $amount = $activity->getPrice();
                $booker = $users[mt_rand(0, count($users) - 1)];
                $comment = $faker->paragraph();

                $booking->setBooker($booker)
                    ->setActivity($activity)
                    ->setStartDate($startDate)
                    ->setEndDate($endDate)
                    ->setCreatedAt($createdAt)
                    ->setAmount($amount)
                    ->setComment($comment);

                $manager->persist($booking);

                // gerer les commentaires

                if (mt_rand(0, 1)) {
                    $comment = new Comment();
                    $comment->setContent($faker->paragraph())
                        ->setRating(mt_rand(1, 5))
                        ->setAuthor($booker)
                        ->setActivity($activity);

                    $manager->persist($comment);
                }
            }

            $manager->persist($activity);
        }



        // gerer les agences

        for ($i = 0; $i <= 5; $i++) {
            $agencies = new Agencies();

            $name = $faker->sentence(2);
            $logo = $faker->imageUrl(1000, 850);
            $description = $faker->paragraph(5);
            $url = $faker->url;

            $agencies->setName($name)
                ->setLogo($logo)
                ->setUrl($url)
                ->setDescription($description);


            $manager->persist($agencies);
        }


        $manager->flush();
    }
}

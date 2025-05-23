<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr-FR');

        // Récupération des utilisateurs nouvellement créés
        $users = [];
        for ($i = 0; $i < 100; $i++) {
            $users[] = $this->getReference('USER' . $i, User::class);
        }

        // Récupération des articles nouvellement créés
        $articles = [];
        for ($i = 0; $i < 300; $i++) {
            $articles[] = $this->getReference('ARTICLE_' . $i, Article::class);
        }

        foreach ($articles as $article) {
            $count = $faker->numberBetween(0, 10);

            for ($i = 0; $i < $count; $i++) {
                $comment = new Comment();
                $comment
                    ->setAuthor($faker->randomElement($users))
                    ->setContent($faker->sentence())
                    ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', 'now')))
                    ->setIsModerated($faker->boolean(20))
                    ->setIsPublished($faker->boolean(5))
                    ->setArticle($article)
                ;
                $manager->persist($comment);
                $this->setReference('COMMENT' . $i, $comment);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ArticleFixtures::class, UserFixtures::class];
    }
}
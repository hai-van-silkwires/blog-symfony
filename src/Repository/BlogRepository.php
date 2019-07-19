<?php

namespace App\Repository;

use App\Entity\Blog;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Blog::class);
    }

    // /**
    //  * @return Blog[] Returns an array of Blog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Blog
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Get detail blog with id
     *
     * @return blog
     */
    public function getDetailBlogById($id)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.id = ' . $id)
            ->andWhere('b.status = 0')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * Get all blogs
     *
     * @return Object Blog
     */
    public function getBlogByCategoryId($categoryId)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.category_id = :categoryId')
            ->setParameter('categoryId', $categoryId)
            ->getQuery()
            ->getArrayResult();
    }

    public function getListBlogs()
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.status = :status')
            ->setParameter('status', 0)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * Insert a new blog
     *
     * @param array $data Request data from web screen
     *
     * @return array Status and message after inserting
     */
    public function insert($data)
    {
        try {
            $blog            = new Blog();
            $data->createdAt = new \DateTime();
            $data->updatedAt = new \DateTime();

            foreach ($data as $key => $value) {
                $setterFunction = 'set' . ucfirst($key);
                if (method_exists($blog, $setterFunction)) {
                    $blog->$setterFunction($value);
                }
            }

            $entityManager = $this->getEntityManager();
            $entityManager->persist($blog);
            $entityManager->flush();

            return [
                'success' => true,
                'message' => 'Insert successfully'
            ];
        } catch (\Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

    /**
     * Update a blog
     *
     * @param integer $id   Blog id
     * @param array   $data Request data from web screen
     *
     * @return array Status and message after updating
     */
    public function update($data, $id)
    {
        $blog = $this->findOneBy(array('id' => $id));

        try {
            $data->updatedAt = new \DateTime();

            foreach ($data as $key => $value) {
                $setterFunction = 'set' . ucfirst($key);
                if (method_exists($blog, $setterFunction)) {
                    $blog->$setterFunction($value);
                }
            }

            $entityManager = $this->getEntityManager();
            $entityManager->persist($blog);
            $entityManager->flush();

            return [
                'success' => true,
                'message' => 'Update successfully'
            ];
        } catch (\Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

    /**
     * Remove a blog
     *
     * @param integer $id Blog id
     *
     * @return array Status and message after removing
     */
    public function delete($id)
    {
        $blog = $this->findOneBy(array('id' => $id));
        $blog->setStatus(1);

        try {
            $entityManager = $this->getEntityManager();
            $entityManager->persist($blog);
            $entityManager->flush();

            return [
                'success' => true,
                'message' => 'Blog with id ' . $id . ' is deleted'
            ];
        } catch (\Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }
}

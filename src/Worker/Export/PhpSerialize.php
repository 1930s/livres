<?php
/**
 * @author  MacFJA
 * @license MIT
 */
namespace App\Worker\Export;

use App\Entity\Book;
use App\Worker\Entity\BookInjectionListener;
use Doctrine\ORM\EntityManagerInterface;

class PhpSerialize implements ExportInterface
{
    /** @var  EntityManagerInterface */
    protected $entityManager;
    /**
     * @var BookInjectionListener
     */
    private $bookInjectionListener;

    /**
     * PhpSerialize constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param BookInjectionListener  $bookInjectionListener
     */
    public function __construct(EntityManagerInterface $entityManager, BookInjectionListener $bookInjectionListener)
    {
        $this->entityManager = $entityManager;
        $this->bookInjectionListener = $bookInjectionListener;
    }

    /**
     * {@inheritDoc}
     */
    public function export(string $output)
    {
        $this->bookInjectionListener->setDisableCoverInjection(true);
        $books = $this->entityManager->getRepository(Book::class)->findAll();
        file_put_contents($output, serialize($books));
    }

    public function getName(): string
    {
        return 'PHP Serialization';
    }

    public function getFormatCode(): string
    {
        return 'php';
    }
}

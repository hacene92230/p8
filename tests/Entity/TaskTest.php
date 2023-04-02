<?php


namespace App\Tests\Entity;


use App\Entity\Task;
use App\Entity\User;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTest extends WebTestCase
{
    private $task;

    public function setUp(): void
    {
        $this->task = new Task();
    }

    public function testId(): void
    {
        $this->assertNull($this->task->getId());
    }

    public function testTitle()
    {
        $this->task->setTitle('title');
        $this->assertSame('title', $this->task->getTitle());
    }

    public function testContent()
    {
        $this->task->setContent('content');
        $this->assertSame('content', $this->task->getContent());
    }

    public function testSetIsDone()
    {
        $this->task->setIsDone(true);
        $this->task->toggle(true);
        $this->assertSame(true, $this->task->IsDone());
            }

    public function testCreatedAt()
    {
        $date = new DateTimeImmutable();
        $this->task->setCreatedAt($date);
        $this->assertSame($date, $this->task->getCreatedAt());
    }

    public function testUser()
    {
        $this->task->setUser(new User());
        $this->assertInstanceOf(User::class, $this->task->getUser());
    }

}

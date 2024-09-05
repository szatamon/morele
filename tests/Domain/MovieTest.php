<?php

namespace App\Tests\Domain;

use App\Domain\Movie;
use PHPUnit\Framework\TestCase;

class MovieTest extends TestCase
{
    public function testGetTitle(): void
    {
        $movie = new Movie('The Matrix');
        
        $this->assertSame('The Matrix', $movie->getTitle());
    }

    public function testGetTitleLength(): void
    {
        $movie = new Movie('Avatar');
        
        $this->assertSame(6, $movie->getTitleLength());
    }

    public function testGetTitleLengthEmptyTitle(): void
    {
        $movie = new Movie('');
        
        $this->assertSame(0, $movie->getTitleLength());
    }

    public function testIsMultiWordTitleTrue(): void
    {
        $movie = new Movie('The Matrix');
        
        $this->assertTrue($movie->isMultiWordTitle());
    }

    public function testIsMultiWordTitleFalse(): void
    {
        $movie = new Movie('Avatar');
        
        $this->assertFalse($movie->isMultiWordTitle());
    }

    public function testIsMultiWordTitleEmptyTitle(): void
    {
        $movie = new Movie('');
        
        $this->assertFalse($movie->isMultiWordTitle());
    }

}
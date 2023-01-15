<?php

namespace App\Models;

class Book
{
    private string $title;
    private float $price;
    private string $bookshop;

    public function __construct(string $title, float $price, string $bookshop)
    {
        $this->title = $title;
        $this->price = $price;
        $this->bookshop = $bookshop;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getBookshop(): string
    {
        return $this->bookshop;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'price' => $this->price,
            'bookshop' => $this->bookshop,
        ];
    }
}

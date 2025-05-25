<?php

namespace App\DTO;

class GeminiRequest
{
    private string $model;
    private array $messages;
    private int $maxOutputTokens;

    public function __construct(string $model, array $messages, int $maxOutputTokens)
    {
        $this->model = $model;
        $this->messages = $messages;
        $this->maxOutputTokens = $maxOutputTokens;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function getMaxOutputTokens(): int
    {
        return $this->maxOutputTokens;
    }
}

class Message
{
    private string $role;
    private string $content;

    public function __construct(string $role, string $content)
    {
        $this->role = $role;
        $this->content = $content;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}

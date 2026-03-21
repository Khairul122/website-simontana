<?php

function setToast(string $type, string $title, string $message): void
{
    $_SESSION['toast'] = [
        'type' => $type,
        'title' => $title,
        'message' => $message
    ];
}

function setDialog(string $title, string $message, string $type = 'info'): void
{
    $_SESSION['dialog'] = [
        'type' => $type,
        'title' => $title,
        'message' => $message
    ];
}

function getCurrentRole(): string
{
    return $_SESSION['user']['role'] ?? 'Guest';
}

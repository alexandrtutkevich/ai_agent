#!/bin/bash


# Беремо текст із аргументу
INPUT="$1"

if [ -z "$INPUT" ]; then
    echo "Помилка: текст не передано. Виділіть код і запустіть інструмент."
    exit 1
fi

# Передаємо текст у ai.php
echo "$INPUT" | ~/ai.php
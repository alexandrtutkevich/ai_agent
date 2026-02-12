## Це простий та безкоштовний AI агент для роботи в phpstorm на ubuntu

Щоб використовувати безкоштовне АПІ взято проект https://groq.com/ потрібно там зареєструватись та згенерувати апі ключ 
Зайти в https://console.groq.com/ знайти розділ Api keys та створити там ключ.
 
Скопіюйте приклад конфіг файла в дійсний конфіг файл

 ```bash
 cp .env.example .env
```
 
В .env потрібно додати свій ключ в GROQ_API_KEY
 
 
Відкрийте файл ai.php знайдіть рядок 

```php
$apiKey = 'GROQ_API_KEY';
```
 та замініть в ньому GROQ_API_KEY на ваш ключ
 
###Запуск
 
Потрібно зробити файл ai-phpstorm.sh виконуваним:
 
Виконайте в консолі:
 
 ```bash
 chmod +x ai-phpstorm.sh
```

Скопіюйте файл aa до папки ~/bin в вашій *nix системі, так виконайте три команди послідовно

 ```bash
chmod +x ~/bin/aa
echo 'export PATH="$HOME/bin:$PATH"' >> ~/.bashrc
alias aa="aa"
```


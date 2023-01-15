# Kníhkupectvo
Framework: nie je potrebný, ale môže byť ľubovoľný
Verzia PHP: 8 a vyššie

## Zadanie:
Vytvorte aplikáciu/komponentu na vyhľadávanie kníh, skrz rôzne kníhkupectvá na celom svete.
Nie je potrebné žiadne GUI
Pre jednoduchosť, vyhľadávanie bude prebiehať iba výlučne na základe jedného zadaného
reťazca a to názov knihy, ktorý bude vstupným parametrom do komponenty.
Požadovaný výsledok vyhľadávania je zoznam nájdených titulov so základnými informáciami o
knihe a to názov, cena a kníhkupectvo, v ktorom sa titul nachádza. V prípade nájdenia knihy vo
viacerých kníhkupectvách, je požadované zoradiť knihy podľa ceny od najlacnejšej po
najdrahšiu.

Pre úlohu predpokladajme, že každé kníhkupectvo má vlastné API na fiktívnej URL, ktorá pre
zadaný reťazec vráti zoznam kníh, avšak nemôžeme predpokladať, že kníhkupectvá vracajú
dáta v rovnakom unifikovanom formáte (tj. iné názvy parametrov, iný formát odpovede, iný počet
prvkov a pod.)

Dôležitý je návrh aplikácie, tak aby bola jednoducho rozšíriteľná o ďalšie kníhkupectvo s čo
najmenším zásahom do pôvodného kódu.
Kód prosíme čo najviac komentovať, aby nevznikali nedorozumenia pri vyhodnocovaní.

## Fiktívne kníhkupectvo 1.
URL: https://fiktivne-knihy.sk/hladaj?nazov=harry
Response:
{"data":[{"nazov":"Harry Potter a kamen mudrcov","cena":"10€"},{"nazov":"Harry Potter a
tajomna komnata","cena":"11€"},{"nazov":"Harry Potter a vazen z Azkabanu","cena":"7€"}]}

## Fiktívne kníhkupectvo 2.
URL: https://nonrealbookshop.com/search?title=harry
Response:
[{"title":"Harry Potter a kamen mudrcov","price":"7","currency":"€","lang":"SK"},{"title":"Harry
Potter a tajomna komnata","price":"15","currency":"€","lang":"SK"},{"title":"Harry Potter a vazen z
Azkabanu","price":"18","currency":"€","lang":"SK"}]

# Kníhkupectvo
Framework: nie je potrebný, ale môže byť ľubovoľný
Verzia PHP: 8 a vyššie

## Zadanie:
Vytvorte aplikáciu/komponentu na vyhľadávanie kníh, skrz rôzne kníhkupectvá na celom svete.
Nie je potrebné žiadne GUI
Pre jednoduchosť, vyhľadávanie bude prebiehať iba výlučne na základe jedného zadaného
reťazca a to názov knihy, ktorý bude vstupným parametrom do komponenty.
Požadovaný výsledok vyhľadávania je zoznam nájdených titulov so základnými informáciami o
knihe a to názov, cena a kníhkupectvo, v ktorom sa titul nachádza. V prípade nájdenia knihy vo
viacerých kníhkupectvách, je požadované zoradiť knihy podľa ceny od najlacnejšej po
najdrahšiu.

Pre úlohu predpokladajme, že každé kníhkupectvo má vlastné API na fiktívnej URL, ktorá pre
zadaný reťazec vráti zoznam kníh, avšak nemôžeme predpokladať, že kníhkupectvá vracajú
dáta v rovnakom unifikovanom formáte (tj. iné názvy parametrov, iný formát odpovede, iný počet
prvkov a pod.)

Dôležitý je návrh aplikácie, tak aby bola jednoducho rozšíriteľná o ďalšie kníhkupectvo s čo
najmenším zásahom do pôvodného kódu.
Kód prosíme čo najviac komentovať, aby nevznikali nedorozumenia pri vyhodnocovaní.

## Fiktívne kníhkupectvo 1.
URL: https://fiktivne-knihy.sk/hladaj?nazov=harry
Response:
{"data":[{"nazov":"Harry Potter a kamen mudrcov","cena":"10€"},{"nazov":"Harry Potter a
tajomna komnata","cena":"11€"},{"nazov":"Harry Potter a vazen z Azkabanu","cena":"7€"}]}

## Fiktívne kníhkupectvo 2.
URL: https://nonrealbookshop.com/search?title=harry
Response:
[{"title":"Harry Potter a kamen mudrcov","price":"7","currency":"€","lang":"SK"},{"title":"Harry
Potter a tajomna komnata","price":"15","currency":"€","lang":"SK"},{"title":"Harry Potter a vazen z
Azkabanu","price":"18","currency":"€","lang":"SK"}]

## Vypracovanie

Projekt nepoužíva framework, no zahŕňa niekoľko knižníc (dotenv, guzzle, phpunit). Obsahuje dva modely 'Bookshop' a 'Book'. Bookshop je abstraktná trieda pre ostatné triedy reprezentujúce jednotlivé knihkupectvá kde je predpoklad že ich API budé mať rôzne špecifikácie a formu odpovede. Book je typová trieda ktorá opisuje objekt z jeho základnými parametrami (názov, cena, kníkupectvo). Ďalej má projekt index file, v ktorom je zahrnutá jednoduchá logika requestu, BookSearch Controller v ktorom prebieha logika komponentu čiže volanie jednotlivých kníkupectiev, spracovanie výsledkov do typu Book a zoradenie výsledkov od najnižšej ceny. Projekt je schopný logovat, handluje exception pri chybe volania do kníkupectva (dá sa simulovat vypnutím containeru ex. `docker stop fiktivne-knihy`), API kníhkupectiev, ktoré sú aktívne sa configruju cez `.env` súbor. Ďalšie detaily sú v komentároch codebase.

Do projektu som zahrnul aj testy pre model classy a controller.
Spustenie testov (bez docker prostredia):
- `cd app`
- `composer install`
- `./vendor/phpunit/phpunit/phpunit  --testdox tests`

Projekt obsahuje aj docker prostredie kde sú dve kníhkupectva mockovane a vracujú odpoveď len na request "harry potter" a "stoparuv pruvodce". Tak je možné po spustení prostredia zavolať request `http://127.0.0.1:8000/search?title=harry%20potter`:
```
http://127.0.0.1:8000/search?title=harry%20potter
{
    "status": 200,
    "result": [
        {
            "title": "Harry Potter a vazen z Azkabanu",
            "price": 7,
            "bookshop": "Fiktivne Knihy"
        },
        {
            "title": "Harry Potter a kamen mudrcov",
            "price": 7,
            "bookshop": "NonReal Bookshop"
        },
        {
            "title": "Harry Potter a kamen mudrcov",
            "price": 10,
            "bookshop": "Fiktivne Knihy"
        },
        {
            "title": "Harry Potter a tajomna komnata",
            "price": 11,
            "bookshop": "Fiktivne Knihy"
        },
        {
            "title": "Harry Potter a tajomna komnata",
            "price": 15,
            "bookshop": "NonReal Bookshop"
        },
        {
            "title": "Harry Potter a vazen z Azkabanu",
            "price": 18,
            "bookshop": "NonReal Bookshop"
        }
    ]
}
```

V prostredí macOS alebo v inom linuxovom prostredi by mal pre spustenie projektu postačovať `docker` a `docker-compose`. V prostredí s windows je ešte potrebné mať `wsl` alebo iný tooling (`gitbash`, `cmder`...) poskytujúci príkaz `make`. Samotné spustenie (linux):
- `cp .env.EXAMPLE .env`
- `make start`

`Makefile` obsahuje niekoľko ďalších scriptov, ktoré som použil počas písania aplikácie, po spusteni `make` sa zobrazi help.
```
autoload                       Regenerate autoload (used after adding new classes)
help                           Show help
install                        Install dependencies
logs-app                       Show logs for app container
logs                           Show logs
start                          Run application
stop                           Stop application and delete containers and volumes
tests                          Run tests
```
```
ex. `make logs-app`
app  | [2023-01-15T10:41:23.366554+00:00] APP.INFO: Active bookshops in configuration {"bookshop_names":"fiktivne-knihy.sk, nonrealbookshop.com, example.com"} []
app  | [2023-01-15T10:41:23.371124+00:00] APP.INFO: Request received {"request_uri":"/search?title=harry%20potter","request_method":"GET","query":{"title":"harry potter"}} []
app  | [2023-01-15T10:41:23.393227+00:00] APP.INFO: Searching for books {"bookshop":"Fiktivne Knihy","query":"harry potter"} []
app  | [2023-01-15T10:41:23.435491+00:00] APP.INFO: Searching for books {"bookshop":"NonReal Bookshop","query":"harry potter"} []
app  | [2023-01-15T10:41:23.437786+00:00] APP.ERROR: Bookshop not found {"name":"example.com"} []
app  | [2023-01-15T10:41:23.437844+00:00] APP.INFO: Books found {"amount":6} []
app  | 192.168.240.5 -  15/Jan/2023:10:41:23 +0000 "GET /index.php" 200
app  | 192.168.240.5 -  15/Jan/2023:10:59:06 +0000 "GET /index.php" 200
app  | [2023-01-15T10:59:51.982550+00:00] APP.INFO: Active bookshops in configuration {"bookshop_names":"fiktivne-knihy.sk,nonrealbookshop.com"} []
app  | [2023-01-15T10:59:51.990175+00:00] APP.INFO: Request received {"request_uri":"/search?title=harry%20potter","request_method":"GET","query":{"title":"harry potter"}} []
app  | [2023-01-15T10:59:52.028179+00:00] APP.INFO: Searching for books {"bookshop":"Fiktivne Knihy","query":"harry potter"} []
app  | [2023-01-15T10:59:52.088303+00:00] APP.INFO: Searching for books {"bookshop":"NonReal Bookshop","query":"harry potter"} []
app  | [2023-01-15T10:59:52.090316+00:00] APP.INFO: Books found {"amount":6} []
app  | 192.168.240.5 -  15/Jan/2023:10:59:51 +0000 "GET /index.php" 200
```

Pre rozšírenie applikácie o ďalšie kníkupectvo (pridanie API) by bolo potrebné pridať triedu, ktorá by spracovávala odpoveď z API podľa jeho špecifikácie. Triedu by bolo ďalej potrebne pridať do mapperu v controller triede a do konfiguracie.
```PHP

    // app/models/Bookshop/BookshopMartinus
    class BookshopMartinus extends Bookshop
    {
        const NAME = "Martinus"
        const URL = "https://martinus.sk"

        public function search(string $query): array
        {
    .
    .
    .

    // app/controllers/BookSearchController
    const BOOKSHOP_MAPPER = [
        'fiktivne-knihy.sk' => BookshopFiktivneKnihy::class,
        'nonrealbookshop.com' => BookshopNonReal::class,
        'martinus.sk' => BookshopMartinus::class,
    ];


    // .env
    BOOKSHOP_NAMES="fiktivne-knihy.sk,nonrealbookshop.com,martinus.sk"
```

Štruktúra adresárov:
```
.
├── Makefile
├── app
│   ├── composer.json
│   ├── composer.lock
│   ├── config
│   │   └── env.php
│   ├── controllers
│   │   └── BookSearchController.php
│   ├── index.php
│   ├── info.php
│   ├── models
│   │   ├── Book.php
│   │   └── Bookshop
│   │       ├── Bookshop.php
│   │       ├── BookshopFiktivneKnihy.php
│   │       └── BookshopNonReal.php
│   ├── services
│   │   └── Logger.php
│   └── tests
│       ├── BookSearchControllerTest.php
│       ├── BookshopFiktivneKnihyTest.php
│       └── BookshopNonRealTest.php
├── docker
│   ├── nginx.conf
│   ├── nginx.fiktivne-knihy.conf
│   └── nginx.nonrealbookshop.conf
└── docker-compose.yml
```

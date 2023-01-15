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
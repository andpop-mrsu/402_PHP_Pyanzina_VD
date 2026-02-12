# Brain Games: GCD (Greatest Common Divisor)

[![Packagist Version](https://img.shields.io/packagist/v/iambadatnicknames/gcd)](https://packagist.org/packages/iambadatnicknames/gcd)

https://packagist.org/packages/iambadatnicknames/gcd

## Описание

Веб-приложение «Наибольший общий делитель» (GCD) с базой данных SQLite.

Игроку показываются два случайных целых числа. Необходимо вычислить и ввести
наибольший общий делитель этих чисел. Игра состоит из 3 раундов.

Результаты всех игр сохраняются в базе данных SQLite с информацией об именах
игроков, датах, результатах, предлагавшихся числах и их НОД.

## Требования

- PHP >= 8.0 (с расширением SQLite3)

## Запуск

```bash
cd Task02
php -S localhost:3000 -t public
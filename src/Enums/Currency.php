<?php

declare(strict_types=1);

namespace ZachWatkins\InferDataSchema\Enums;

/**
 * Hexadecimal values representing international currencies, following the ISO 4217 standard.
 * @see https://learn.microsoft.com/en-us/sql/t-sql/data-types/money-and-smallmoney-transact-sql
 */
enum Currency: string
{
    case Dollar = '0024';
    case Cent = '00A2';
    case Pound = '00A3';
    case CurrencySign = '00A4';
    case Yen = '00A5';
    case BengaliRupeeMark = '09F2';
    case BengaliRupeeSign = '09F3';
    case ThaiBaht = '0E3F';
    case KhmerRiel = '17DB';
    case EuroCurrencySign = '20A0';
    case ColonSign = '20A1';
    case CruzeiroSign = '20A2';
    case FrenchFrancSign = '20A3';
    case LiraSign = '20A4';
    case MillSign = '20A5';
    case NairaSign = '20A6';
    case PesetaSign = '20A7';
    case RupeeSign = '20A8';
    case WonSign = '20A9';
    case NewSheqelSign = '20AA';
    case DongSign = '20AB';
    case EuroSign = '20AC';
    case KipSign = '20AD';
    case TugrikSign = '20AE';
    case DrachmaSign = '20AF';
    case GermanPennySign = '20B0';
    case PesoSign = '20B1';
    case RialSign = 'FDFC';
    case SmallDollarSign = 'FE69';
    case FullWidthDollarSign = 'FF04';
    case FullWidthCentSign = 'FFE0';
    case FullWidthPoundSign = 'FFE1';
    case FullWidthYenSign = 'FFE5';
    case FullWidthWonSign = 'FFE6';

    /**
     * Method to detect the currency used in a given string.
     * @param string $input The string to check for currency symbols.
     * @return Currency|null The detected currency, or null if none is found.
     */
    public static function cast(string $input): ?self
    {
        foreach (self::cases() as $currency) {
            if (str_contains($input, html_entity_decode('&#x' . $currency->value . ';'))) {
                return $currency;
            }
        }
        return null;
    }
}

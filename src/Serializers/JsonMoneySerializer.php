<?php

declare(strict_types=1);

namespace TTBooking\MoneySerializer\Serializers;

use InvalidArgumentException;
use Money\Currency;
use Money\Money;
use TTBooking\MoneySerializer\Contracts\SerializesMoney;

class JsonMoneySerializer implements SerializesMoney
{
    public function serialize(Money $money): string
    {
        return json_encode($money);
    }

    public function deserialize(string $serialized, Currency $fallbackCurrency = null): Money
    {
        $value = json_decode($serialized);
        $currency = $value->currency ? new Currency($value->currency) : $fallbackCurrency;

        if (is_null($currency)) {
            throw new InvalidArgumentException('Fallback currency requested, but not provided.');
        }

        return new Money($value->amount, $currency);
    }
}

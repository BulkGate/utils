<?php declare(strict_types=1);

/**
 * @author Lukáš Piják 2019 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

namespace BulkGate\Utils;

use BulkGate, NumberFormatter, IntlDateFormatter;

class Locale
{
    use BulkGate\Strict;

    /** @var NumberFormatter */
    private $number_formatter;

    /** @var NumberFormatter */
    private $currency_formatter;

    /** @var IntlDateFormatter */
    private $datetime_formatter;

    /** @var IntlDateFormatter */
    private $date_formatter;

    /** @var IntlDateFormatter */
    private $time_formatter;

    public function __construct(string $locale, ?\DateTimeZone $timeZone = null)
    {
        if(extension_loaded('intl'))
        {
            $this->number_formatter = new NumberFormatter($locale, NumberFormatter::DECIMAL);
            $this->currency_formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
            $this->datetime_formatter = new IntlDateFormatter($locale,
                IntlDateFormatter::MEDIUM,
                IntlDateFormatter::MEDIUM,
                $timeZone ? $timeZone->getName() : null
            );
            $this->date_formatter = new IntlDateFormatter($locale,
                IntlDateFormatter::MEDIUM,
                IntlDateFormatter::NONE
            );
            $this->time_formatter = new IntlDateFormatter($locale,
                IntlDateFormatter::NONE,
                IntlDateFormatter::MEDIUM,
                $timeZone ? $timeZone->getName() : null
            );
        }
        else
        {
            throw new ExtensionException('PHP extension INTL not installed');
        }
    }


    public function price(float $price, ?string $currency = null): string
    {
        if($currency === null)
        {
            return $this->float($price);
        }

        if($p = $this->currency_formatter->formatCurrency($price, strtoupper($currency)))
        {
            return $p;
        }
        return $this->float($price).$currency;
    }


    public function float(float $number): string
    {
        return $this->number_formatter->format($number, NumberFormatter::TYPE_DOUBLE);
    }


    public function int(float $number): string
    {
        return $this->number_formatter->format($number, NumberFormatter::TYPE_INT64);
    }


    public function datetime(\DateTime $dateTime): string
    {
        return $this->datetime_formatter->format($dateTime);
    }


    public function date(\DateTime $date): string
    {
        return $this->date_formatter->format($date);
    }


    public function time(\DateTime $date): string
    {
        return $this->time_formatter->format($date);
    }
}
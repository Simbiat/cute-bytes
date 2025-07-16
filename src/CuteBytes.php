<?php
declare(strict_types = 1);

namespace Simbiat;

/**
 * Present a numeric value of bytes as a human-readable string
 */
class CuteBytes
{
    public const array SIZES_DECIMAL = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB', 'RB', 'QB'];
    public const array SIZES_BINARY = ['B', 'kiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
    #How many 'extra' numbers to show. 3 will attempt to show thousands, where applicable
    
    /**
     * Generate the string
     *
     * @param string|float|int $string        Value to convert.
     * @param int              $power         Power used in conversion. Whether comply with decimal SI (1000) or binary IEC 80000-13 (1024).
     * @param int              $decimals      Number of decimals after decimal delimiter.
     * @param string           $dec_point     Decimal delimiter. If empty, `.` will be forced.
     * @param string           $thousands_sep Thousands' separator, `,` by default.
     * @param int              $numbers       How many 'extra' numbers to show. For example, 3 will attempt to show thousands, where applicable. 0 by default for a more "conventional" look.
     * @param bool             $bits          Whether the provided value is bits, not bytes.
     *
     * @return string
     */
    public static function bytes(string|float|int $string, int $power = 1000, int $decimals = 2, string $dec_point = '.', string $thousands_sep = ',', int $numbers = 0, bool $bits = false): string
    {
        if ($power !== 1000 && $power !== 1024) {
            throw new \UnexpectedValueException('Unsupported power of `'.$power.'`.');
        }
        if ($decimals < 0) {
            $decimals = 0;
        }
        if ($numbers < 0) {
            $numbers = 0;
        }
        if ($dec_point === '') {
            $dec_point = '.';
        }
        if (is_numeric($string)) {
            #Retracting 1 for synchronization of length with array numbering
            #Retracting 3 to show thousands by default, which looks a bit more readable sometimes
            $exp = (int)floor((mb_strlen((string)$string, 'UTF-8') - 1 - $numbers) / 3);
            #Preventing $exp getting outside of possible postfixes
            $max_postfix = count($power === 1000 ? self::SIZES_DECIMAL : self::SIZES_BINARY) - 1;
            if ($exp > $max_postfix) {
                $exp = $max_postfix;
            }
            if ($exp < 0) {
                $exp = 0;
            }
            #Using 1000 by default instead of 1024, as per SI recommendations
            $pow = $power ** $exp;
            #Limiting decimals to 2 (default) and stripping superfluous zeros
            $string = mb_rtrim(mb_rtrim(number_format($string / $pow, $decimals, $dec_point, $thousands_sep), '0', 'UTF-8'), $dec_point, 'UTF-8');
            #Adding postfix
            $string .= ' '.($power === 1000 ? self::SIZES_DECIMAL[$exp] : self::SIZES_BINARY[$exp]);
        } else {
            $string = 'NaN';
        }
        if ($bits) {
            $string = str_replace('B', 'bit', $string);
        }
        return $string;
    }
}
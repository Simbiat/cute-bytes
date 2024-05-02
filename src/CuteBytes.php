<?php
declare(strict_types = 1);

namespace Simbiat;

/**
 * Present numeric value of bytes as a human-readable string
 */
class CuteBytes
{
    public const array sizes = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    public static int $decimals = 2;
    public static string $dec_point = '.';
    public static string $thousands_sep = ',';
    #How many 'extra' numbers to show. 3 will attempt to show thousands, where applicable
    public static int $numbers = 3;
    
    /**
     * Generate the string
     *
     * @param string|float|int $string Value to convert
     * @param int              $power  Power used in conversion. Whether comply with SI (1000) or binary (1024).
     *
     * @return string
     */
    public static function bytes(string|float|int $string, int $power = 1000): string
    {
        if ($power !== 1000 && $power !== 1024) {
            throw new \UnexpectedValueException('Unsupported power of `'.$power.'`.');
        }
        if (is_numeric($string)) {
            #Retracting 1 for synchronization of length with array numbering
            #Retracting 3 to show thousands by default, which looks a bit more readable sometimes
            $exp = (int)floor((mb_strlen($string, 'UTF-8') - 1 - self::$numbers) / 3);
            #Preventing $exp getting outside of possible postfixes
            $maxPostfix = \count(self::sizes) - 1;
            if ($exp > $maxPostfix) {
                $exp = $maxPostfix;
            }
            if ($exp < 0) {
                $exp = 0;
            }
            #Using 1000 by default instead of 1024, as per SI recommendations
            $pow = $power ** $exp;
            #Limiting decimals to 2 (default) and stripping superfluous zeros
            $string = rtrim(rtrim(number_format($string / $pow, self::$decimals, self::$dec_point, self::$thousands_sep), '0'), self::$dec_point);
            #Adding postfix
            $string .= ' '.self::sizes[$exp];
        } else {
            $string = 'NaN';
        }
        return $string;
    }
}

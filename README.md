# CuteBytes

Class to present bytes (numeric value) as a human-readable string. There are several reasons you would want to use this library and not the common one-liner (or 3-liner) approach:

- No missing postfixes in case of too big or too small values.
- No superfluous trailing zeros.
- Follows SI format by default (power of 10 can be switched to power of 2, if so desired).
- Shows thousands by default (adjustable) for extra readability in some cases.

## How to use

Easy:

```php
echo \Simbiat\CuteBytes::bytes(1234567890);
```

will output `1,234.57 MB`

You can change decimal and thousands delimiters or change the number of decimals (precision)

```php
echo \Simbiat\CuteBytes::bytes(1234567890, decimals: 3, dec_point: ',', thousands_sep: '.');
```

to get `1.234,568 MB`

If you want to drop thousands, set the default number of numbers shown

```php
echo \Simbiat\CuteBytes::bytes(1234567890, numbers: 0);
```

to get `1.23 GB`

If you want to use "classic" logic, that is binary, power of 2, use

```php
echo \Simbiat\CuteBytes::bytes(1234567890, 1024);
```

to get `1,177.38 MB` (note some additional loss of precision)
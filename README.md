# CuteBytes
Class to present bytes (numeric value) as a human-readable string. There are several reasons you would wnat to use this library and not the common one-liner (or 3-liner) approach:
- No missing postfixes in case of too big or too small values.
- No superflous trailing zeros.
- Follows SI format by default (power of 10, can be switched to power of 2, if so desired).
- Shows thousands by default (adjustable) for extra readability in some cases.
# CuteBytes
Class to present bytes (numeric value) as a human-readable string. Commonly used approach has following flaws, that this library attempts to fix:
- Empty postfixes: if value is too small or too big you may get just a number. Library avoids that.
- Trailing zeros: shows .00, which does not look good. Library strips them.
- Does not follow SI: uses power of 2, instead of power of 10, as is the current way according to SI, except for RAM (can be adjusted, though)
Additionally, library shows thousands by default, where applicable, which makes it a bit more readable (1000 MB is sometimes better than 1 GB) and allows setting up separators.
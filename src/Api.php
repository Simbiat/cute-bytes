<?php
declare(strict_types=1);
namespace CuteBytes;

class Api
{
    const sizes = ['B','kB','MB','GB','TB','PB','EB','ZB','YB'];
    private $decimals = 2;
    private $dec_point = '.';
    private $thousands_sep = ',';
    #How many 'extra' numbers to show. 3 will attempt to show thousands, where applicable
    private $numbers = 3;
    #Whether comply with SI (1000) or binary (1024)
    private $power = 1000;
    
    public function bytes($string): string
    {
        if (is_numeric($string)) {
            #Retracting 1 for syncronization of length with array numbering
            #Retracting 3 to show thousands by default, which looks a bit more readable some times
            $exp = floor((strlen($string) - 1 - $this->numbers) / 3);
            #Preventing $exp getting outside of possible postfixes
            $maxpostfix = count(self::sizes)-1;
            if ($exp > $maxpostfix) {
                $exp = $maxpostfix;
            }
            if ($exp < 0) {
                $exp = 0;
            }
            #Using 1000 by default instead of 1024, as per SI recommendations
            $pow = 1000**$exp;
            #Limiting decimals to 2 (default) and stripping superflous zeros
            $string = rtrim(rtrim((string)number_format($string/$pow, $this->getDecimals(), $this->getDecPoint(), $this->getThousandSep()), '0'), $this->getDecPoint());
            #Adding postfix
            $string = $string.' '.self::sizes[$exp];
        } else {
            $string = 'NaN';
        }
        return $string;
    }
    
    #####################
    #Setters and getters#
    #####################
    public function getDecimals(): int
    {
        return $this->decimals;
    }
    
    public function setDecimals(int $decimals): self
    {
        $this->decimals = $decimals;
        return $this;
    }
    
    public function getDecPoint(): string
    {
        return $this->dec_point;
    }
    
    public function setDecPoint(string $dec_point): self
    {
        $this->dec_point = $dec_point;
        return $this;
    }
    
    public function getThousandSep(): string
    {
        return $this->thousands_sep;
    }
    
    public function setThousandSep(string $thousands_sep): self
    {
        $this->thousands_sep = $thousands_sep;
        return $this;
    }
    
    public function getPower(): int
    {
        return $this->power;
    }
    
    public function setPower(int $power): self
    {
        if ($power !== 1000 && $power !== 1024) {
            $power = 1000;
        }
        $this->power = $power;
        return $this;
    }
    
    public function getNumbers(): int
    {
        return $this->numbers;
    }
    
    public function setNumbers(int $numbers): self
    {
        $this->numbers = $numbers;
        return $this;
    }
}
?>
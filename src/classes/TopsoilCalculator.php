<?php

namespace Classes;

class TopsoilCalculator
{
    private static int $bagCost = 60;
    private static int $vatPercent = 20;
    private static array $validUnits = ['metres', 'feet', 'yards'];
    private static array $validDepthUnits = ['centimetres', 'inches'];
    private string $unit = 'metres';
    private string $depthUnit = 'centimetres';
    private int $width = 0;
    private int $length = 0;
    private int $depth = 0;

    public static function getValidUnits(): array
    {
        return self::$validUnits;
    }

    public static function getValidDepthUnits(): array
    {
        return self::$validDepthUnits;
    }

    public static function getBagCost(): int
    {
        return self::$bagCost;
    }

    public static function setBagCost(int $bagCost): void
    {
        self::$bagCost = $bagCost;
    }

    public static function getVatPercent(): int
    {
        return self::$vatPercent;
    }

    public static function setVatPercent(int $vatPercent): void
    {
        self::$vatPercent = $vatPercent;
    }

    public static function getBagCostWithVat(): int
    {
        $bagCost = self::getBagCost();
        $vat = self::getVatPercent();
        return $bagCost + ($bagCost * ($vat / 100));
    }

    public static function convertToCm($type, $value)
    {
        switch ($type) {
            case 'feet':
                return $value * 0.3048;
            case 'yards':
                return $value * 0.9144;
            case 'inches':
                return $value * 2.54;
            case 'metres':
                return $value * 100;
            case 'centimetres':
                return $value;
            default:
                throw new \Exception("Invalid convert type.");
        }
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getDepth(): int
    {
        return $this->depth;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function setUnit($unit)
    {
        if (!in_array($unit, self::getValidUnits())) {
            throw new \Exception("Invalid unit");
        }
        $this->unit = $unit;
    }

    public function getDepthUnit(): string
    {
        return $this->depthUnit;
    }

    public function setDepthUnit($unit)
    {
        if (!in_array($unit, self::getValidDepthUnits())) {
            throw new \Exception("Invalid depth unit");
        }
        $this->depthUnit = $unit;
    }

    public function setDimensions($width, $length, $depth)
    {
        $this->width = $width;
        $this->length = $length;
        $this->depth = $depth;
    }

    public function calculateVolume(): int
    {
        // convert width and length to cm
        $width = self::convertToCm($this->getUnit(), $this->getWidth());
        $length = self::convertToCm($this->getUnit(), $this->getLength());
        $depth = self::convertToCm($this->getDepthUnit(), $this->getDepth());

        // calculate volume in cubic meters
        $area = ($width * $length) / 100;
        $depthInMeters = $depth / 100;
        return $area * $depthInMeters;
    }

    public function calculateBagsNeeded()
    {
        $x = $this->calculateVolume() * 0.025;
        $y = $x * 1.4;
        return ceil($y);
    }

    public function calculateBagsNeededPrice()
    {
        return $this->calculateBagsNeeded() * self::getBagCostWithVat();
    }

    public function addToBasket()
    {
        $basket = \Basket::getInstance();
        // some logic to add to basket
    }
}

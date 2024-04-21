<?php

require '../classes/TopsoilCalculator.php';

function testSetUnit() {
    echo "Testing " . __FUNCTION__ . "...\n";

    $calculator = new Classes\TopsoilCalculator();

    // set a valid unit
    try {
        $validUnits = Classes\TopsoilCalculator::getValidUnits();
        $calculator->setUnit($validUnits[0]); // using first valid unit, should be fine
        echo "Passed: Valid unit '$validUnits[0]' accepted.\n";
    } catch (Exception $e) {
        echo "Failed: " . $e->getMessage() . "\n";
    }

    // set an invalid unit
    try {
        $calculator->setUnit("some invalid unit");
        echo "Failed: Invalid unit 'some invalid unit' should not be accepted.\n";
    } catch (Exception $e) {
        echo "Passed: Correctly handled invalid unit with message - " . $e->getMessage() . "\n";
    }
}

function testSetDepthUnit() {
    echo "Testing " . __FUNCTION__ . "...\n";

    $calculator = new Classes\TopsoilCalculator();

    // set a valid unit
    try {
        $validUnits = Classes\TopsoilCalculator::getValidDepthUnits();
        $calculator->setDepthUnit($validUnits[0]); // using first valid unit, should be fine
        echo "Passed: Valid depth unit '$validUnits[0]' accepted.\n";
    } catch (Exception $e) {
        echo "Failed: " . $e->getMessage() . "\n";
    }

    // set an invalid unit
    try {
        $calculator->setDepthUnit("some invalid unit");
        echo "Failed: Invalid depth unit 'some invalid unit' should not be accepted.\n";
    } catch (Exception $e) {
        echo "Passed: Correctly handled invalid depth unit with message - " . $e->getMessage() . "\n";
    }
}

function testSetVatPercent() {
    echo "Testing " . __FUNCTION__ . "...\n";

    try {
        Classes\TopsoilCalculator::setVatPercent(30);
        echo "Passed: VAT percentage successfully set.\n";
    } catch (Exception $e) {
        echo "Failed: Couldn't set VAT percentage.\n";
    }
}

function testSetBagCost() {
    echo "Testing " . __FUNCTION__ . "...\n";

    try {
        Classes\TopsoilCalculator::setBagCost(100);
        echo "Passed: bag cost successfully set.\n";
    } catch (Exception $e) {
        echo "Failed: Couldn't set bag cost.\n";
    }
}

function testCalculateVat() {
    echo "Testing " . __FUNCTION__ . "...\n";

    $vat = 20;
    $bagCost = 100;
    $expectedPrice = 120;

    Classes\TopsoilCalculator::setVatPercent($vat);
    Classes\TopsoilCalculator::setBagCost($bagCost);
    $total = Classes\TopsoilCalculator::getBagCostWithVat();
    if ($total == $expectedPrice) {
        echo "Passed: total price with VAT is $expectedPrice as expected.\n";
    } else {
        echo "Failed: total price with VAT is $total instead of $expectedPrice.\n";
    }
}

function testSetDimensions() {
    echo "Testing " . __FUNCTION__ . "...\n";

    $calculator = new Classes\TopsoilCalculator();
    try {
        $calculator->setDimensions(5, 10, 4);
        echo "Passed: dimensions successfully set.\n";
    } catch (\Exception $e) {
        echo "Failed: " . $e->getMessage() . "\n";
    }
}

function testCalculateVolume() {
    echo "Testing " . __FUNCTION__ . "...\n";

    $calculator = new Classes\TopsoilCalculator();
    $calculator->setUnit('metres');
    $calculator->setDepthUnit('centimetres');
    $calculator->setDimensions(10, 10, 100);

    // should be 10 * 10 * (100 / 100)
    if ($calculator->calculateVolume() == 100) {
        echo "Passed: volume successfully calculated.\n";
    } else {
        echo "Failed: volume successfully calculated.\n";
    }
}

function testCalculateBagsNeeded() {
    echo "Testing " . __FUNCTION__ . "...\n";

    $expectedBags = 4;

    $calculator = new Classes\TopsoilCalculator();
    $calculator->setUnit('metres');
    $calculator->setDepthUnit('centimetres');
    $calculator->setDimensions(10, 10, 100);

    $bagsNeeded = $calculator->calculateBagsNeeded();
    if ($bagsNeeded == $expectedBags) {
        echo "Passed: successfully calculated bags needed.\n";
    } else {
        echo "Failed: got $bagsNeeded instead of $expectedBags.\n";
    }
}

function testCalculateBagsNeededPrice() {
    echo "Testing " . __FUNCTION__ . "...\n";

    $calculator = new Classes\TopsoilCalculator();
    $calculator->setDimensions(10, 10, 100);
    $calculator->setUnit('metres');
    $calculator->setDepthUnit('centimetres');
    Classes\TopsoilCalculator::setBagCost(100);
    Classes\TopsoilCalculator::setVatPercent(20);

    // expected price would be 4 * 120 = 480
    $expectedPrice = 480;
    $totalPrice = $calculator->calculateBagsNeededPrice();
    if ($totalPrice == $expectedPrice) {
        echo "Passed: successfully calculated total price of bags needed.\n";
    } else {
        echo "Failed: got $totalPrice instead of $expectedPrice.\n";
    }
}

// running all tests
testSetUnit();
testSetVatPercent();
testSetBagCost();
testSetDepthUnit();
testSetDimensions();
testCalculateVat();
testCalculateVolume();
testCalculateBagsNeeded();
testCalculateBagsNeededPrice();

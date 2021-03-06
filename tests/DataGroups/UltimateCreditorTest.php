<?php

namespace Sprain\SwissQrBill\Tests\DataGroups;

use PHPUnit\Framework\TestCase;
use Sprain\SwissQrBill\DataGroups\UltimateCreditor;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UltimateCreditorTest extends TestCase
{
    /** @var  ValidatorInterface */
    private $validator;

    /** @var UltimateCreditor */
    private $ultimateCreditor;

    public function setUp()
    {
        $this->validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        // Valid default to be adjusted in single tests
        $this->ultimateCreditor = (new UltimateCreditor())
            ->setName('Thomas Mustermann')
            ->setStreet('Musterweg')
            ->setHouseNumber('22a')
            ->setPostalCode('1000')
            ->setCity('Lausanne')
            ->setCountry('CH');
    }

    /**
     * @dataProvider validNameProvider
     */
    public function testNameIsValid($value)
    {
        $this->ultimateCreditor->setName($value);

        $this->assertSame(0, $this->validator->validate($this->ultimateCreditor)->count());
    }

    public function validNameProvider()
    {
        return [
            ['A'],
            ['123'],
            ['Müller AG'],
            ['Maria Bernasconi'],
            ['70 chars, character limit abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqr']
        ];
    }

    /**
     * @dataProvider invalidNameProvider
     */
    public function testNameIsInvalid($value)
    {
        $this->ultimateCreditor->setName($value);

        $this->assertSame(1, $this->validator->validate($this->ultimateCreditor)->count());
    }

    public function invalidNameProvider()
    {
        return [
            [''],
            ['71 chars, above character limit abcdefghijklmnopqrstuvwxyzabcdefghijklm'],
        ];
    }

    /**
     * @dataProvider validStreetProvider
     */
    public function testStreetIsValid($value)
    {
        $this->ultimateCreditor->setStreet($value);

        $this->assertSame(0, $this->validator->validate($this->ultimateCreditor)->count());
    }

    public function validStreetProvider()
    {
        return [
            [null],
            [''],
            ['A'],
            ['123'],
            ['Sonnenweg'],
            ['70 chars, character limit abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqr']
        ];
    }

    /**
     * @dataProvider invalidStreetProvider
     */
    public function testStreetIsInvalid($value)
    {
        $this->ultimateCreditor->setStreet($value);

        $this->assertSame(1, $this->validator->validate($this->ultimateCreditor)->count());
    }

    public function invalidStreetProvider()
    {
        return [
            ['71 chars, above character limit abcdefghijklmnopqrstuvwxyzabcdefghijklm'],
        ];
    }

    /**
     * @dataProvider validHouseNumberProvider
     */
    public function testHouseNumberIsValid($value)
    {
        $this->ultimateCreditor->setHouseNumber($value);

        $this->assertSame(0, $this->validator->validate($this->ultimateCreditor)->count());
    }

    public function validHouseNumberProvider()
    {
        return [
            [null],
            [''],
            ['1'],
            ['123'],
            ['22a'],
            ['16 chars, -limit']
        ];
    }

    /**
     * @dataProvider invalidHouseNumberProvider
     */
    public function testHouseNumberIsInvalid($value)
    {
        $this->ultimateCreditor->setHouseNumber($value);

        $this->assertSame(1, $this->validator->validate($this->ultimateCreditor)->count());
    }

    public function invalidHouseNumberProvider()
    {
        return [
            ['17 chars, ++limit']
        ];
    }

    /**
     * @dataProvider validPostalCodeProvider
     */
    public function testPostalCodeIsValid($value)
    {
        $this->ultimateCreditor->setPostalCode($value);

        $this->assertSame(0, $this->validator->validate($this->ultimateCreditor)->count());
    }

    public function validPostalCodeProvider()
    {
        return [
            ['1'],
            ['123'],
            ['22a'],
            ['16 chars, -limit']
        ];
    }

    /**
     * @dataProvider invalidPostalCodeProvider
     */
    public function testPostalCodeIsInvalid($value)
    {
        $this->ultimateCreditor->setPostalCode($value);

        $this->assertSame(1, $this->validator->validate($this->ultimateCreditor)->count());
    }

    public function invalidPostalCodeProvider()
    {
        return [
            [''],
            ['17 chars, ++limit']
        ];
    }

    /**
     * @dataProvider validCityProvider
     */
    public function testCityIsValid($value)
    {
        $this->ultimateCreditor->setCity($value);

        $this->assertSame(0, $this->validator->validate($this->ultimateCreditor)->count());
    }

    public function validCityProvider()
    {
        return [
            ['A'],
            ['Zürich'],
            ['35 chars, character limit abcdefghi']
        ];
    }

    /**
     * @dataProvider invalidCityProvider
     */
    public function testCityIsInvalid($value)
    {
        $this->ultimateCreditor->setCity($value);

        $this->assertSame(1, $this->validator->validate($this->ultimateCreditor)->count());
    }

    public function invalidCityProvider()
    {
        return [
            [''],
            ['36 chars, above character limit abcd']
        ];
    }

    /**
     * @dataProvider validCountryProvider
     */
    public function testCountryIsValid($value)
    {
        $this->ultimateCreditor->setCountry($value);

        $this->assertSame(0, $this->validator->validate($this->ultimateCreditor)->count());
    }

    public function validCountryProvider()
    {
        return [
            ['CH'],
            ['ch'],
            ['DE'],
            ['LI'],
            ['US']
        ];
    }

    /**
     * @dataProvider invalidCountryProvider
     */
    public function testCountryIsInvalid($value)
    {
        $this->ultimateCreditor->setCountry($value);

        $this->assertSame(1, $this->validator->validate($this->ultimateCreditor)->count());
    }

    public function invalidCountryProvider()
    {
        return [
            [''],
            ['XX'],
            ['SUI'],
            ['12']
        ];
    }
}
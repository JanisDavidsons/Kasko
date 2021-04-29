<?php

use mgcode\graphql\error\ValidatorException;
use Iban\Validation\Validator;
use app\models\IbanValidator;
use Codeception\Util\Stub;
use Iban\Validation\Iban;
use app\types\IbanType;

class IbanValidatorTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected Validator $validator;
    protected Iban $iban;
    protected stdClass $countryData;
    protected IbanValidator $ibanValidator;

    protected function _before()
    {
        $this->iban = Stub::make(Iban::class, [
            'getNormalizedIban' => function () {
                return 'BE71096123456769';
            }
        ]);
    }

    public function testHaveValidationErrorsOnIncorectIban()
    {
        /** @var Validator $validator */
        $validator = Stub::make(Validator::class, [
            'validate' => function () {
                return false;
            },
            'getViolations' => function () {
                return [
                    "The length of the given Iban is not valid!",
                    "The format of the given Iban is not valid!",
                    "The checksum of the given Iban is not valid!"
                ];
            }
        ]);

        /** @var IbanValidator $ibanValidator */
        $ibanValidator = Stub::make(IbanValidator::class, [
            'ibanModel' => $this->iban,
            'validator' => $validator,
            'countryData' => new stdClass,
            'setCountryData' => function () {
            }
        ]);

        $this->tester->expectThrowable(new ValidatorException('Validation failed.'), function () use ($ibanValidator) {
            $ibanValidator->validateIban();
        });

        $this->tester->assertEquals([
            "The length of the given Iban is not valid!",
            "The format of the given Iban is not valid!",
            "The checksum of the given Iban is not valid!"
        ], $validator->getViolations());

        $this->tester->assertFalse($validator->validate('someSampleIbanNumber'));
    }

    public function testSet_countryFunctionIsCalledOnceOnValidIban()
    {
        /** @var Validator $validator */
        $validator = Stub::make(Validator::class, [
            'validate' => function () {
                return true;
            },
            'getViolations' => function () {
                return [];
            }
        ]);

        /** @var IbanValidator $ibanValidator */
        $ibanValidator = Stub::make(IbanValidator::class, [
            'ibanModel' => $this->iban,
            'validator' => $validator,
            'countryData' => new stdClass,
            'setCountryData' => \Codeception\Stub\Expected::once()
        ]);

        $ibanValidator->validateIban();
    }

    public function testConvertsIbanToPrintFormat()
    {
        /** @var IbanValidator $ibanValidator */
        $ibanValidator = Stub::make(IbanValidator::class, [
            'ibanModel' => $this->iban
        ]);

        /** @var IbanType $ibanType */
        $ibanType = Stub::make(IbanType::class);
        $this->tester->assertSame('BE71 0961 2345 6769', $ibanType->resolveIban($ibanValidator));
    }

    public function testResolve_ibanFunctionReturnsCorrectValue()
    {
        /** @var IbanValidator $ibanValidator */
        $ibanValidator = Stub::make(IbanValidator::class, [
            'ibanModel' => $this->iban
        ]);

        /** @var IbanType $ibanType */
        $ibanType = Stub::make(IbanType::class);
        $this->tester->assertSame('096123456769', $ibanType->resolveBban($ibanValidator));
    }
}

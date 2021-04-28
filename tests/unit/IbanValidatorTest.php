<?php

use app\models\IbanValidator;
use Codeception\Util\Stub;
use Iban\Validation\Validator;
use Iban\Validation\Iban;
use mgcode\graphql\error\ValidatorException;

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

    public function testHaveErrorsOnIvalidIban()
    {
        /** @var Validator $validator */
        $validator = $this->make(Validator::class, [
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
        $ibanValidator = $this->make(IbanValidator::class, [
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

    public function testOnValidIbanSetCountryCalledOnce()
    {
        /** @var Validator $validator */
        $validator = $this->make(Validator::class, [
            'validate' => function () {
                return true;
            },
            'getViolations' => function () {
                return [];
            }
        ]);

        /** @var IbanValidator $ibanValidator */
        $ibanValidator = $this->make(IbanValidator::class, [
            'ibanModel' => $this->iban,
            'validator' => $validator,
            'countryData' => new stdClass,
            'setCountryData' => \Codeception\Stub\Expected::once()
        ]);

        $ibanValidator->validateIban();
    }
}

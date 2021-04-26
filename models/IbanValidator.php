<?php

namespace app\models;

use yii\base\Model;
use Iban\Validation\Iban;
use Iban\Validation\Validator;
use Iban\Validation\CountryInfo;

class IbanValidator extends Model
{
    public string $iban;

    public function validateIban(): bool
    {
        $iban = new Iban($this->iban);
        $validator = new Validator();
        return $validator->validate($iban);
    }
}

<?php

namespace app\types;

use mgcode\graphql\GraphQLType;
use app\models\IbanValidator;

class IbanValidatorType extends GraphQLType
{
    public function name(): string
    {
        return 'IbanValidatorType';
    }

    public function fields(): array
    {
        return [
            'iban' => IbanType::type(),
            'country' => CountryType::type()
        ];
    }

    public function resolveIban(IbanValidator $model)
    {
        return $model;
    }

    public function resolveCountry(IbanValidator $model)
    {
        return $model;
    }
}

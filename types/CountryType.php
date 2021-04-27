<?php

namespace app\types;

use GraphQL\Type\Definition\Type;
use mgcode\graphql\GraphQLType;
use app\models\IbanValidator;

class CountryType extends GraphQLType
{
    public function name(): string
    {
        return 'CountryType';
    }

    public function fields(): array
    {
        return [
            'countryName' => Type::nonNull(Type::string()),
            'capital' => Type::nonNull(Type::string()),
            'region' => Type::nonNull(Type::string()),
            'currencies' => Type::listOf(CurrencyType::type())
        ];
    }

    public function resolveCountryName(IbanValidator $validator): string
    {
        return $validator->countryData->name;
    }

    public function resolveCapital(IbanValidator $validator): string
    {
        return $validator->countryData->capital;
    }

    public function resolveRegion(IbanValidator $validator): string
    {
        return $validator->countryData->region;
    }

    public function resolveCurrencies(IbanValidator $validator)
    {
        return $validator->countryData->currencies;
    }
}

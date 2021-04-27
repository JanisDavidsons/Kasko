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
            'countryCode' => Type::nonNull(Type::string()),
            'countryName' => Type::nonNull(Type::string()),
            'capital' => Type::nonNull(Type::string()),
            'region' => Type::nonNull(Type::string()),
            'subregion' => Type::nonNull(Type::string()),
            'population' => Type::nonNull(Type::float()),
            'latitude' => Type::nonNull(Type::float()),
            'longitude' => Type::nonNull(Type::float()),
        ];
    }

    public function resolveCountryCode(IbanValidator $validator): string
    {
        return $validator->countryData->alpha2Code;
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

    public function resolveSubregion(IbanValidator $validator): string
    {
        return $validator->countryData->subregion;
    }

    public function resolvePopulation(IbanValidator $validator): int
    {
        return (int)$validator->countryData->population;
    }

    public function resolveLatitude(IbanValidator $validator): float
    {
        return round($validator->countryData->latlng[0], 2);
    }

    public function resolveLongitude(IbanValidator $validator): float
    {
        return round($validator->countryData->latlng[1], 2);
    }
}

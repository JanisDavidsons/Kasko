<?php

namespace app\queries;

use app\models\IbanValidator;
use app\types\IbanType;
use GraphQL\Type\Definition\Type;
use mgcode\graphql\GraphQLMutation;
use mgcode\graphql\GraphQLQuery;

class ValidateIbanQuery extends GraphQLQuery
{
    public function description(): string
    {
        return 'Validate IBAN';
    }

    public function type(): Type
    {
        return Type::nonNull(IbanType::type());
    }

    public function resolve()
    {
        $model = new IbanValidator([
            'iban' => 'BE71096123456769'
        ]);

        return $model;
    }
}

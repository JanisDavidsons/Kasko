<?php

namespace app\queries;

use GraphQL\Type\Definition\Type;
use mgcode\graphql\GraphQLQuery;

class IbanQuery extends GraphQLQuery
{
    public function description(): string
    {
        return 'Iban test query';
    }

    public function type(): Type
    {
        return Type::nonNull(Type::string());
    }

    public function resolve()
    {
        return 'iban test query';
    }
}

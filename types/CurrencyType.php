<?php

namespace app\types;

use GraphQL\Type\Definition\Type;
use mgcode\graphql\GraphQLType;
use stdClass;

class CurrencyType extends GraphQLType
{
    public function name(): string
    {
        return 'CurrencyType';
    }

    public function fields(): array
    {
        return [
            'name' => Type::nonNull(Type::string()),
            'code' => Type::nonNull(Type::string()),
            'symbol' => Type::nonNull(Type::string()),
        ];
    }

    public function resolveName(stdClass $currencyModel): string
    {
        return $currencyModel->name;
    }

    public function resolveCode(stdClass $currencyModel): string
    {
        return $currencyModel->code;
    }

    public function resolveSymbol(stdClass $currencyModel): string
    {
        return $currencyModel->symbol;
    }
}

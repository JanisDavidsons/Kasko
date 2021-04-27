<?php

namespace app\types;

use GraphQL\Type\Definition\Type;
use mgcode\graphql\GraphQLType;
use app\models\IbanValidator;

class IbanType extends GraphQLType
{
    public function name(): string
    {
        return 'IbanType';
    }

    public function fields(): array
    {
        return [
            'checksum' => Type::int(),
            'bbanBankIdentifier' => Type::int(),
            'bban' => Type::string()
        ];
    }

    public function resolveChecksum(IbanValidator $validator): int
    {
        return (int)$validator->ibanModel->checksum();
    }

    public function resolveBbanBankIdentifier(IbanValidator $validator): int
    {
        return (int)$validator->ibanModel->bbanBankIdentifier();
    }

    public function resolveBban(IbanValidator $validator)
    {
        return $validator->ibanModel->bban();
    }
}

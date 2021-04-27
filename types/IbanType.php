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
            'iban' => Type::string(),
            'bbanBankIdentifier' => Type::int(),
            'bban' => Type::string()
        ];
    }

    public function resolveIban(IbanValidator $validator): string
    {
        return $validator->ibanModel->getNormalizedIban();
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

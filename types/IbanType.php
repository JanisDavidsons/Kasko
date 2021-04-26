<?php

namespace app\types;

use GraphQL\Type\Definition\Type;
use mgcode\graphql\GraphQLType;
use app\models\IbanValidator;
use yii\bootstrap\Modal;

class IbanType extends GraphQLType
{
    public function name(): string
    {
        return 'IbanValidatorType';
    }

    public function fields(): array
    {
        return [
            'iban' => Type::nonNull(Type::string()),
            'isValid' => Type::boolean()
        ];
    }

    public function resolveIban(IbanValidator $model): string
    {
        return $model->iban;
    }

    public function resolveIsValid(IbanValidator $model): bool
    {
        return $model->validateIban();
    }
}

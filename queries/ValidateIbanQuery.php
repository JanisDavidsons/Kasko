<?php

namespace app\queries;

use GraphQL\Type\Definition\Type;
use mgcode\graphql\GraphQLQuery;
use app\types\IbanValidatorType;
use Iban\Validation\Validator;
use app\models\IbanValidator;
use Iban\Validation\Iban;

class ValidateIbanQuery extends GraphQLQuery
{
    public function description(): string
    {
        return 'Validate IBAN';
    }

    public function type(): Type
    {
        return Type::nonNull(IbanValidatorType::type());
    }

    public function args(): array
    {
        return [
            'iban' => Type::nonNull(Type::string())
        ];
    }

    public function resolve($root, array $args): IbanValidator
    {

        $ibanModel = new Iban($args['iban']);
        $validator = new Validator();

        $model = new IbanValidator($ibanModel, $validator);
        $model->validateIban();

        return $model;
    }
}

<?php

namespace app\models;

use mgcode\graphql\error\ValidatorException;
use yii\base\InvalidValueException;
use Iban\Validation\Validator;
use Iban\Validation\Iban;
use yii\httpclient\Client;
use stdClass;

class IbanValidator
{
    public Validator $validator;
    public Iban $ibanModel;
    public stdClass $countryData;

    public function __construct(Iban $iban, Validator $validator)
    {
        $this->ibanModel = $iban;
        $this->validator = $validator;
    }

    public function validateIban(): void
    {
        $this->validator->validate($this->ibanModel->getNormalizedIban());
        $errors = $this->validator->getViolations();

        if (count($errors) > 0) {
            throw ValidatorException::fromAttributes(['iban' => $errors]);
        } else {
            // We have valid IBAN, get info about country.
            $this->setCountryData();
        }
    }

    public function setCountryData(): void
    {
        $url = "https://restcountries.eu/rest/v2/alpha/" . $this->ibanModel->countryCode();

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl($url)
            ->send();
        if (!$response->isOk) {
            throw new InvalidValueException('Failed to load country contents. Code: ' . $response->getStatusCode() . '. Url: ' . $url);
        }

        $this->countryData = json_decode($response->content);
    }
}

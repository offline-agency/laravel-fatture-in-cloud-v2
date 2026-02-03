<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\Info;
use OfflineAgency\LaravelFattureInCloudV2\Tests\Fake\FakeResponse;

class SinglePaymentMethods extends FakeResponse
{
    public function getPaymentMethodsTypeFakeDetail(
        array $params = []
    ): array {
        return [
            'id' => $this->value($params, 'id', 1),
            'name'=> $this->value($params, 'name', 'fake_name'),
            'type' =>$this-> value($params, 'type', 'fake_type'),
            'is_default' => $this->value($params, 'is_default', 'true'),
            'default_payment_account' => (new DefaultPaymentAccount())->getDefaultPaymentAccountDetail($params),
            'detail' =>$this->value($params, 'detail', [
                'title'=>$this->value($params, 'title', 'fake_title'),
                'description'=>$this->value($params, 'description', 'fake_description'),
            ]),
            'bank_iban'=>$this->value($params, 'bank_iban', 'fake_bank_iban'),
            'bank_name'=>$this->value($params, 'bank_name', 'fake_bank_name'),
            'bank_beneficiary'=>$this->value($params, 'bank_beneficiary', 'fake_bank_beneficiary'),
            'ei_payment_method'=>$this->value($params, 'ei_payment_method', 'ei_payment_method'),
        ];
    }
}

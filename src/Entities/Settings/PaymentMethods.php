<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Settings;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class PaymentMethods extends AbstractEntity
{
    /**
     * @var int|null
     */
    public $id;

    /**
     * @var string|null
     */
    public $name;

    /**
     * @var string|null
     */
    public $type;

    /**
     * @var bool|null
     */
    public $is_default;

    /**
     * @var array
     */
    public $default_payment_account = [
        'id' => null,
        'name' => null,
        'type' => null,
        'iban' => null,
        'sia' => null,
        'cuc' => null,
        'virtual' => null,
    ];

    /**
     * @var array
     */
    public $details = [
        [
            'title' => null,
            'description' => null,
        ],
    ];

    /**
     * @var string|null
     */
    public $bank_iban;

    /**
     * @var string|null
     */
    public $bank_name;

    /**
     * @var string|null
     */
    public $bank_beneficiary;

    /**
     * @var string|null
     */
    public $ei_payment_method;

//    /**
//     * PaymentMethods constructor.
//     * @param array|object|null $data
//     */
//    public function __construct($data = null)
//    {
//        if ($data !== null) {
//            $this->fill((array)$data);
//        }
//    }
//
//    /**
//     * Fill the entity with an array of data.
//     *
//     * @param array $data
//     */
//    public function fill(array $data)
//    {
//        $this->id = isset($data['id']) ? (int)$data['id'] : null;
//        $this->name = $data['name'] ?? null;
//        $this->type = $data['type'] ?? null;
//        $this->is_default = $data['is_default'] ?? null;
//        $this->default_payment_account = $data['default_payment_account'] ?? [
//            'id' => null,
//            'name' => null,
//            'type' => null,
//            'iban' => null,
//            'sia' => null,
//            'cuc' => null,
//            'virtual' => null,
//        ];
//        $this->details = $data['details'] ?? [
//            [
//                'title' => null,
//                'description' => null,
//            ],
//        ];
//        $this->bank_iban = $data['bank_iban'] ?? null;
//        $this->bank_name = $data['bank_name'] ?? null;
//        $this->bank_beneficiary = $data['bank_beneficiary'] ?? null;
//        $this->ei_payment_method = $data['ei_payment_method'] ?? null;
//    }
//
//    /**
//     * Save the entity to the database.
//     * Placeholder method, implement your own logic.
//     */


    /*public function find($id): ?array
    {
        if ($id == 1) {
            return [
                'data' => [
                    'id' => 1,
                    'name' => 'Test Payment Method',
                    'type' => 'credit_card',
                    'is_default' => true,
                    'default_payment_account' => [
                        'id' => 1,
                        'name' => 'Default Account',
                        'type' => 'bank_account',
                        'iban' => 'IT60X0542811101000000123456',
                        'sia' => 'ABCDEF',
                        'cuc' => 'XYZ123',
                        'virtual' => false
                    ],
                    'details' => [
                        ['title' => 'Detail 1', 'description' => 'Description 1']
                    ],
                    'bank_iban' => 'IT60X0542811101000000123456',
                    'bank_name' => 'Test Bank',
                    'bank_beneficiary' => 'Test Beneficiary',
                    'ei_payment_method' => 'ei_method',
                ]
            ];
        }
        return null;
    }*/
}

<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Document;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;

class IssuedDocument extends AbstractEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var object
     */
    public $entity; //TODO: relate another class

    /**
     * @var string
     */
    public $type; //TODO: can be only some values

    /**
     * @var int
     */
    public $number;

    /**
     * @var string
     */
    public $numeration;

    /**
     * @var string
     */
    public $date; //TODO: date format

    /**
     * @var int
     */
    public $year;

    /**
     * @var object
     */
    public $currency; //TODO: relate another class

    /**
     * @var object
     */
    public $language; //TODO: relate another class

    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public $visible_subject;

    /**
     * @var string
     */
    public $rc_center;

    /**
     * @var string
     */
    public $notes;

    /**
     * @var float
     */
    public $rivalsa;

    /**
     * @var float
     */
    public $cassa;

    /**
     * @var float
     */
    public $amount_cassa;

    /**
     * @var float
     */
    public $cassa_taxable;

    /**
     * @var float
     */
    public $amount_cassa_taxable;

    /**
     * @var float
     */
    public $cassa2;

    /**
     * @var float
     */
    public $amount_cassa2;

    /**
     * @var float
     */
    public $cassa2_taxable;

    /**
     * @var float
     */
    public $amount_cassa2_taxable;

    /**
     * @var float
     */
    public $global_cassa_taxable;

    /**
     * @var float
     */
    public $amount_global_cassa_taxable;

    /**
     * @var float
     */
    public $withholding_tax;

    /**
     * @var float
     */
    public $withholding_tax_taxable;

    /**
     * @var float
     */
    public $other_withholding_tax;

    /**
     * @var float
     */
    public $stamp_duty;

    /**
     * @var object
     */
    public $payment_method; //TODO: relate another class

    /**
     * @var bool
     */
    public $use_split_payment;

    /**
     * @var bool
     */
    public $use_gross_prices;

    /**
     * @var bool
     */
    public $e_invoice;

    /**
     * @var object
     */
    public $ei_data; //TODO: relate another class

    /**
     * @var string
     */
    public $ei_cassa_type;

    /**
     * @var string
     */
    public $ei_cassa2_type;

    /**
     * @var string
     */
    public $ei_withholding_tax_causal;

    /**
     * @var string
     */
    public $ei_other_withholding_tax_type;

    /**
     * @var string
     */
    public $ei_other_withholding_tax_causal;

    /**
     * @var array
     */
    public $items_list; //TODO: relate another class

    /**
     * @var array
     */
    public $payments_list; //TODO: relate another class

    /**
     * @var object
     */
    public $template; //TODO: relate another class

    /**
     * @var object
     */
    public $delivery_note_template; //TODO: relate another class

    /**
     * @var object
     */
    public $acc_inv_template; //TODO: relate another class

    /**
     * @var int
     */
    public $h_margins;

    /**
     * @var int
     */
    public $v_margins;

    /**
     * @var bool
     */
    public $show_payments;

    /**
     * @var bool
     */
    public $show_payment_method;

    /**
     * @var string
     */
    public $show_totals; //TODO: can be only some values

    /**
     * @var bool
     */
    public $show_paypal_button;

    /**
     * @var bool
     */
    public $show_notification_button;

    /**
     * @var bool
     */
    public $show_tspay_button;

    /**
     * @var bool
     */
    public $delivery_note;

    /**
     * @var bool
     */
    public $accompanying_invoice;

    /**
     * @var int
     */
    public $dn_number;

    /**
     * @var string
     */
    public $dn_date; //TODO: date format

    /**
     * @var string
     */
    public $dn_ai_packages_number;

    /**
     * @var string
     */
    public $dn_ai_weight;

    /**
     * @var string
     */
    public $dn_ai_causal;

    /**
     * @var string
     */
    public $dn_ai_destination;

    /**
     * @var string
     */
    public $dn_ai_transporter;

    /**
     * @var string
     */
    public $dn_ai_notes;

    /**
     * @var bool
     */
    public $is_marked;

    /**
     * @var float
     */
    public $amount_net;

    /**
     * @var float
     */
    public $amount_vat;

    /**
     * @var float
     */
    public $amount_gross;

    /**
     * @var float
     */
    public $amount_due_discount;

    /**
     * @var float
     */
    public $amount_rivalsa;

    /**
     * @var float
     */
    public $amount_rivalsa_taxable;

    /**
     * @var float
     */
    public $amount_withholding_tax;

    /**
     * @var float
     */
    public $amount_withholding_tax_taxable;

    /**
     * @var float
     */
    public $amount_other_withholding_tax;

    /**
     * @var float
     */
    public $amount_other_withholding_tax_taxable;

    /**
     * @var float
     */
    public $amount_enasarco_taxable;

    /**
     * @var object
     */
    public $extra_data; //TODO: relate another class

    /**
     * @var string
     */
    public $seen_date; //TODO: date format

    /**
     * @var string
     */
    public $next_due_date; //TODO: date format

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $attachment_url;

    /**
     * @var object
     */
    public $ei_raw; //TODO: relate another class

    /**
     * @var string
     */
    public $ei_status; //TODO: can be only some values

    /**
     * @var bool
     */
    public $locked;

    /**
     * @var bool
     */
    public $has_ts_pay_pending_payment;

    /**
     * @var bool
     */
    public $is_first_e_invoice;
}

<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\Product;

use OfflineAgency\LaravelFattureInCloudV2\Entities\AbstractEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Product\RecievedDocuments as ProductEntity;

class ListReceivedDocuments extends AbstractEntity{

    public $id;
    public $product_id;
    public $code;
    public $name;
    public $measure;
    public $net_price;
    public $category;
    public $qty;
}

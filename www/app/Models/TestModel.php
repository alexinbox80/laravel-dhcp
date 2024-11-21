<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;

/*
$price = TestModel::where('cd_tp', 1)
         ->where(TestModel::convertColumnName('customer_number'), $customerNumber)
         ->where(TestModel::convertColumnName('item_number'), $itemNumber)
         ->first();
 */


/**
 * ERPPriceTranslator Model
 */
class TestModel extends BaseModel
{
    /** @var array  */
    static protected $columns = [
        'item_number' => 'cd_tp_1_item_no',
        'customer_number' => 'cd_tp_1_cust_no',
        'customer_type' => 'cd_tp_3_cust_type',
        'product_category' => 'cd_tp_2_prod_cat',
    ];

    // Allows for override like this if you need different getters and setters.
    public function customerNumber(): Attribute
    {
        return Attribute::make(
            get: fn() => trim($this->getAttribute('cd_tp_1_cust_no'))
        );
    }
}

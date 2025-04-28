<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
     * Return the collection of products
     */
    public function collection()
    {
        return Product::select(
            'fldName',
            'fldDescription',
            'fldShortDescription',
            'fldPrice',
            'fldCategoryID',
            'fldBrand',
            'fldFDARegistration',
            'fldExpiryDate',
            'fldMaterial',
            'fldWeight',
            'fldWidth',
            'fldLength',
            'fldHeight',
            'fldDimension',
            'fldUnit',
            'fldWarranty',
            'fldWarrantyPolicy',
            'fldCondition',
            'fldSpecialPrice',
            'fldVariation1',
            'fldVariation2',
            'fldIsBattery',
            'fldIsFlammable',
            'fldIsLiquid',
            'fldIsPublished',
            'fldIsCompanyOwned',
            'fldIsSoldOut',
            'fldIsVisible',
            'fldImage'
        )->get();
    }

    /**
     * Set the headings (column names)
     */
    public function headings(): array
    {
        return [
            'fldName',
            'fldDescription',
            'fldShortDescription',
            'fldPrice',
            'fldCategoryID',
            'fldBrand',
            'fldFDARegistration',
            'fldExpiryDate',
            'fldMaterial',
            'fldWeight',
            'fldWidth',
            'fldLength',
            'fldHeight',
            'fldDimension',
            'fldUnit',
            'fldWarranty',
            'fldWarrantyPolicy',
            'fldCondition',
            'fldSpecialPrice',
            'fldVariation1',
            'fldVariation2',
            'fldIsBattery',
            'fldIsFlammable',
            'fldIsLiquid',
            'fldIsPublished',
            'fldIsCompanyOwned',
            'fldIsSoldOut',
            'fldIsVisible',
            'fldImage',
        ];
    }
}

<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Add this if your CSV/XLSX has headings

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
     * Transform each row into a Product model instance.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        
        return new Product([
            'fldName' => $row['fldname'],
            'fldDescription' => $row['flddescription'],  // Fixed typo
            'fldShortDescription' => $row['fldshortdescription'],
            'fldPrice' => $row['fldprice'],
            'fldCategoryID' => $row['fldcategoryid'],
            'fldBrand' => $row['fldbrand'],
            'fldFDARegistration' => $row['fldfdaregistration'],
            'fldExpiryDate' => $row['fldexpirydate'],
            'fldMaterial' => $row['fldmaterial'],
            'fldWeight' => $row['fldweight'],
            'fldWidth' => $row['fldwidth'],
            'fldLength' => $row['fldlength'],
            'fldHeight' => $row['fldheight'],
            'fldDimension' => $row['flddimension'],
            'fldUnit' => $row['fldunit'],
            'fldWarranty' => $row['fldwarranty'],
            'fldWarrantyPolicy' => $row['fldwarrantypolicy'],
            'fldCondition' => $row['fldcondition'],
            'fldSpecialPrice' => $row['fldspecialprice'],
            'fldVariation1' => $row['fldvariation1'],
            'fldVariation2' => $row['fldvariation2'],
            'fldIsBattery' => $row['fldisbattery'],
            'fldIsFlammable' => $row['fldisflammable'],
            'fldIsLiquid' => $row['fldisliquid'],
            'fldIsPublished' => $row['fldispublished'],
            'fldIsCompanyOwned' => $row['fldiscompanyowned'],
            'fldIsSoldOut' => $row['fldissoldout'],
            'fldIsVisible' => $row['fldisvisible'],
            'fldImage' => $row['fldimage'],
        ]);
        
    }
}

<?php

namespace App\Services;

use App\Models\Variation;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Support\Facades\Storage;

class VariationService
{
    public function createOrUpdateVariations($product, $variationsData, $request, $attributes = [])
    {
        foreach ($variationsData as $index => $variationData) {
            $variation = isset($variationData['id']) ? Variation::find($variationData['id']) : new Variation();
            if ($variation->product_id !== $product->id && !$variation->exists) {
                $variation->product_id = $product->id;
            }

            $price = str_replace(',', '.', $variationData['price'] ?? '0');
            $salePrice = str_replace(',', '.', $variationData['sale_price'] ?? '0');

            $variation->name = $variationData['name'] ?? $variation->name;
            $variation->sku = $variationData['sku'] ?? $variation->sku;
            $variation->price = is_numeric($price) ? floatval($price) : 0;
            $variation->sale_price = is_numeric($salePrice) ? floatval($salePrice) : null;
            $variation->stock_quantity = (int)($variationData['stock_quantity'] ?? 0);
            $variation->status = $variationData['status'] ?? 'in_stock';

            if (!empty($attributes) && !$variation->exists) {
                $variationDetails = explode(' - ', $variationData['name']);
                foreach ($attributes as $attrIndex => $attribute) {
                    $value = $variationDetails[$attrIndex] ?? null;
                    if ($value) {
                        if ($attribute['type'] === 'color') {
                            $color = Color::where('name', $value)->first();
                            if ($color) {
                                $variation->color_id = $color->id;
                            }
                        } elseif ($attribute['type'] === 'size') {
                            $size = Size::where('name', $value)->first();
                            if ($size) {
                                $variation->size_id = $size->id;
                            }
                        }
                    }
                }
            }

            if (!$variation->save()) {
                throw new \Exception("Không thể lưu biến thể tại index {$index}.");
            }

            if ($request->hasFile("variations.{$index}.image")) {
                $image = $request->file("variations.{$index}.image");
                if ($image->isValid()) {
                    $path = $image->store('images/products', 'public');
                    $variation->images()->delete();
                    $variation->images()->create(['image_path' => $path]);
                }
            }
        }
    }
}

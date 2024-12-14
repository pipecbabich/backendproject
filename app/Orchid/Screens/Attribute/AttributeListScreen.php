<?php

namespace App\Orchid\Screens\Attribute;

use App\Facades\Product as FacadesProduct;
use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use App\Models\Product;
use App\Orchid\Layouts\Attribute\AttributeListLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class AttributeListScreen extends Screen
{
    public $product;

    public function query(Product $product): iterable
    {
        return [
            'product' => $product,
            'attributes' => $product->attribute
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Список характеристик товара "' . $this->product->name . '"';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать характеристики')
                ->method('createAttribute')
                ->icon('bs.plus-circle')
                ->canSee(is_null($this->product->attribute()->first())),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            AttributeListLayout::class,
            Layout::modal('value', Layout::rows([
                Input::make('attribute.value')
            ]))->async('asyncGetAttribute')
        ];
    }

    public function asyncGetAttribute(Attribute $attribute)
    {
        return [
            'attribute' => $attribute
        ];
    }

    public function editValue(Attribute $attribute, AttributeRequest $request)
    {
        $attribute->update([
            'name' => $attribute->name,
            'value' => $request->input('attribute')['value'],
            'product_id' => $attribute->product->id
        ]);
        return redirect()->route('platform.attributes.list', [$attribute->product]);
    }

    public function createAttribute()
    {
        FacadesProduct::setProduct($this->product)->createAttribute();

        return redirect()->route('platform.attributes.list', [$this->product]);
    }
}

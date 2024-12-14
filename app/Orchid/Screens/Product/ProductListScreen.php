<?php

namespace App\Orchid\Screens\Product;

use App\Models\Attribute;
use App\Models\Product;
use App\Orchid\Layouts\Product\ProductListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProductListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'products' => Product::all()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Товары';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить товар')
                ->icon('bs.plus-circle')
                ->route('platform.product.edit')
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
            ProductListLayout::class,
        ];
    }

    public function remove($id)
    {
        $product = Product::find($id);
        
        $product->delete();

        Toast::error('Удалено');

        return redirect()->route('platform.product.list');
    }

    public function status($id)
    {
        $product = Product::find($id);

        if($product->status === 1){
            $product->status = 0;
            $product->save();
            return redirect()->route('platform.product.list');
        } else {
            $product->status = 1;
            $product->save();
            return redirect()->route('platform.product.list');
        }
    }
}

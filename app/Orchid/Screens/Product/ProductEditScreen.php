<?php

namespace App\Orchid\Screens\Product;

use App\Facades\Product as FacadesProduct;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProductEditScreen extends Screen
{
    public $product;

    public function query(Product $product): iterable
    {
        return [
            'product' => $product
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->product->name ?? 'Новый товар';
    }


    public function commandBar(): iterable
    {
        return [
            Button::make('Создать')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->product->exists),

            Button::make('Сохранить')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee($this->product->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->product->exists),
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
            Layout::rows([
                Group::make([
                    Input::make('product.name')
                        ->title('Название товара')
                        ->required(),

                    CheckBox::make('product.status')
                        ->title('Статус')
                        ->placeholder('Выводить на сайте')
                        ->canSee($this->product->exists)
                        ->sendTrueOrFalse(),
                ]),

                Group::make([
                    Input::make('product.price')
                        ->title('Цена'),

                    Select::make("product.category_id")
                        ->title('Категория')
                        ->fromModel(Category::class, 'name')
                        ->required()
                ]),
                
                SimpleMDE::make('product.description')
                    ->title('Описание'),
            ])
        ];
    }

    public function createOrUpdate(ProductRequest $request)
    {
        if ($this->product->exists){
            $product = FacadesProduct::setProduct($this->product)->update($request->get('product'));
            Toast::success('Успешно отредактировано!');
            return redirect()->route('platform.product.list');
        } elseif (!$this->product->exists){
            $product = FacadesProduct::create($request->get('product'));
            Toast::success('Новый товар "' . $product->name . '" создан. Пожалуйста заполните характеристики.');
        } else {
            Toast::error('Ошибка');
        }

        return redirect()->route('platform.attributes.list', [$product]);
    }

    public function remove()
    {
        $this->product->delete();

        Toast::error('Удалено');

        return redirect()->route('platform.product.list');
    }
}

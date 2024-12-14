<?php

namespace App\Orchid\Layouts\Product;

use App\Models\Product;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;

class ProductListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'products';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', 'Название'),
            TD::make('price', 'Цена за 1 м³')->render(function (Product $product) {
                return $product->price . ' руб.';
            }),
            TD::make('category_id', 'Категория')->render(function (Product $product) {
                return $product->category->name;
            }),
            TD::make('status', 'Статус')
                ->align(TD::ALIGN_CENTER)
                ->render(function (Product $product) {
                    if ($product->status === 0) {
                        return Button::make('Не активно')->method('status', ['id' => $product->id])->icon('toggle-off');
                    } else {
                        return Button::make('Активно')->method('status', ['id' => $product->id])->icon('toggle-on');
                    }
                }),
            TD::make('description', 'Описание')->defaultHidden(),
            TD::make('created_at', 'Создание')->defaultHidden(),
            TD::make('updated_at', 'Последнее изменение')->defaultHidden(),
            TD::make(__('Характеристики'))
                ->align(TD::ALIGN_CENTER)
                ->render(function (Product $product) {
                    return Link::make('Открыть')->route('platform.attributes.list', [$product])->icon('bs.clipboard2');
                }),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Product $product) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.product.edit', [$product])
                            ->icon('bs.pencil'),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Подтвердите, что хотите удалить товар "' . $product->name) . '"')
                            ->method('remove', [
                                'id' => $product->id,
                            ]),
                    ])),
        ];
    }
}

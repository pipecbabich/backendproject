<?php

namespace App\Orchid\Layouts\Attribute;

use App\Models\Attribute;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class AttributeListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'attributes';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', 'Название'),
            TD::make('value', 'Значение')->render(function (Attribute $attribute) {
                return  ModalToggle::make($attribute->value)
                    ->modalTitle($attribute->name)
                    ->modal('value')
                    ->method('editValue')
                    ->asyncParameters(['attribute' => $attribute->id]);
            }),
            TD::make('Действия')->render(function (Attribute $attribute) {
                return  ModalToggle::make('Редактировать')
                    ->modalTitle($attribute->name)
                    ->modal('value')
                    ->icon('pencil')
                    ->method('editValue')
                    ->asyncParameters(['attribute' => $attribute->id]);
            })
        ];
    }
}

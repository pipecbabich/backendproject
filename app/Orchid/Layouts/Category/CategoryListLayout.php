<?php

namespace App\Orchid\Layouts\Category;

use App\Models\Category;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryListLayout extends Table
{
    protected $target = 'categories';

    protected function columns(): iterable
    {
        return [
            TD::make('name', 'Название')->render(function(Category $category){
                return Link::make($category->name)->route('platform.category.edit', [$category]);
            }),
            TD::make('created_at', 'Создание')->defaultHidden(),
            TD::make('updated_at', 'Последнее изменение')->defaultHidden(),
        ];
    }
}

<?php

namespace App\Orchid\Screens\Category;

use App\Facades\Category as FacadesCategory;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoryEditScreen extends Screen
{
    public $category;

    public function query(Category $category): iterable
    {
        return [
            'category' => $category
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->category->exists ? 'Редактирование' : 'Создать новую категорию';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->category->exists),

            Button::make('Редактировать')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee($this->category->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->category->exists),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('category.name')
                    ->title('Название категории'),
            ])
        ];
        
    }

    public function createOrUpdate(CategoryRequest $request)
    {
        if ($this->category->exists){
            FacadesCategory::setCategory($this->category)->update($request->get('category'));
            Toast::success('Успешно отредактировано!');
        } elseif (!$this->category->exists){
            $category = FacadesCategory::create($request->get('category'));
            Toast::success('Успешно создана новая категория ' . $category->name);
        } else {
            Toast::error('Ошибка');
        }

        return redirect()->route('platform.category.list');
    }

    public function remove()
    {
        $this->category->delete();

        Toast::success('Удалено...');

        return redirect()->route('platform.category.list');
    }
}

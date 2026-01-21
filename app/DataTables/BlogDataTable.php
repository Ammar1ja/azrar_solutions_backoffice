<?php

namespace App\DataTables;

use App\Models\Blog;
use App\Models\Project;
use App\Models\Service;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class BlogDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Service> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('image', function ($row) {
                if (!$row->image) {
                    return '';
                }
                $url = asset('storage/' . $row->image);
                return '<img src="' . $url . '" border="0" width="50" class="img-rounded" align="center" />';
            })

        
            ->addColumn('categories', function ($row) {
                $categories = $row->Categories;
                $badges = '';
                foreach ($categories as $category) {
                    $badges .= '<span class="badge bg-primary me-1 mb-1">' . $category->name . '</span>';
                }
                return $badges;
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.blog.edit', $row->id);
                $deleteFunction = "deleteFunction('".route('admin.blog.destroy', $row->id)."')";
                return '<div class="d-flex flex-row gap-2 align-items-center">
                <a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>
                <button onclick="' . $deleteFunction . '" class="btn btn-sm btn-danger">Delete</button>

                        </div>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '';
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at ? $row->updated_at->format('Y-m-d H:i:s') : '';
            })
       ->editColumn('description', function ($row) {
    $text = strip_tags($row->description);

    return strlen($text) > 50
        ? substr($text, 0, 50) . '...'
        : $text;
})

            ->rawColumns(['image', 'categories','action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Service>
     */
    public function query(Blog $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['Categories','Tags'])
            ->withCount('Views')
            ->when($this->request()->filled('category_id'), function ($query) {
                $categoryId = $this->request()->get('category_id');
                $query->whereHas('Categories', function ($q) use ($categoryId) {
                    $q->where('categories.id', $categoryId);
                });
            })
          
          
        ;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('data-table')  
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->ajaxWithForm(url()->current(),'#filter-form')
            ->orderBy(1)
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id'),
            Column::make('title')->content('-'),
            Column::make('description')->content('-'),

            Column::make('image')
            ->orderable(false)
            ->searchable(false)
            ->content('-'),
          
            Column::make('categories')
            ->orderable(false)
            ->searchable(false)
            ->content('-'),



             Column::make('views_count')
            ->orderable(false)
            ->searchable(false)
            ->content('-'),

            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Service_' . date('YmdHis');
    }
}

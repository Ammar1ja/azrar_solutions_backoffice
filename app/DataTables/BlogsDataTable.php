<?php

namespace App\DataTables;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BlogsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // 1. Handle the Category Name (Relationship)
            ->addColumn('category', function (Blog $blog) {
                return $blog->category ? $blog->category->name : 'N/A';
            })
            // 2. Handle the Nested Created At Date                     
            ->editColumn('created_at', function (Blog $blog) {
                return $blog->created_at ? $blog->created_at->format('Y-m-d') : '';
            })
            // 3. Add Image Preview
            ->editColumn('image', function (Blog $blog) {
                return '<img src="/uploads/blogs/' . $blog->image . '" width="50" class="img-thumbnail" />';
            })
            // 4. Action Buttons (Update & Delete)
            ->addColumn('action', function ($row) {
                $updateBtn = '<a href="' . route('blogs.edit', $row->id) . '" class="btn btn-sm btn-primary mx-1"><i class="fa fa-edit"></i> Edit</a>';
                $deleteBtn = '<button class="btn btn-sm btn-danger mx-1" onclick="deleteBlog(' . $row->id . ')"><i class="fa fa-trash"></i> Delete</button>';
                return $updateBtn . $deleteBtn;
            })
            ->rawColumns(['action', 'image']) // Allow HTML rendering for these columns
            ->setRowId('id');
    }

    public function query(Blog $model): QueryBuilder
    {
        // Eager load category to prevent N+1 issues
        return $model->newQuery()->with('category');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('blogs-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('image')->title('Thumbnail'),
            Column::make('title'),
            Column::make('category')->data('category.name')->title('Category'), // Path to nested name
            Column::make('description'),
            Column::make('created_at')->title('Date Created'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(160)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Blogs_' . date('YmdHis');
    }
}

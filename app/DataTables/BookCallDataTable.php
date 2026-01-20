<?php

namespace App\DataTables;

use App\Models\Blog;
use App\Models\BookCall;
use App\Models\Project;
use App\Models\Service;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class BookCallDatatable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Service> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
          
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '';
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at ? $row->updated_at->format('Y-m-d H:i:s') : '';
            })
     

            ->rawColumns([])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Service>
     */
    public function query(BookCall $model): QueryBuilder
    {
        return $model->newQuery()
          
          
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
            Column::make('full_name')->content('-'),
            Column::make('email')->content('-'),
            Column::make(data: 'time')->content('-'),
            Column::make('created_at'),
            Column::make('updated_at'),
        
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

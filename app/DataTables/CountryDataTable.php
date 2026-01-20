<?php

namespace App\DataTables;

use App\Models\Country;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CountryDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                // Action buttons logic
                $editUrl = route('admin.country.edit', $row->id);
                // $deleteUrl = route('admin.country.destroy', $row);
                $deleteFunction = "deleteFunction('" . route('admin.country.destroy', $row->id) . "')";
                return '<div class="d-flex gap-2">
                            <a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>
                <button onclick="' . $deleteFunction . '" class="btn btn-sm btn-danger">Delete</button>
                            
                        </div>';
            })
            ->addColumn('flag', function ($row) {
                if (!$row->flag) {
                    return '';
                }
                $url = asset('storage/' . $row->flag);
                return '<img src="' . $url . '" border="0" width="50" class="img-rounded" align="center" />';
            })
            ->editColumn('created_at', fn($row) => $row->created_at->format('Y-m-d'))
            ->rawColumns(['action','flag'])
            ->setRowId('id');
    }

    public function query(Country $model): QueryBuilder
    {
        return $model->newQuery();
    }

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

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('flag')->title('Flag'),
            Column::make('name_en')->title('Name (EN)'),
            Column::make('name_ar')->title('Name (AR)'),
            Column::make('iso2')->title('ISO'),
            Column::make('created_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Country_' . date('YmdHis');
    }
}

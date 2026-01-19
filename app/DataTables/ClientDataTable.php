<?php

namespace App\DataTables;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ClientDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('client_logo', function ($row) {
                if (!$row->client_logo) return '-';
                $url = asset('storage/' . $row->client_logo);
                return '<img src="' . $url . '" width="50" class="img-thumbnail" />';
            })
            ->addColumn('country', function ($row) {
                return $row->country ? $row->country->name : '-';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.client.edit', $row->id);
                $deleteUrl = route('admin.client.destroy', $row->id);
                return '<div class="d-flex gap-2">
                            <a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>
                            <button onclick="deleteFunction(\'' . $deleteUrl . '\')" class="btn btn-sm btn-danger">Delete</button>
                        </div>';
            })
            ->editColumn('created_at', fn($row) => $row->created_at->format('Y-m-d'))
            ->rawColumns(['client_logo', 'action'])
            ->setRowId('id');
    }

    public function query(Client $model): QueryBuilder
    {
        // Eager load country to prevent N+1 query issues
        return $model->newQuery()->with('country')
            ->when($this->request()->filled('name'), function ($query) {
                $name = $this->request()->get('name');
                $query->where('client_en_name', 'like', "%$name%")
                    ->orWhere('client_ar_name', 'like', "%$name%");
            });
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('client-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->ajaxWithForm(url()->current(), '#filter-form')
            ->orderBy(0)
            ->buttons([
                Button::make('excel'),
                Button::make('pdf'),
                Button::make('print'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('client_logo')->title('Logo')->orderable(false)->searchable(false),
            Column::make('client_en_name')->title('Name (EN)'),
            Column::make('client_ar_name')->title('Name (AR)'),
            Column::make('country')->title('Country')->orderable(false),
            Column::make('created_at'),
            Column::computed('action')->width(120)->addClass('text-center'),
        ];
    }
}

<?php

namespace App\DataTables;

use App\Models\Project;
use App\Models\Service;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class ProjectDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Service> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('thumbnail', function ($row) {
                if (!$row->thumbnail) {
                    return '';
                }
                $url = asset('storage/' . $row->thumbnail);
                return '<img src="' . $url . '" border="0" width="50" class="img-rounded" align="center" />';
            })

        
            ->addColumn('services', function ($row) {
                $services = $row->Services;
                $badges = '';
                foreach ($services as $service) {
                    $badges .= '<span class="badge bg-primary me-1 mb-1">' . $service->en_name . '</span>';
                }
                return $badges;
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.project.edit', $row->id);
                $deleteFunction = "deleteFunction('".route('admin.project.destroy', $row->id)."')";
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
            ->rawColumns(['thumbnail', 'service', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Service>
     */
    public function query(Project $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['Services','Client'])
            ->when(request()->has('service_id') && request('service_id') != '', function ($query) {
                $serviceId = request('service_id');
                $query->whereHas('Services', function ($q) use ($serviceId) {
                    $q->where('services.id', $serviceId);
                });
            })
            ->when(request()->has('client_id') && request('client_id') != '', function ($query) {
                $clientId = request('client_id');
                $query->where('client_id', $clientId);
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
            Column::make('en_title')->content('-'),
            Column::make('en_description')->content('-'),
            Column::make('thumbnail')
            ->orderable(false)
            ->searchable(false)
            ->content('-'),
          
            Column::make('services')
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

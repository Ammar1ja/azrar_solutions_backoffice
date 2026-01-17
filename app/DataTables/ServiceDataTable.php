<?php

namespace App\DataTables;

use App\Models\Service;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class ServiceDataTable extends DataTable
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

            ->addColumn('icon', function ($row) {
                if (!$row->icon) {
                    return '';
                }
                $url = asset('storage/' . $row->icon);
                return '<img src="' . $url . '" border="0" width="50" class="img-rounded" align="center" />';
            })
            ->addColumn('features', function ($row) {
                $features = $row->Features;
                $badges = '';
                foreach ($features as $feature) {
                    $badges .= '<span class="badge bg-primary me-1 mb-1">' . $feature->en_name . '</span>';
                }
                return $badges;
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.service.edit', $row->id);
                $deleteUrl = route('admin.service.destroy', $row->id);
                return '<div class="d-flex flex-row gap-2 align-items-center">
                <a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>
                <button href="' . $editUrl . '" class="btn btn-sm btn-danger">Delete</button>

                        </div>';
            })
            ->rawColumns(['image', 'icon', 'features', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Service>
     */
    public function query(Service $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('Features')
            ->when($this->request()->filled('feature'), function ($query) {
                $feature = $this->request()->get('feature');
                $query->whereHas('Features', function ($q) use ($feature) {
                    $q
                    ->where('en_name', 'like',"%".$feature."%")
                    ->orWhere('ar_name', 'like',"%".$feature."%")
                    ;
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
            Column::make('en_title')->content('-'),
            Column::make('en_description')->content('-'),
            Column::make('image')
            ->orderable(false)
            ->searchable(false)
            ->content('-'),
            Column::make('icon')
            ->orderable(false)
            ->searchable(false)
            ->content('-'),
            Column::make('features')
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

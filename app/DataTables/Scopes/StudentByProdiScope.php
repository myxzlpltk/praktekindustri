<?php

namespace App\DataTables\Scopes;

use App\Models\Prodi;
use Yajra\DataTables\Contracts\DataTableScope;

class StudentByProdiScope implements DataTableScope{

	private $prodi;

	public function __construct(Prodi $prodi){
		$this->prodi = $prodi;
	}

	/**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query){
		return $query->where('prodi_id', $this->prodi->id);
	}
}

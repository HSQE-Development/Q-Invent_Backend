<?php

namespace App\Core\Domain\Entities;

class PaginationEntity
{
    public $data;
    public $total;
    public $count;
    public $perPage;
    public $currentPage;
    public $lastPage;
    public $nextPageUrl;
    public $previousPageUrl;

    public function __construct($data, $total, $count, $perPage, $currentPage, $lastPage, $nextPageUrl, $previousPageUrl)
    {
        $this->data = $data;
        $this->total = $total;
        $this->count = $count;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        $this->lastPage = $lastPage;
        $this->nextPageUrl = $nextPageUrl;
        $this->previousPageUrl = $previousPageUrl;
    }

    /**
     * Convierte el objeto PaginationEntity a un array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'data' => $this->data,
            'total' => $this->total,
            'count' => $this->count,
            'per_page' => $this->perPage,
            'current_page' => $this->currentPage,
            'last_page' => $this->lastPage,
            'next_page_url' => $this->nextPageUrl,
            'previous_page_url' => $this->previousPageUrl,
        ];
    }
}

<?php

namespace App\Traits;

trait Paginates
{
    public function paginate(int $total, int $perPage, int $currentPage): object
    {
        return (object) [
            'current_page' => $currentPage,
            'last_page' => $lastPage = ceil($total / $perPage),
            'links' => $this->generatePaginationLinks($currentPage, $lastPage),
        ];
    }

    private function generatePaginationLinks(int $currentPage, int $lastPage): object
    {
        return (object) [
            'prev' => $currentPage > 1 ? route('dashboard', ['page' => $currentPage - 1]) : null,
            'next' => $currentPage < $lastPage ? route('dashboard', ['page' => $currentPage + 1]) : null,
        ];
    }
}

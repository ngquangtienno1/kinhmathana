<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->query->get()->map(function ($customer) {
            return [
                'ID' => $customer->id,
                'Họ tên' => $customer->user->name ?? '',
                'Email' => $customer->user->email ?? '',
                'Số điện thoại' => $customer->user->phone ?? '',
                'Số đơn' => $customer->total_orders,
                'Tổng chi tiêu' => $customer->total_spent,
                'Loại khách hàng' => $customer->customer_type,
                'Ngày đăng ký' => $customer->created_at->format('d/m/Y H:i'),
            ];
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Họ tên',
            'Email',
            'Số điện thoại',
            'Số đơn',
            'Tổng chi tiêu',
            'Loại khách hàng',
            'Ngày đăng ký',
        ];
    }
}

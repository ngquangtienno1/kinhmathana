<?php

namespace App\Traits;

use Illuminate\Mail\Mailables\Envelope;

trait HasDepartmentEmail
{
    protected function getDepartmentEmail(string $department): array
    {
        return config('mail.department_emails.' . $department);
    }

    public function from(string $department): self
    {
        $emailConfig = $this->getDepartmentEmail($department);
        return $this->from($emailConfig['address'], $emailConfig['name']);
    }
} 
<?php

use App\Services\UploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

if (! function_exists('formatMoney')) {
    function formatMoney(float|int|string|null $value): string
    {
        return 'R$ '.number_format((float) $value, 2, ',', '.');
    }
}

if (! function_exists('formatDate')) {
    function formatDate(DateTimeInterface|string|null $value, string $format = 'd/m/Y'): string
    {
        return $value ? \Illuminate\Support\Carbon::parse($value)->locale('pt_BR')->translatedFormat($format) : '—';
    }
}

if (! function_exists('generateSlug')) {
    function generateSlug(string $value): string
    {
        return Str::slug($value);
    }
}

if (! function_exists('imageUrl')) {
    function imageUrl(?string $path): ?string
    {
        return app(UploadService::class)->url($path);
    }
}

if (! function_exists('uploadImage')) {
    function uploadImage(UploadedFile $file, string $directory): string
    {
        return app(UploadService::class)->store($file, $directory);
    }
}

if (! function_exists('deleteImage')) {
    function deleteImage(?string $path): void
    {
        app(UploadService::class)->delete($path);
    }
}

if (! function_exists('statusBadge')) {
    function statusBadge(string $status): HtmlString
    {
        $labels = ['active' => 'Ativo', 'inactive' => 'Inativo', 'pending' => 'Pendente', 'completed' => 'Concluído', 'cancelled' => 'Cancelado'];
        $classes = ['active' => 'success', 'completed' => 'success', 'pending' => 'warning', 'inactive' => 'secondary', 'cancelled' => 'danger'];
        $label = e($labels[$status] ?? ucfirst($status));
        $class = $classes[$status] ?? 'secondary';

        return new HtmlString('<span class="badge text-bg-'.$class.'">'.$label.'</span>');
    }
}

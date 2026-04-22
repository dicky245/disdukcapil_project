<div class="border rounded-lg p-4 text-center hover:shadow">
    <p class="text-sm font-semibold mb-3">{{ $label }}</p>

    <a href="{{ route('admin.lihat-berkas', [
        'uuid' => $berkas->uuid,
        'jenis' => $jenis,
        'field' => $field
    ]) }}"
    target="_blank"
    class="block w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
        Lihat Berkas
    </a>
</div>
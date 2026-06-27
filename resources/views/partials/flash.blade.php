@if (session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-900" role="alert">
        <span class="mt-0.5 text-emerald-600" aria-hidden="true">✓</span>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
@endif

@if (session('error'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-900" role="alert">
        <span class="mt-0.5 text-red-600" aria-hidden="true">!</span>
        <p class="text-sm font-medium">{{ session('error') }}</p>
    </div>
@endif

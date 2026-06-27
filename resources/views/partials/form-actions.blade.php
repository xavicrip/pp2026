<div class="mt-8 -mx-6 -mb-6 flex flex-col-reverse gap-3 rounded-b-xl border-t border-slate-200 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
    <a href="{{ $cancelUrl }}"
       class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
        {{ $cancelLabel ?? 'Cancelar' }}
    </a>
    <button type="submit"
            class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
        {{ $submitLabel ?? 'Guardar' }}
    </button>
</div>

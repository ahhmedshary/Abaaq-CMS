@props(['label', 'name', 'current' => ''])

<div x-data="{
    preview: '{{ $current }}',
    loading: false,
    async pick(e) {
        const file = e.target.files[0];
        if (!file) return;
        this.loading = true;

        const fd = new FormData();
        fd.append('image', file);
        fd.append('_token', document.querySelector('meta[name=csrf-token]').content);

        const res  = await fetch('{{ route('admin.upload-image') }}', { method: 'POST', body: fd });
        const data = await res.json();

        this.preview = data.url;
        this.loading = false;
    }
}">
    <label class="text-sm text-muted block mb-2">{{ $label }}</label>

    {{-- Hidden input that holds the final URL sent with the form --}}
    <input type="hidden" :value="preview" name="{{ $name }}">

    {{-- Preview --}}
    <div class="mb-3">
        <template x-if="preview">
            <img :src="preview" class="w-40 h-28 object-cover rounded-xl border border-line">
        </template>
        <template x-if="!preview">
            <div class="w-40 h-28 rounded-xl border border-dashed border-line flex items-center justify-center text-muted text-xs">
                لا توجد صورة
            </div>
        </template>
    </div>

    {{-- File button --}}
    <label class="cursor-pointer inline-flex items-center gap-2 border border-line rounded-lg px-4 py-2 text-sm hover:border-accent hover:text-accent transition">
        <template x-if="!loading">
            <span>📁 اختر صورة</span>
        </template>
        <template x-if="loading">
            <span class="text-muted">⏳ جاري الرفع...</span>
        </template>
        <input type="file" accept="image/*" class="hidden" @change="pick">
    </label>

    {{-- Or paste URL --}}
    <div class="mt-3">
        <label class="text-xs text-muted block mb-1">أو الصق رابط URL مباشرة</label>
        <input type="url" placeholder="https://..." x-model="preview"
            class="w-full bg-transparent border border-line rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-accent">
    </div>
</div>

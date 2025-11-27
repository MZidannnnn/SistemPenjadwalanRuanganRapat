{{-- resources/views/components/filter-pemesanan.blade.php --}}
@props(['route'])

<form action="{{ $route }}" method="GET" class="w-full max-w-md"> {{-- Hapus margin-bottom (mb-6) agar sejajar --}}
    
    {{-- Input Hidden untuk Search (agar search tidak hilang) --}}
    @if(request('search'))
        <input type="hidden" name="search" value="{{ request('search') }}">
    @endif

    <div class="flex items-center justify-end gap-3">
        {{-- LABEL FILTER --}}
        <span class="text-sm font-medium text-gray-600 whitespace-nowrap">Filter Tanggal:</span>

        <div class="relative flex-1 max-w-xs"> {{-- Batasi lebar input --}}
            {{-- Icon Kalender --}}
          

            {{-- Input Tanggal --}}
            <input type="date" 
                name="start_date" 
                id="start_date"
                value="{{ request('start_date') }}"
                class="block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out shadow-sm"
                placeholder="Pilih Tanggal"
                onchange="this.form.submit()">

            {{-- Tombol Reset (X) --}}
            @if(request('start_date'))
                <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                    <a href="{{ $route }}" class="p-1 text-gray-400 hover:text-red-500 transition-colors rounded-full hover:bg-gray-100" title="Hapus Filter">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</form>
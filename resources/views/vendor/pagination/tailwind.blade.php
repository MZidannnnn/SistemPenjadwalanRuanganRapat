@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        {{-- Info "Showing X to Y of Z results" --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-start">
            <p class="text-sm text-gray-700 leading-5">
                Menampilkan
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                sampai
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                dari
                <span class="font-medium">{{ $paginator->total() }}</span>
                hasil
            </p>
        </div>

        {{-- Link Halaman --}}
        <div class="flex justify-end">
            <span class="relative z-0 inline-flex shadow-sm rounded-lg">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-default">
                        &lt;
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-300 bg-white text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                        &lt;
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true" class="relative inline-flex items-center px-4 py-2 -ml-px border border-gray-300 bg-white text-sm font-medium text-gray-700 cursor-default">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="relative inline-flex items-center px-4 py-2 -ml-px border border-blue-500 bg-blue-600 text-sm font-medium text-white cursor-default">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 -ml-px rounded-r-lg border border-gray-300 bg-white text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                        &gt;
                    </a>
                @else
                    <span aria-disabled="true" class="relative inline-flex items-center px-3 py-2 -ml-px rounded-r-lg border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-default">
                        &gt;
                    </span>
                @endif
            </span>
        </div>
    </nav>
@endif
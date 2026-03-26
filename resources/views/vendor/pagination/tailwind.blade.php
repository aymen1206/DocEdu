@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
        <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-800 rounded-lg p-2 shadow-lg">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white dark:bg-gray-700 text-gray-400 dark:text-gray-500 cursor-not-allowed border border-gray-200 dark:border-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white dark:bg-gray-700 text-[#1C1C1C] dark:text-white hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 border border-gray-200 dark:border-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="relative inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white dark:bg-gray-700 text-[#1C1C1C] dark:text-white border border-gray-200 dark:border-gray-600">
                        <span class="text-sm font-medium">{{ $element }}</span>
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="relative inline-flex items-center justify-center w-10 h-10 rounded-lg bg-[#1C1C1C] dark:bg-gray-700 text-white font-semibold border border-[#1C1C1C] dark:border-gray-600 shadow-md">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="relative inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white dark:bg-gray-700 text-[#1C1C1C] dark:text-white hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 border border-gray-200 dark:border-gray-600 font-medium">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white dark:bg-gray-700 text-[#1C1C1C] dark:text-white hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 border border-gray-200 dark:border-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <span class="relative inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white dark:bg-gray-700 text-gray-400 dark:text-gray-500 cursor-not-allowed border border-gray-200 dark:border-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif


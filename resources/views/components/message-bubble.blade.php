<div class="flex flex-col space-y-2">
    <div class="flex items-start space-x-3">
        <!-- Avatar placeholder -->
        <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                {{ strtoupper(substr($sender, 0, 1)) }}
            </div>
        </div>
        
        <!-- Message content -->
        <div class="flex-1 min-w-0">
            <div class="bg-gray-100 dark:bg-gray-800 rounded-lg px-4 py-2 max-w-xs lg:max-w-md">
                <div class="text-sm text-gray-900 dark:text-gray-100">
                    {{ $content }}
                </div>
                
                @if($hasMedia)
                    <div class="mt-2">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg>
                            Медиа
                        </span>
                    </div>
                @endif
            </div>
            
            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                {{ $time }}
            </div>
        </div>
    </div>
</div>

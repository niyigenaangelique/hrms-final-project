@if($unreadCount > 0)
<div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
            </svg>
        </div>
        <div class="ml-3 flex-1">
            <p class="text-sm text-blue-700">
                <strong>You have {{ $unreadCount }} new notification{{ $unreadCount > 1 ? 's' : '' }}!</strong>
            </p>
            <div class="mt-2">
                @foreach($notifications->take(3) as $notification)
                    <div class="text-sm text-blue-600 mb-1">
                        <a href="{{ $notification['url'] }}" class="hover:underline">
                            {{ $notification['title'] }} - {{ $notification['time'] }}
                        </a>
                    </div>
                @endforeach
                @if($notifications->count() > 3)
                    <p class="text-xs text-blue-500">... and {{ $notifications->count() - 3 }} more</p>
                @endif
            </div>
        </div>
        <div class="ml-auto pl-3">
            <div class="-mx-1.5 -my-1.5">
                <button wire:click="$refresh" class="inline-flex bg-blue-50 rounded-md p-1.5 text-blue-500 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-50 focus:ring-blue-600">
                    <span class="sr-only">Dismiss</span>
                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endif

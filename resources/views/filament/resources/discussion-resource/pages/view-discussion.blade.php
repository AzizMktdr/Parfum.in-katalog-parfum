<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6">

        {{-- Diskusi utama --}}
        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h1 class="text-lg font-bold text-gray-950 dark:text-white">{{ $record->title }}</h1>
                    <p class="text-xs text-gray-500 mt-1">
                        oleh <span class="font-semibold">{{ $record->user->name ?? 'Anonymous' }}</span>
                        &middot; {{ $record->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700 dark:bg-red-500/10 dark:text-red-400">
                        ❤ {{ $record->likes_count }} like
                    </span>
                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400">
                        💬 {{ $record->replies_count }} balasan
                    </span>
                </div>
            </div>
            <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">{{ $record->body }}</p>
        </div>

        {{-- List semua balasan --}}
        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <h2 class="text-base font-semibold text-gray-950 dark:text-white mb-4">
                Semua Balasan ({{ $this->getAllReplies()->count() }})
            </h2>

            @php $replies = $this->getAllReplies(); @endphp

            @if($replies->isEmpty())
                <p class="text-sm text-gray-400 text-center py-6">Belum ada balasan di diskusi ini.</p>
            @else
                <div class="space-y-3">
                    @foreach($replies as $reply)
                    <div class="flex items-start justify-between gap-3 rounded-lg border border-gray-100 dark:border-gray-800 p-4 {{ $reply->parent_id ? 'ml-8 bg-gray-50 dark:bg-gray-800/40' : '' }}">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                @if($reply->parent_id)
                                    <span class="text-xs text-gray-400">↳ balasan</span>
                                @endif
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $reply->user->name ?? 'Anonymous' }}
                                </span>
                                <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $reply->body }}</p>
                        </div>

                        <button
                            wire:click="deleteReply({{ $reply->id }})"
                            wire:confirm="Hapus balasan ini?"
                            type="button"
                            class="shrink-0 text-xs font-medium text-red-600 hover:text-red-700 dark:text-red-400 px-2 py-1 rounded hover:bg-red-50 dark:hover:bg-red-500/10 transition"
                        >
                            Hapus
                        </button>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-filament-panels::page>

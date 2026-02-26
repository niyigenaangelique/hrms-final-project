<div
    class="!h-screen flex flex-col w-full mx-auto p-1.5 sm:w-full md:w-[300px] lg:w-[300px] xl:w-[350px] 2xl:w-[350px] bg-primary-200 overflow-x-hidden pe-0.5 scrollbar-custom">
    <flux:heading size="lg" class="!text-primary-900 mx-auto">List of Users</flux:heading>

    <!-- Search Bar -->
    <flux:input   icon="magnifying-glass" placeholder="Search users"   class="!w-full my-2.5" wire:model.live="search" clearable />
    {{--List of Devices--}}
    <div wire:poll class="w-full !p-0 flex-grow max-w-md bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <ul role="list">
            @forelse($this->devices as $index => $snakeModel)
                <li
                    class="py-1 px-2  cursor-pointer border border-dashed border-b-gray-100 !rounded-none  hover:bg-gold-600
                    {{ $selectedId === $snakeModel->id ? 'bg-gold-200' : ($index % 2 === 0 ? 'bg-white' : 'bg-gray-200') }}"
                    wire:click.prevent="dispatchSelectDevice('{{ $snakeModel->id }}')"
                    wire:key="{{ $snakeModel->id }}"
                >
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <flux:icon.computer-desktop variant="solid"/>
                        </div>
                        <div class="flex-1 min-w-0 ms-4">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{ $snakeModel->name }} ({{ $snakeModel->ip_address }})
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                {{ $snakeModel->project->name }} ({{ $snakeModel->code }})
                            </p>
                        </div>
                    </div>
                </li>
            @empty
                <li class="text-sm text-gray-500 dark:text-gray-400">No device found.</li>
            @endforelse
        </ul>
    </div>
    <!-- Pagination -->
    <div wire:key="devices-pagination">
        {{ $this->devices->links() }}
    </div>
</div>

{{-- Success is as dangerous as failure. --}}

@php
    if (! isset($scrollTo)) {
        $scrollTo = 'body';
    }

    $scrollIntoViewJsSnippet = ($scrollTo !== false)
        ? <<<JS
           (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
        JS
        : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <div class="mt-0 flex justify-center">
            <flux:button.group class="my-0.5">
                {{-- First Page Button --}}
                @if ($paginator->onFirstPage())
                    <flux:button  size="sm" icon="chevron-double-left"  variant="filled"/>
                @else
                    <flux:button size="sm" wire:click="gotoPage(1, '{{ $paginator->getPageName() }}')" variant="primary" icon="chevron-double-left"/>
                @endif
                {{-- Previous Page Button --}}
                @if ($paginator->onFirstPage())
                    <flux:button size="sm" icon="chevron-left"  variant="filled"/>

                @else
                    <flux:button size="sm" wire:click="previousPage('{{ $paginator->getPageName() }}')" variant="primary"
                                 icon="chevron-left"/>
                @endif

                {{-- Page Dropdown --}}

                <flux:dropdown>
                    <flux:button  size="sm" icon-trailing="ellipsis-vertical">
                        Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
                    </flux:button>
                    <flux:menu>
                        <flux:menu.radio.group
                            {{--                            wire:model="page"--}}
                            wire:change="gotoPage($event.target.value, '{{ $paginator->getPageName() }}')"
                        >
                            @foreach (range(1, $paginator->lastPage()) as $page)
                                @if( $page == $paginator->currentPage())
                                    <flux:menu.radio checked  value="{{ $page }}">Page No.{{ $page }}</flux:menu.radio>
                                @else
                                    <flux:menu.radio  value="{{ $page }}">Page No.{{ $page }}</flux:menu.radio>
                                @endif

                            @endforeach

                        </flux:menu.radio.group>
                    </flux:menu>
                </flux:dropdown>
                {{-- Next Page Button --}}
                @if ($paginator->hasMorePages())
                    <flux:button size="sm" wire:click="nextPage('{{ $paginator->getPageName() }}')" variant="primary" icon="chevron-right" />
                @else
                    <flux:button size="sm" icon="chevron-right"  variant="filled" />
                @endif

                {{-- Last Page Button --}}
                @if ($paginator->hasMorePages())
                    <flux:button size="sm" wire:click="gotoPage({{ $paginator->lastPage() }}, '{{ $paginator->getPageName() }}')" variant="primary" icon="chevron-double-right" />
                @else
                    <flux:button size="sm" icon="chevron-double-right"  variant="filled" />
                @endif
            </flux:button.group>
        </div>
    @endif
</div>

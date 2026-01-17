<div class="bg-white p-3 rounded-3 shadow-sm">
    @if(isset($title) || isset($buttons))
    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
        @if(isset($title))
            <h5 class="mb-0">{{ $title }}</h5>
        @endif
        @if(isset($buttons) && is_array($buttons))
            <div class="d-flex gap-2">
                @foreach($buttons as $button)
                
                    <a 
                    
                    
                    @if (isset($button['url']))
                    href="{{ $button['url'] ?? '#' }}"
                    
                @endif
                    @if(isset($button['onclick']))
                        onclick="{{ $button['onclick'] }}"
                    @endif
                    class="btn btn-{{ $button['type'] ?? 'secondary' }}">
                        {{ $button['text'] ?? 'Button' }}
                    </a>
                @endforeach
            </div>
        @endif
        </div>
    @endif
    {{ $slot }}
</div>
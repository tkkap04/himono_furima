<div class="item-list">
    @foreach ($items as $item)
        <div class="item">
            <img src="{{ asset($item->image_url) }}" alt="{{ $item->name }}" class="item-image">
        </div>
    @endforeach
</div>

@foreach ($categories as $category)
    <option value="{{ $category->id }}" {{ isset($selected) && $selected == $category->id ? 'selected' : '' }}>
        {{ str_repeat('— ', $category->depth ?? 0) }} {{ $category->name }}
    </option>
    @if ($category->children->count())
        @include('admin.partials.category-tree', ['categories' => $category->children, 'selected' => $selected ?? null])
    @endif
@endforeach

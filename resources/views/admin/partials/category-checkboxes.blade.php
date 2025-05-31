@foreach ($categories as $category)
    @if ($category->id)
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="categories[]" value="{{ $category->id }}"
                {{ in_array($category->id, $selected ?? []) ? 'checked' : '' }}>
            <label class="form-check-label">
                {{ str_repeat('— ', $category->depth ?? 0) }} {{ $category->name }}
            </label>
        </div>
    @endif
    @if ($category->children->count())
        @include('admin.partials.category-checkboxes', ['categories' => $category->children, 'selected' => $selected ?? []])
    @endif
@endforeach

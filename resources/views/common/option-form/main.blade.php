<div class="kt-portlet">
  <div class="kt-portlet__head">
    <div class="kt-portlet__head-label">
      <h3 class="kt-portlet__head-title">{{ $title }} {!! $hint ?? '' !!}</h3>
    </div>
  </div>
  <form class="kt-form kt-form--label-right" method="post">
    @csrf
    <input type="hidden" name="option" value="{{ $id }}">
    <div class="kt-portlet__body">

      @foreach($messages as $msg)
        {!! $msg !!}
      @endforeach

      @if ($renderWithoutTable)
        @each('common.option-form.item', $items, 'item')
      @else
        @foreach($items as $item)
          <div class="form-group row">
            @unless ($renderInputTagsOnly)
              <label for="example-text-input"
                     class="col-lg-3 col-form-label">{{ $item->name }} {!! $item->hint ?? '' !!}</label>
            @endunless

            <td class="value">
              @include('common.option-form.item', compact('item'))
            </td>
          </div>
        @endforeach
      @endif

    </div>
    <div class="kt-portlet__foot">
      <div class="kt-form__actions">
        <div class="row">
          <div class="col-2">
          </div>
          <div class="col-10">
            @foreach($buttons as $button)
              {!! $button !!}
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

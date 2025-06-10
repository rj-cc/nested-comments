@if(isset($record))
    <livewire:nested-comments::comments :record="$record" />
@else
    <p>{{ __('nested-comments::nested-comments.comments.general.no_commentable_record_set') }}</p>
@endif

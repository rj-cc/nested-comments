<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <livewire:nested-comments::comments
            :record="$getRecord()"
            :get-user-avatar-using="$getUserAvatarUsingClosure()"
            :get-user-name-using="$getUserNameUsingClosure()"
            :get-mentions-using="$getMentionsUsingClosure()"
    />
</x-dynamic-component>

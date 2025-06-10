@if(!$content->isValid())
    <x-ui.button
        type="button"
        class="text-red-500"
        variant="no"
        x-data
        x-on:click="$dispatch('open-modal', 'validate-modal')"
    >
        <span class="icon-[tabler--flag] size-6 m-0"></span>
    </x-ui.button>
@endif

<x-ui.validation-requests.view-requests-modal :$content/>

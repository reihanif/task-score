<x-modal id="time-extension-modal-{{ $assignee_task->id }}"
    data-title="Request time extension {{ $assignee_task->uuid }}">
    <!-- Modal body -->
    <form class="p-4 md:p-5"
        x-on:submit="loading = ! loading"
        action="{{ route('taskscore.assignment.time-extension-request', $assignee_task->id) }}"
        method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="mb-5">
            <div class="space-y-4">
                <div class="col-span-2">
                    <x-forms.text-editor name="justification"
                        label="Detail Request"
                        placeholder="Reason of time extending request"
                        required>
                    </x-forms.text-editor>
                </div>
            </div>
        </div>
        <div class="flex place-content-end">
            <button
                class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="submit">
                Request
            </button>
        </div>
    </form>
</x-modal>

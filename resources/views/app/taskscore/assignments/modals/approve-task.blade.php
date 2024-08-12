<!-- Approval Modal -->
<x-modal id="approve-submission-modal-{{ $submission->id }}"
    data-title="Aprove submission">
    <!-- Modal body -->
    <form class="p-4 md:p-5"
        x-on:submit="loading = ! loading"
        action="{{ route('taskscore.assignment.approve-submission', $submission->id) }}"
        method="post"
        enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-5">
            <div class="space-y-4">
                <div class="col-span-2">
                    <x-forms.text-editor name="detail"
                        label="Approval detail"
                        placeholder="Approval description and detail">
                    </x-forms.text-editor>
                </div>
            </div>
        </div>
        <div class="flex place-content-end">
            <button
                class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="submit">
                Approve
            </button>
        </div>
    </form>
</x-modal>

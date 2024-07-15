<x-modal id="resolve-assignment-modal-{{ $assignee_task->id }}"
    data-title="Resolve assignment {{ $assignee_task->uuid }}">
    <!-- Modal body -->
    <form class="p-4 md:p-5"
        x-on:submit="loading = ! loading"
        action="{{ route('taskscore.assignment.resolve', $assignee_task->id) }}"
        method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="mb-5">
            <div class="space-y-4">
                <div class="col-span-2">
                    <x-forms.text-editor name="resolution"
                        label="Resolution detail"
                        placeholder="Assignment resolution detail and description"
                        required>
                    </x-forms.text-editor>
                </div>
                <div class="col-span-2">
                    <label class="mb-2 inline-flex gap-1 text-sm font-medium text-gray-900 dark:text-white"
                        for="file">Files <span class="text-red-600 dark:text-red-500">*</span>
                        <button class="text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white"
                            data-tooltip-target="tooltip-default"
                            type="button">
                            <svg class="h-4 w-4"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <div class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-normal text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700"
                            id="tooltip-default"
                            role="tooltip">
                            Attach files to complete submission
                            <div class="tooltip-arrow"
                                data-popper-arrow></div>
                        </div>
                    </label>
                    <input id="file"
                        name="attachments[]"
                        type="file"
                        multiple
                        required>
                </div>
            </div>
        </div>
        <div class="flex place-content-end">
            <button
                class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="submit">
                Submit
            </button>
        </div>
    </form>
</x-modal>

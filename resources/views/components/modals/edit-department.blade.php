<div class="table-row-button cursor-default">
    <!-- Main modal -->
    <div class="fixed left-0 right-0 top-0 z-50 hidden h-modal w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0 md:h-full"
        id="edit-departments-modal-{{ $department->id }}"
        aria-hidden="true"
        tabindex="-1">
        <div class="relative h-full w-full max-w-md p-4 md:h-auto">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white p-4 shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="mb-4 flex items-center justify-between rounded-t border-b pb-4 dark:border-gray-600 sm:mb-5">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit Department
                    </h3>
                    <button
                        class="ml-auto inline-flex items-center rounded-lg bg-transparent p-1.5 text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="edit-departments-modal-{{ $department->id }}"
                        type="button">
                        <x-icons.close class="h-5 w-5">
                        </x-icons.close>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form x-on:submit="loading = ! loading"
                    action="{{ route('departments.update', $department->id) }}"
                    method="post">
                    @csrf
                    @method('put')
                    <div class="mb-7 grid gap-4">
                        <div>
                            <x-forms.input id="name-{{ $department->id }}"
                                name="name"
                                type="text"
                                value="{{ $department->name }}"
                                state="initial"
                                label="Department Name"
                                helper=""
                                placeholder="e.g. Information & Technology"
                                required/>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                for="position">
                                Authorized Position
                            </label>
                            <select class="tom-select"
                                id="position"
                                name="positions[]"
                                multiple>
                                @if ($department->positions->isEmpty())
                                    <option value=""
                                        selected>Select position</option>
                                @else
                                    @foreach ($department->positions->sortBy('level') as $position)
                                        <option value="{{ $position->id }}"
                                            selected>{{ $position->name }}</option>
                                    @endforeach
                                @endif
                                <option value=""
                                    selected>Select position</option>
                                @foreach ($positions as $position)
                                    @if (!in_array($position->id, $department->positions->pluck('id')->toArray()))
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid justify-items-end">
                        <button
                            class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="submit">
                            Save department
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

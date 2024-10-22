<!-- Edit Modal -->
<x-modal id="edit-assignment-modal"
            data-title="Edit assignment">
    <!-- Modal body -->
    <form class="p-4 md:p-5"
            x-on:submit="loading = ! loading"
            action="{{ route('taskscore.assignment.update', $assignment->id) }}"
            method="post"
            enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="mb-5"
                x-data="difficultyOption">
            <div class="space-y-4">
                <div class="col-span-2">
                    <x-forms.input id="input-subject"
                                    name="subject"
                                    type="text"
                                    value="{{ $assignment->subject }}"
                                    autocomplete="off"
                                    label="Subject"
                                    placeholder="Assignment subject"
                                    state="initial"
                                    required></x-forms.input>
                </div>
                <div class="col-span-2 space-y-2">
                    <x-forms.select id="input-category"
                                    name="type"
                                    label="Category"
                                    x-model="category"
                                    state="initial"
                                    required>
                        <option value="">Select assignment category</option>
                        @foreach ($categories as $key => $category)
                            @if ($category == $assignment->type)
                                <option data-order="{{ str_pad($key, 2, '0', STR_PAD_LEFT) }}"
                                        value="{{ $category }}"
                                        selected>{{ $category }}
                                </option>
                            @else
                                <option data-order="{{ str_pad($key, 2, '0', STR_PAD_LEFT) }}"
                                        value="{{ $category }}">
                                    {{ $category }}
                                </option>
                            @endif
                        @endforeach
                    </x-forms.select>

                    <template x-if="category == 'Lainnya'">
                        <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm"
                                id="input-category-other"
                                name="type_other"
                                type="text"
                                autocomplete="off"
                                placeholder="Category name"
                                maxlength="255"
                                required>
                    </template>
                </div>
                <div class="col-span-2">
                    <x-forms.text-editor name="description"
                                            value="{{ $assignment->description }}"
                                            label="Description"
                                            placeholder="Assignment description and details"
                                            required>
                    </x-forms.text-editor>
                </div>
            </div>
        </div>
        <div class="flex place-content-end">
            <button class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="submit">
                Save
            </button>
        </div>
    </form>
</x-modal>

<!-- Modal toggle -->
<button data-modal-target="position-authorization-modal"
    data-modal-show="position-authorization-modal"
    type="button"
    {{ $attributes }}>
    <x-icons.plus class="-ml-1 mr-1 h-6 w-6">
    </x-icons.plus>
    Add Department
</button>

<!-- Main modal -->
<div class="fixed left-0 right-0 top-0 z-50 hidden h-modal w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0 md:h-full"
    id="position-authorization-modal"
    aria-hidden="true"
    tabindex="-1">
    <!-- Modal content -->
    <form x-on:submit="loading = ! loading"
        action="{{ route('positions.authorize', $position->id) }}"
        method="post">
        @csrf
        <div class="relative max-h-full w-full max-w-md p-4">
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-800">
                <button
                    class="absolute end-2.5 top-3 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="position-authorization-modal"
                    type="button">
                    <x-icons.close class="h-3 w-3"></x-icons.close>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 text-center md:p-5">
                    <svg class="mx-auto mb-4 h-12 w-12 text-gray-400 dark:text-gray-200"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Select the department you want
                        to give authority to the {{ $position->name }}</h3>

                    <div class="text-left">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="department">
                            Department
                            <span class="text-red-600 dark:text-red-500">*</span>
                        </label>
                        <select class="tom-select"
                            id="department"
                            name="departments[]"
                            required
                            multiple>
                            <option value=""
                                selected>Select department</option>
                            @foreach ($departments as $department)
                                @if (!in_array($department->id, $position->departments->pluck('id')->toArray()))
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <button
                        class="mt-6 inline-flex items-center rounded-lg bg-blue-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800"
                        type="submit">Submit
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

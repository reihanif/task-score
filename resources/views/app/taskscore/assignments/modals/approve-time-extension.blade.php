<!-- Approval Time Extension Modal -->
<x-modal id="approve-time-extension-modal-{{ $time_extension->id }}"
    data-title="Approve time extension request">
    <!-- Modal body -->
    <form class="p-4 md:p-5"
        x-on:submit="loading = ! loading"
        action="{{ route('taskscore.assignment.time-extension-approve', $time_extension->id) }}"
        method="post"
        enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-5">
            <div class="space-y-4"
                x-data="{ selectedOption: '' }">
                <div>
                    <p class="due-label mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                        Add time extension
                    </p>
                    <ul
                        class="w-full items-center rounded-lg border border-gray-200 bg-white text-sm font-medium text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:flex">
                        <li class="w-full border-b border-gray-200 dark:border-gray-600 sm:border-b-0 sm:border-r">
                            <div class="interval flex items-center ps-3">
                                <input
                                    class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:ring-offset-gray-700 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-700"
                                    id="select-interval"
                                    type="radio"
                                    value="interval-time"
                                    name="due"
                                    x-model="selectedOption"
                                    required>
                                <label class="ms-2 w-full py-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    for="select-interval">
                                    Select by interval
                                </label>
                            </div>
                        <li class="w-full dark:border-gray-600">
                            <div class="exact-time flex items-center ps-3">
                                <input
                                    class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:ring-offset-gray-700 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-700"
                                    id="select-exact-time"
                                    type="radio"
                                    value="exact-time"
                                    name="due"
                                    x-model="selectedOption"
                                    required>
                                <label class="ms-2 w-full py-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    for="select-exact-time">
                                    Select exact time
                                </label>
                            </div>
                        </li>
                        </li>
                    </ul>
                </div>

                <div class="sm:grid sm:grid-cols-2"
                    x-show="selectedOption !== ''">
                    <template x-if="selectedOption === 'exact-time'">
                        <div class="col-span-full space-y-4 sm:grid sm:grid-cols-2 sm:space-x-4 sm:space-y-0">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                    for="date">
                                    Date
                                    <span class="text-red-600 dark:text-red-500">*</span>
                                </label>
                                <div>
                                    <input
                                        class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm"
                                        format="dd/mm/yy"
                                        type="date"
                                        value="{{ date('Y-m-d') }}"
                                        id="date"
                                        name="date"
                                        onclick="showPicker()"
                                        onfocus="this.min = new Date().toISOString().split('T')[0]"
                                        autocomplete="off"
                                        required>
                                </div>
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                    for="input-time">
                                    Time
                                    <span class="text-red-600 dark:text-red-500">*</span>
                                </label>
                                <div>
                                    <input
                                        class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm"
                                        type="time"
                                        id="input-time"
                                        name="time"
                                        x-data="{ timeValue: addMinutesFromCurrentTime(60) }"
                                        x-bind:value="timeValue"
                                        onclick="showPicker()"
                                        autocomplete="off"
                                        required>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template x-if="selectedOption === 'interval-time'">
                        <ul class="timetable col-span-2 grid w-full grid-cols-3 gap-2 sm:grid-cols-6">
                            <li>
                                <input class="peer hidden"
                                    type="radio"
                                    value="20"
                                    id="10-am"
                                    name="timetable"
                                    checked>
                                <label
                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                    for="10-am">
                                    20 Minutes
                                </label>
                            </li>
                            <li>
                                <input class="peer hidden"
                                    type="radio"
                                    value="30"
                                    id="10-30-am"
                                    name="timetable">
                                <label
                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                    for="10-30-am">
                                    30 Minutes
                                </label>
                            </li>
                            <li>
                                <input class="peer hidden"
                                    type="radio"
                                    value="45"
                                    id="11-am"
                                    name="timetable">
                                <label
                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                    for="11-am">
                                    45 Minutes
                                </label>
                            </li>
                            <li>
                                <input class="peer hidden"
                                    type="radio"
                                    value="60"
                                    id="11-30-am"
                                    name="timetable">
                                <label
                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                    for="11-30-am">
                                    1 Hours
                                </label>
                            </li>
                            <li>
                                <input class="peer hidden"
                                    type="radio"
                                    value="120"
                                    id="12-am"
                                    name="timetable">
                                <label
                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                    for="12-am">
                                    2 Hours
                                </label>
                            </li>
                            <li>
                                <input class="peer hidden"
                                    type="radio"
                                    value="180"
                                    id="12-30-pm"
                                    name="timetable">
                                <label
                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                    for="12-30-pm">
                                    3 Hours
                                </label>
                            </li>
                            <li>
                                <input class="peer hidden"
                                    type="radio"
                                    value="240"
                                    id="1-pm"
                                    name="timetable">
                                <label
                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                    for="1-pm">
                                    4 Hours
                                </label>
                            </li>
                            <li>
                                <input class="peer hidden"
                                    type="radio"
                                    value="300"
                                    id="1-30-pm"
                                    name="timetable">
                                <label
                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                    for="1-30-pm">
                                    5 Hours
                                </label>
                            </li>
                            <li>
                                <input class="peer hidden"
                                    type="radio"
                                    value="1440"
                                    id="2-pm"
                                    name="timetable">
                                <label
                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                    for="2-pm">
                                    1 Days
                                </label>
                            </li>
                            <li>
                                <input class="peer hidden"
                                    type="radio"
                                    value="2880"
                                    id="2-30-pm"
                                    name="timetable">
                                <label
                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                    for="2-30-pm">
                                    2 Days
                                </label>
                            </li>
                            <li>
                                <input class="peer hidden"
                                    type="radio"
                                    value="4320"
                                    id="3-pm"
                                    name="timetable">
                                <label
                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                    for="3-pm">
                                    3 Days
                                </label>
                            </li>
                            <li>
                                <input class="peer hidden"
                                    type="radio"
                                    value="5760"
                                    id="3-30-pm"
                                    name="timetable">
                                <label
                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                    for="3-30-pm">
                                    4 Days
                                </label>
                            </li>
                        </ul>
                    </template>
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

<script>
    function addMinutesFromCurrentTime(add) {
        let now = new Date();
        now.setMinutes(now.getMinutes() + add);

        let hours = String(now.getHours()).padStart(2, '0');
        let minutes = String(now.getMinutes()).padStart(2, '0');

        return `${hours}:${minutes}`;
    }
</script>

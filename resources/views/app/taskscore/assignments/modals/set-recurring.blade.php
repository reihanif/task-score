<x-modal id="set-recurring-modal-{{ $assignment->id }}"
    data-title="Recurring details" modal-lg>
    <form class="p-4 md:p-5"
        x-data="createForm"
        x-on:submit="handleSubmit($event)"
        action="{{ route('taskscore.assignment.recurrence.store', $assignment->id) }}"
        method="post"
        enctype="multipart/form-data">
        @csrf
        <template x-if="ocurrenceType == 'recurring'">
            <div>
                <div class="space-y-2">
                    <div class="text-sm font-medium text-gray-900 dark:text-gray-300">Recurrence pattern</div>
                    <div class="space-y-2">
                        <label class="text-sm font-normal text-gray-900 dark:text-gray-300"
                               for="input-repeat">Repeat<span
                                  class="text-red-600 dark:text-red-500">*</span></label>
                        <select class="recurring-input"
                                id="input-repeat"
                                name="repeat"
                                x-effect="initializeTomSelect()"
                                x-model="repeat"
                                required>
                            <option value="">Select repeat pattern</option>
                            <option data-order="0"
                                    value="daily">Daily</option>
                            <option data-order="1"
                                    value="weekly">Weekly</option>
                            <option data-order="2"
                                    value="monthly">Monthly</option>
                        </select>
                    </div>
                    <div x-show="repeat && repeat !== 'daily'">
                        <div class="space-y-2">
                            <div class="text-sm font-normal text-gray-900 dark:text-gray-300">
                                On<span x-show="repeat == 'monthly'"> day</span><span
                                      class="text-red-600 dark:text-red-500">*</span></div>
                            <template x-if="repeat == 'weekly'">
                                <ul class="grid w-full grid-cols-5 gap-2">
                                    <template x-for="(day, index) in days">
                                        <li class="relative">
                                            <input class="peer absolute opacity-0"
                                                   name="day_of_weeks[]"
                                                   type="checkbox"
                                                   x-model="recureDays"
                                                   x-bind:id="day.name"
                                                   x-on:change="validateCheckboxes()"
                                                   x-bind:value="day.name"
                                                   x-ref="weeklyDays">
                                            <label class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900 peer-checked:border-blue-700 peer-checked:bg-blue-50 peer-checked:text-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:border-blue-500 dark:peer-checked:bg-blue-900 dark:peer-checked:text-blue-500"
                                                   x-bind:for="day.name"
                                                   x-text="day.shortname">
                                            </label>
                                        </li>
                                    </template>
                                </ul>
                            </template>
                            <div x-show="repeat == 'monthly'">
                                <select class="recurring-input"
                                        id="input-day"
                                        x-model="selectedDay"
                                        x-bind:name="repeat == 'monthly' ? 'day_of_month' : null"
                                        x-bind:required="repeat == 'monthly'"
                                        required>
                                    <option value="">Select day</option>
                                    <template x-for="days in daysOfMonth()"
                                              x-bind:key="days">
                                        <option x-bind:value="days"
                                                x-text="days">
                                        </option>
                                    </template>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-normal text-gray-900 dark:text-gray-300"
                               for="input-time">At<span
                                  class="text-red-600 dark:text-red-500">*</span></label>
                        <select class="recurring-input"
                                id="input-time"
                                name="time"
                                x-model="selectedTime"
                                normal-select
                                required>
                            <option value="">Select time</option>
                            <template x-for="time in availableTimes()"
                                      x-bind:key="time">
                                <option x-bind:value="time"
                                        x-text="time">
                                </option>
                            </template>
                        </select>
                    </div>
                    <div class="text-xs"
                         x-show="repeat == 'daily' && selectedTime || repeat == 'weekly' && recureDays.length > 0 && selectedTime || repeat == 'monthly' && selectedDay && selectedTime">
                        Occurs every<span x-show="repeat == 'daily'">day</span>
                        <span x-show="repeat == 'weekly'">
                            week on
                            <span x-text="formattedDays()"></span>
                        </span>
                        <span x-show="repeat == 'monthly'">
                            month on day
                            <span x-text="selectedDay"></span>
                        </span>
                        at
                        <span x-text="selectedTime"></span>
                    </div>
                </div>
                <div class="mt-2 space-y-2"
                     x-data="{ isEndless: false }">
                    <label class="text-sm font-normal text-gray-900 dark:text-gray-300"
                           for="input-recurrence-end-date">
                        Ends on<span class="text-red-600 dark:text-red-500">*</span>
                    </label>
                    <template x-if="!isEndless">
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
                                <svg class="h-4 w-4 text-gray-500 dark:text-gray-400"
                                     aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="currentColor"
                                     viewBox="0 0 20 20">
                                    <path
                                          d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                   id="input-recurrence-end-date"
                                   name="recurrence_end_date"
                                   data-min-date="{{ Carbon\Carbon::today() }}"
                                   type="text"
                                   datepicker
                                   x-init="initializeDatepickers()"
                                   autocomplete="off"
                                   placeholder="Select date"
                                   required>
                        </div>
                    </template>
                    <div class="mb-4 flex items-center">
                        <input class="h-4 w-4 cursor-pointer rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600"
                               id="endless-checkbox"
                               type="checkbox"
                               x-model="isEndless">
                        <label class="ms-2 cursor-pointer text-sm font-normal text-gray-900 dark:text-gray-300"
                               for="endless-checkbox">Make it endless</label>
                    </div>
                </div>
            </div>
        </template>
        <div class="flex place-content-end">
            <button class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="submit">
                Save
            </button>
        </div>
    </form>
</x-modal>

<script>
    function createForm() {
        return {
            ocurrenceType: 'recurring',
            repeat: '',
            recureDays: [],
            selectedDay: '',
            selectedTime: '',
            startTime: '07:30',
            endTime: '16:00',
            days: [{
                    name: '1',
                    shortname: 'Mon'
                },
                {
                    name: '2',
                    shortname: 'Tue'
                },
                {
                    name: '3',
                    shortname: 'Wed'
                },
                {
                    name: '4',
                    shortname: 'Thu'
                },
                {
                    name: '5',
                    shortname: 'Fri'
                }
            ],
            daysOfMonth() {
                return Array.from({
                    length: 31
                }, (_, i) => i + 1);
            },
            formattedDays() {
                let daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                let conjuction = '';

                if (this.recureDays.length == 2) {
                    conjuction = ' and ';
                } else {
                    conjuction = ', ';
                }

                let result = this.recureDays.sort((a, b) => a.localeCompare(b)).map(day => daysOfWeek[day]).join(
                    conjuction);

                return result;
            },
            availableTimes() {
                const times = [];
                let currentTime = this.startTime;

                while (currentTime <= this.endTime) {
                    times.push(currentTime);
                    currentTime = this.addMinutes(currentTime, 30);
                }

                return times;
            },
            addMinutes(time, minutes) {
                const [hour, minute] = time.split(':').map(Number);
                const date = new Date();
                date.setHours(hour, minute + minutes);
                return date.toTimeString().slice(0, 5);
            },
            initializeTomSelect() {
                this.$nextTick(() => {
                    document.querySelectorAll('.recurring-input').forEach((el) => {
                        if (el) {
                            if (el.tomselect) {
                                el.tomselect.destroy();
                            }

                            const config = {
                                sortField: {
                                    field: "order",
                                    direction: "asc",
                                }
                            };

                            new TomSelect(el, config);
                        }
                    })
                });
            },
            validateCheckboxes() {
                const checkboxes = document.querySelectorAll('input[name="day_of_weeks[]"]');

                checkboxes.forEach(checkbox => {
                    checkbox.setCustomValidity('');

                    if (this.repeat === 'weekly' && this.recureDays.length === 0) {
                        checkbox.setCustomValidity('Please select at least one day.');
                    }
                });

                if (checkboxes.length > 0) {
                    checkboxes[0].reportValidity();
                }
            },
            canSubmit() {
                this.validateCheckboxes();

                return !(this.repeat === 'weekly' && this.recureDays.length === 0);
            },
            handleSubmit(event) {
                if (!this.canSubmit()) {
                    event.preventDefault();
                } else {
                    this.loading = !this.loading;
                }
            }
        }
    }
</script>

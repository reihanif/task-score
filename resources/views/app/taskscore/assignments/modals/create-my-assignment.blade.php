<x-modal id="create-my-assignment-modal"
         data-title="Create new assignment">
    <!-- Modal body -->
    <form class="p-4 md:p-5"
          x-data="createForm"
          x-on:submit="handleSubmit($event)"
          action="{{ route('taskscore.assignment.store-my-assignment') }}"
          method="post"
          enctype="multipart/form-data">
        @csrf
        <div class="mb-5">
            <div class="space-y-4"
                 x-data="difficultyOption()">
                    <div>
                         <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                for="input-subject">
                             Subject
                             <span class="text-red-600 dark:text-red-500">*</span>
                         </label>

                         <div x-data="{ subject: '' }">
                             <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm"
                                    id="input-subject"
                                    name="subject"
                                    type="text"
                                    value="{{ old('subject') }}"
                                    x-model="subject"
                                    autocomplete="off"
                                    placeholder="Assignment subject"
                                    maxlength="255"
                                    required>
                             <p class="mt-1 text-end text-xs text-gray-500 dark:text-gray-400">
                                 <span x-text="subject.length"></span>/255
                             </p>
                         </div>
                     </div>

                     <div>
                         <x-forms.select id="input-taskmaster"
                                         name="taskmaster"
                                         label="Taskmaster"
                                         state="initial"
                                         hascaption
                                         required>
                             <option value="">Select taskmaster</option>
                             @foreach ($superiors as $key => $superior)
                                 <option data-order="{{ str_pad($key, 2, '0', STR_PAD_LEFT) }}"
                                         value="{{ $superior->id }}" data-caption="{{ $superior->position->name }}">{{ $superior->name }}</option>
                             @endforeach
                         </x-forms.select>
                     </div>

                     <div class="space-y-2">
                         <x-forms.select id="input-category"
                                         name="category"
                                         label="Category"
                                         x-model="category"
                                         state="initial"
                                         required>
                             <option value="">Select assignment category</option>
                             @foreach ($categories as $key => $category)
                                 <option data-order="{{ str_pad($key, 2, '0', STR_PAD_LEFT) }}"
                                         value="{{ $category }}">{{ $category }}</option>
                             @endforeach
                         </x-forms.select>

                         <template x-if="category == 'Lainnya'">
                             <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm"
                                    id="input-category-other"
                                    name="category_other"
                                    type="text"
                                    autocomplete="off"
                                    placeholder="Category name"
                                    maxlength="255"
                                    required>
                         </template>
                     </div>

                     <div class="space-y-4">
                        <p class="due-label block text-sm font-medium text-gray-900 dark:text-white">
                            Assignment difficulty level
                            <span class="text-red-600 dark:text-red-500">*</span>
                        </p>

                        <div class="pb-2">
                            <div class="space-y-4">
                                <div class="flex">
                                    <div class="flex h-5 items-center">
                                        <input class="peer/basic h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600"
                                               id="basic"
                                               name="difficulty"
                                               type="radio"
                                               value="basic"
                                               x-model="difficulty"
                                               x-bind:disabled="disableBasic"
                                               required>
                                        <label class="ms-2 cursor-pointer text-sm font-medium text-gray-900 peer-disabled/basic:cursor-default peer-disabled/basic:text-gray-400 dark:text-gray-300 peer-disabled/basic:dark:text-gray-500"
                                               for="basic">
                                            Basic
                                            <p class="text-xs font-normal text-gray-500 dark:text-gray-400"
                                               id="basic-text">Assignment due will set in 1 days from now</p>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="flex h-8 items-center">
                                        <input class="peer/intermediate h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600"
                                               id="intermediate"
                                               name="difficulty"
                                               type="radio"
                                               value="intermediate"
                                               x-model="difficulty"
                                               x-bind:disabled="disableIntermediate"
                                               required>
                                        <label class="ms-2 cursor-pointer text-sm font-medium text-gray-900 peer-disabled/intermediate:cursor-default peer-disabled/intermediate:text-gray-400 dark:text-gray-300 peer-disabled/intermediate:dark:text-gray-500"
                                               for="intermediate">
                                            Intermediate
                                            <p class="text-xs font-normal text-gray-500 dark:text-gray-400"
                                               id="intermediate-text">Assignment due will set in 2 days from now</p>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="flex h-5 items-center">
                                        <input class="peer/advanced h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600"
                                               id="advanced"
                                               name="difficulty"
                                               type="radio"
                                               value="advanced"
                                               x-model="difficulty"
                                               required>
                                        <label class="ms-2 cursor-pointer text-sm font-medium text-gray-900 peer-disabled/advanced:cursor-default peer-disabled/advanced:text-gray-400 dark:text-gray-300 peer-disabled/advanced:dark:text-gray-500"
                                               for="advanced">
                                            Advanced
                                            <p class="text-xs font-normal text-gray-500 dark:text-gray-400"
                                               id="advanced-text">Assignment due will set in 3 days from now</p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="col-span-2">
                         <x-forms.text-editor name="description"
                                              value="{{ old('description') }}"
                                              label="Description"
                                              placeholder="Assignment description"
                                              required>
                         </x-forms.text-editor>
                     </div>

                     <div class="col-span-2">
                         <label class="mb-2 inline-flex gap-1 text-sm font-medium text-gray-900 dark:text-white"
                                for="file">Attachment
                             <button class="text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white"
                                     data-tooltip-target="tooltip-attachment"
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
                                  id="tooltip-attachment"
                                  role="tooltip">
                                 Attach documents that related to this assignment
                                 <div class="tooltip-arrow"
                                      data-popper-arrow></div>
                             </div>
                         </label>
                         <input id="file"
                                name="attachments[]"
                                type="file"
                                max-files="5"
                                multiple>
                     </div>

                <div class="space-y-4">

                    <div class="mb-4 flex items-center">
                        <input class="h-4 w-4 cursor-pointer rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600"
                               id="recurring-checkbox"
                               name="is_recurring"
                               type="checkbox"
                               x-model="recurring">
                        <label class="ms-2 cursor-pointer text-sm font-medium text-gray-900 dark:text-gray-300"
                               for="recurring-checkbox">Recurring assignment</label>
                    </div>

                    <div x-show="recurring" class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                        <template x-if="recurring">
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
                                                        <input class="peer opacity-0 absolute"
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
                                           for="input-time">At<span class="text-red-600 dark:text-red-500">*</span></label>
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
                        </template>
                        <div x-data="{ isEndless: false }" class="mt-2 space-y-2">
                            <label class="text-sm font-normal text-gray-900 dark:text-gray-300" for="input-recurrence-end-date">
                                Ends on<span class="text-red-600 dark:text-red-500">*</span>
                            </label>
                            <div class="relative" x-show="!isEndless">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                  <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                  </svg>
                                </div>
                                <input datepicker x-bind:disabled="isEndless" data-min-date="{{ Carbon\Carbon::today() }}" autocomplete="off" id="input-recurrence-end-date" type="text" name="recurrence_end_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                            </div>
                            <div class="flex items-center mb-4">
                                <input id="endless-checkbox" x-model="isEndless" type="checkbox" class="cursor-pointer w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="endless-checkbox" class="cursor-pointer ms-2 text-sm font-normal text-gray-900 dark:text-gray-300">Make it endless</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex place-content-end">
            <button class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="submit">
                Create
            </button>
        </div>
    </form>
</x-modal>

<script>
    function createForm() {
        return {
            recurring: false,
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

    function addMinutesFromCurrentTime(add) {
        let now = new Date();
        now.setMinutes(now.getMinutes() + add);

        let hours = String(now.getHours()).padStart(2, '0');
        let minutes = String(now.getMinutes()).padStart(2, '0');

        return `${hours}:${minutes}`;
    }

    function difficultyOption() {
        return {
            category: '',
            difficulty: '',
            disableBasic: false,
            disableIntermediate: false,
            init() {
                this.$watch('category', (value) => {
                    if (value === 'SP3') {
                        this.difficulty = 'advanced';
                        this.disableBasic = true;
                        this.disableIntermediate = true;
                    } else {
                        this.disableBasic = false;
                        this.disableIntermediate = false;
                    }
                })
            }
        }
    }
</script>

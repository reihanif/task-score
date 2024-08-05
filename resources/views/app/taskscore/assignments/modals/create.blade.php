<x-modal id="create-assignment-modal"
         data-title="Create new assignment">
    <!-- Modal body -->
    <form class="p-4 md:p-5"
          x-on:submit="loading = ! loading"
          action="{{ route('taskscore.assignment.store') }}"
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

                <x-forms.select id="input-category"
                                name="category"
                                label="Category"
                                x-model="category"
                                state="initial"
                                required>
                    <option value="">Select assignment category</option>
                    <option value="Memorandum">Memorandum</option>
                    <option value="Surat">Surat</option>
                    <option value="Surat Keputusan">Surat Keputusan</option>
                    <option value="Surat Perintah">Surat Perintah</option>
                    <option value="Surat Edaran">Surat Edaran</option>
                    <option value="Presentasi">Presentasi</option>
                    <option value="Rapat">Rapat</option>
                    <option value="Perjalanan dinas">Perjalanan dinas</option>
                    <option value="SP3">SP3</option>
                    <option value="Berita Acara">Berita Acara</option>
                    <option value="Sales Order">Sales Order</option>
                    <option value="Lainnya">Lainnya</option>
                </x-forms.select>

                <div class="col-span-2 space-y-4">
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

                <div class="space-y-1"
                     x-data="appendAssigneeField()">
                    <div class="space-y-4"
                         id="dynamic-assignee-field">
                        <!-- Elements will be appended here -->
                    </div>
                    <template x-ref="templateElement">
                        <div class="element">
                            <div class="flex">
                                <div class="grow space-y-4 rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                                    <div class="assignee">
                                        <div class="mb-2 flex place-content-between">
                                            <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                                <span class="assignee-label"></span>
                                                <span class="text-red-600 dark:text-red-500">*</span>
                                            </label>
                                            <button class="add-assignee hidden items-center text-sm font-semibold text-blue-600 hover:text-blue-800 hover:underline dark:text-blue-500 hover:dark:text-blue-600"
                                                    type="button"
                                                    x-on:click="addElement">
                                                <x-icons.plus class="-ml-0.5 mr-0.5 h-5 w-5">
                                                </x-icons.plus>
                                                Add assignee
                                            </button>
                                        </div>
                                        <select :name="'assignees[' + index + ']'"
                                                required>
                                            <option value="">Select assignee</option>
                                            @foreach ($assignees as $assignee)
                                                <option value="{{ $assignee->id }}">{{ $assignee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <p class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                            <span class="detail-label"></span>
                                            <span class="text-red-600 dark:text-red-500">*</span>
                                        </p>
                                        <div x-data="editor('')">
                                            <div
                                                 class="h-fit w-full rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">
                                                <template x-if="isLoaded()">
                                                    <div
                                                         class="flex items-center justify-between border-b px-3 py-2 dark:border-gray-600">
                                                        <div
                                                             class="flex flex-wrap items-center divide-gray-200 dark:divide-gray-600 sm:divide-x sm:rtl:divide-x-reverse">
                                                            <div
                                                                 class="flex items-center space-x-1 rtl:space-x-reverse sm:pe-4">
                                                                <button class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                                                        type="button"
                                                                        x-on:click="toggleBold()"
                                                                        :class="{
                                                                            'bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white': isActive(
                                                                                'bold', updatedAt)
                                                                        }">
                                                                    <svg class="h-4 w-4"
                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                         fill="currentColor"
                                                                         width="24"
                                                                         height="24"
                                                                         viewBox="0 0 16 16">
                                                                        <path
                                                                              d="M8.21 13c2.106 0 3.412-1.087 3.412-2.823 0-1.306-.984-2.283-2.324-2.386v-.055a2.176 2.176 0 0 0 1.852-2.14c0-1.51-1.162-2.46-3.014-2.46H3.843V13zM5.908 4.674h1.696c.963 0 1.517.451 1.517 1.244 0 .834-.629 1.32-1.73 1.32H5.908V4.673zm0 6.788V8.598h1.73c1.217 0 1.88.492 1.88 1.415 0 .943-.643 1.449-1.832 1.449H5.907z" />
                                                                    </svg>

                                                                    <span class="sr-only">Bold</span>
                                                                </button>
                                                                <button class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                                                        type="button"
                                                                        x-on:click="toggleItalic()"
                                                                        :class="{
                                                                            'bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white': isActive(
                                                                                'italic', updatedAt)
                                                                        }">
                                                                    <svg class="h-4 w-4"
                                                                         aria-hidden="true"
                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                         width="24"
                                                                         height="24"
                                                                         fill="none"
                                                                         viewBox="0 0 24 24">
                                                                        <path stroke="currentColor"
                                                                              stroke-linecap="round"
                                                                              stroke-linejoin="round"
                                                                              stroke-width="2"
                                                                              d="m8.874 19 6.143-14M6 19h6.33m-.66-14H18" />
                                                                    </svg>

                                                                    <span class="sr-only">Italic</span>
                                                                </button>
                                                                <button class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                                                        type="button"
                                                                        x-on:click="toggleUnderline()"
                                                                        :class="{
                                                                            'bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white': isActive(
                                                                                'underline', updatedAt)
                                                                        }">
                                                                    <svg class="h-4 w-4"
                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                         fill="currentColor"
                                                                         width="24"
                                                                         height="24"
                                                                         viewBox="0 0 16 16">
                                                                        <path
                                                                              d="M5.313 3.136h-1.23V9.54c0 2.105 1.47 3.623 3.917 3.623s3.917-1.518 3.917-3.623V3.136h-1.23v6.323c0 1.49-.978 2.57-2.687 2.57s-2.687-1.08-2.687-2.57zM12.5 15h-9v-1h9z" />
                                                                    </svg>

                                                                    <span class="sr-only">Underline</span>
                                                                </button>
                                                                <button class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                                                        type="button"
                                                                        x-on:click="toggleStrike()"
                                                                        :class="{
                                                                            'bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white': isActive(
                                                                                'strike', updatedAt)
                                                                        }">
                                                                    <svg class="h-4 w-4"
                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                         fill="currentColor"
                                                                         viewBox="0 0 16 16">
                                                                        <path
                                                                              d="M6.333 5.686c0 .31.083.581.27.814H5.166a2.8 2.8 0 0 1-.099-.76c0-1.627 1.436-2.768 3.48-2.768 1.969 0 3.39 1.175 3.445 2.85h-1.23c-.11-1.08-.964-1.743-2.25-1.743-1.23 0-2.18.602-2.18 1.607zm2.194 7.478c-2.153 0-3.589-1.107-3.705-2.81h1.23c.144 1.06 1.129 1.703 2.544 1.703 1.34 0 2.31-.705 2.31-1.675 0-.827-.547-1.374-1.914-1.675L8.046 8.5H1v-1h14v1h-3.504c.468.437.675.994.675 1.697 0 1.826-1.436 2.967-3.644 2.967" />
                                                                    </svg>
                                                                    <span class="sr-only">Strikethrough</span>
                                                                </button>
                                                            </div>
                                                            <div
                                                                 class="flex flex-wrap items-center space-x-1 rtl:space-x-reverse sm:px-4">
                                                                <button class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                                                        type="button"
                                                                        x-on:click="toggleBulletList()"
                                                                        :class="{
                                                                            'bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white': isActive(
                                                                                'bulletList', updatedAt)
                                                                        }">
                                                                    <svg class="h-4 w-4"
                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                         fill="currentColor"
                                                                         viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd"
                                                                              d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                                                    </svg>
                                                                    <span class="sr-only">Add list</span>
                                                                </button>
                                                                <button class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                                                        type="button"
                                                                        x-on:click="toggleOrderedList()"
                                                                        :class="{
                                                                            'bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white': isActive(
                                                                                'orderedList', updatedAt)
                                                                        }">
                                                                    <svg class="h-4 w-4"
                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                         fill="currentColor"
                                                                         viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd"
                                                                              d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5" />
                                                                        <path
                                                                              d="M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635z" />
                                                                    </svg>
                                                                    <span class="sr-only">Add Number</span>
                                                                </button>
                                                            </div>
                                                            <div
                                                                 class="flex flex-wrap items-center space-x-1 rtl:space-x-reverse sm:ps-4">
                                                                <button class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                                                        type="button"
                                                                        x-on:click="undo()">
                                                                    <svg class="h-4 w-4"
                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                         fill="currentColor"
                                                                         viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd"
                                                                              d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z" />
                                                                        <path
                                                                              d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466" />
                                                                    </svg>
                                                                    <span class="sr-only">Undo</span>
                                                                </button>
                                                                <button class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                                                        type="button"
                                                                        x-on:click="redo()">
                                                                    <svg class="h-4 w-4"
                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                         fill="currentColor"
                                                                         viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd"
                                                                              d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                                                                        <path
                                                                              d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
                                                                    </svg>
                                                                    <span class="sr-only">Redo</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                                <div
                                                     class="relative border-b bg-white p-2.5 dark:border-gray-600 dark:bg-gray-700">
                                                    <div x-on:click="$el.querySelector('[contenteditable]').focus()" class="cursor-text min-h-24 block h-full w-full border-0 bg-white px-0 text-sm text-gray-800 focus:ring-0 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                                         placeholder="Assignment detail for assignee"
                                                         x-ref="element">
                                                    </div>
                                                    <input class="pointer-events-none absolute top-2 opacity-0"
                                                           :name="'details[' + index + ']'"
                                                           required
                                                           x-model="content"></input>
                                                </div>
                                                <p
                                                   class="px-1.5 py-0.5 text-right text-xs font-normal text-gray-500 dark:text-gray-400">
                                                    <span x-text="characters"></span>
                                                    / 2000
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="ml-2"
                                         x-show="elementsCount > 1">
                                        <button class="inline-flex rounded-lg border border-gray-200 bg-white p-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                                                type="button"
                                                x-on:click="removeElement">
                                            <svg class="h-4 w-4"
                                                 aria-hidden="true"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 fill="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                      d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                      clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                            </div>
                        </div>
                    </template>
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

    function appendAssigneeField() {
        return {
            elementsCount: 0, // Track the number of elements

            addElement() {
                const container = document.getElementById("dynamic-assignee-field");
                const template = this.$refs.templateElement.content.cloneNode(true);

                container.appendChild(template);
                this.updateIndexes();
                this.elementsCount++;
                initializeTomSelects();
            },
            removeElement(event) {
                const element = event.target.closest(".element");
                if (element) {
                    element.remove();
                    this.elementsCount--;
                    this.updateIndexes();
                }
            },
            updateIndexes() {
                const elements = document.querySelectorAll("#dynamic-assignee-field .element");
                elements.forEach((element, index) => {
                    const newIndex = {
                        index: index,
                    };
                    // Update the x-data attribute with a new value
                    element.setAttribute('x-data', JSON.stringify(newIndex));

                    // Manipulate label
                    if (elements.length > 1) {
                        element.querySelector(".assignee-label").textContent = `Assignee ${index + 1}`;
                        element.querySelector(".detail-label").textContent = `Detail`;
                    } else {
                        element.querySelector(".assignee-label").textContent = `Assignee `;
                        element.querySelector(".detail-label").textContent = `Detail `;
                    }

                    // Show add assignee button
                    if (elements.length < 5 && index + 1 == elements.length) {
                        element.querySelector(".add-assignee").classList.remove('hidden');
                        element.querySelector(".add-assignee").classList.add('inline-flex');
                    } else {
                        element.querySelector(".add-assignee").classList.add('hidden');
                        element.querySelector(".add-assignee").classList.remove('inline-flex');
                    }
                });
            },
            init() {
                this.addElement();
            }
        };
    }
</script>

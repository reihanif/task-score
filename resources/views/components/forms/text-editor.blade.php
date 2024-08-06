@if ($attributes->has('label'))
    <div class="cursor-default mb-2 block text-sm font-medium text-gray-900 dark:text-white">
        {{ $attributes->get('label') }}
        @if ($attributes->has('required'))
            <span class="text-red-600 dark:text-red-500">*</span>
        @endif
    </div>
@endif
<div class="mb-4"
    x-data="editor('{{ $attributes->get('value') ? Str::of($attributes->get('value'))->toHtmlString : '' }}')">
    <div class="h-fit w-full rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">
        <template x-if="isLoaded()">
            <div class="flex items-center justify-between border-b px-3 py-2 dark:border-gray-600">
                <div
                    class="flex flex-wrap items-center divide-gray-200 dark:divide-gray-600 sm:divide-x sm:rtl:divide-x-reverse">
                    <div class="flex items-center space-x-1 rtl:space-x-reverse sm:pe-4">
                        <button
                            class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                            type="button"
                            x-on:click="toggleBold()"
                            :class="{
                                'bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white': isActive('bold',
                                    updatedAt)
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
                        <button
                            class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                            type="button"
                            x-on:click="toggleItalic()"
                            :class="{
                                'bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white': isActive('italic',
                                    updatedAt)
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
                        <button
                            class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                            type="button"
                            x-on:click="toggleUnderline()"
                            :class="{
                                'bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white': isActive('underline',
                                    updatedAt)
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
                        <button
                            class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                            type="button"
                            x-on:click="toggleStrike()"
                            :class="{
                                'bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white': isActive('strike',
                                    updatedAt)
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
                    <div class="flex flex-wrap items-center space-x-1 rtl:space-x-reverse sm:px-4">
                        <button
                            class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                            type="button"
                            x-on:click="toggleBulletList()"
                            :class="{
                                'bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white': isActive('bulletList',
                                    updatedAt)
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
                        <button
                            class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                            type="button"
                            x-on:click="toggleOrderedList()"
                            :class="{
                                'bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white': isActive('orderedList',
                                    updatedAt)
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
                    <div class="flex flex-wrap items-center space-x-1 rtl:space-x-reverse sm:ps-4">
                        <button
                            class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
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
                        <button
                            class="cursor-pointer rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
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
        <div class="relative border-b dark:border-gray-600 bg-white p-2.5 dark:bg-gray-700">
            <div x-on:click="$el.querySelector('[contenteditable]').focus()" class="cursor-text min-h-24 block h-full w-full border-0 bg-white px-0 text-sm text-gray-800 focus:ring-0 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                placeholder="{{ $attributes->get('placeholder') }}"
                x-ref="element">
            </div>
            <input class="absolute pointer-events-none top-2 opacity-0"
                {{ $attributes }}
                x-model="content">
        </div>
        <p class="py-0.5 px-1.5 text-xs text-right font-normal text-gray-500 dark:text-gray-400">
            <span x-text="characters"></span>
            / 2000
        </p>
    </div>
</div>

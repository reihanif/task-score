<th {{ $attributes }}>
    <div class="flex items-center">
        <span class="grow">
            {{ $slot }}
        </span>
        @if ($attributes->get('data-dt-order') !== 'disable')
            <span class="ms-2 text-gray-300 dark:text-gray-500">
                <svg class="sort-asc h-3 w-3"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M5.575 13.729C4.501 15.033 5.43 17 7.12 17h9.762c1.69 0 2.618-1.967 1.544-3.271l-4.881-5.927a2 2 0 0 0-3.088 0l-4.88 5.927Z"
                        clip-rule="evenodd" />
                </svg>
                <svg class="sort-desc h-3 w-3"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M18.425 10.271C19.499 8.967 18.57 7 16.88 7H7.12c-1.69 0-2.618 1.967-1.544 3.271l4.881 5.927a2 2 0 0 0 3.088 0l4.88-5.927Z"
                        clip-rule="evenodd" />
                </svg>
            </span>
        @endif
    </div>
</th>

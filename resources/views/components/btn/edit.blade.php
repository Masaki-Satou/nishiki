<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex justify-center items-center px-4 py-2 bg-blue-200 border border-transparent rounded-md font-semibold text-sm text-blue-500 uppercase tracking-widest hover:bg-blue-300 active:bg-blue-300 focus:outline-none focus:ring ring-gray-100 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

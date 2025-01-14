@php
    function stringToColorCode($str)
    {
        $code = dechex(crc32($str));
        $code = substr($code, 0, 6);
        return '#ff0000';
    }

    function getContrastYIQ($hexcolor)
    {
        $r = hexdec(substr($hexcolor, 1, 2));
        $g = hexdec(substr($hexcolor, 3, 2));
        $b = hexdec(substr($hexcolor, 5, 2));
        $yiq = ($r * 299 + $g * 587 + $b * 114) / 1000;
        return $yiq >= 128 ? 'black' : 'white';
    }

    $initials =
        strtoupper(substr(Auth::user()->name, 0, 1)) . strtoupper(substr(strstr(Auth::user()->name, ' '), 1, 1));
    $bgColor = stringToColorCode(Auth::user()->name);
    $textColor = getContrastYIQ($bgColor);
@endphp

<nav class="bg-red-500 px-4 py-2.5 fixed left-0 right-0 top-0 z-50">
    <div class="flex flex-wrap justify-between items-center">
        <div class="flex justify-start items-center">
            <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                aria-controls="drawer-navigation"
                class="p-2 mr-2 text-white rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100">
                <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                <svg aria-hidden="true" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Toggle sidebar</span>
            </button>
            <a href="/" class="flex items-center justify-between mr-4">
                <img src="{{ asset('assets/img/JMCkotak.png') }}" class="mr-3 h-8" alt="Flowbite Logo" />
                <span class="self-center text-white text-2xl font-bold whitespace-nowrap">JMC</span>
            </a>
        </div>
        <div class="flex items-center lg:order-2">
            <button type="button"
                class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                <span class="sr-only">Open user menu</span>
                <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden rounded-full"
                    style="background-color: {{ $bgColor }};">
                    <span class="font-bold" style="color: {{ $textColor }};">
                        {{ $initials }}</span>
                </div>
            </button>
            <!-- Dropdown menu -->
            <div class="hidden z-50 my-4 w-56 text-base list-none bg-white divide-y divide-gray-100 shadow rounded-xl"
                id="dropdown">
                <div class="py-3 px-4">
                    <span class="block text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</span>
                    <span class="block text-sm text-gray-900 truncate">{{ Auth::user()->email }}</span>
                </div>
                <ul class="py-1 text-gray-700" aria-labelledby="dropdown">
                    <li>
                        <a href="{{ route('logout') }}" id="logout-link"
                            class="block py-2 px-4 text-sm hover:bg-gray-100">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<script>
    document.getElementById('logout-link').addEventListener('click', function(event) {
        sessionStorage.clear();
        localStorage.clear();
    });
</script>

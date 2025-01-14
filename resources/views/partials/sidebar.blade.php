<aside
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-red-500 text-white md:translate-x-0"
    aria-label="Sidenav" id="drawer-navigation">
    <div class="overflow-y-auto py-5 px-3 h-full bg-red-500 text-white">
        <ul class="space-y-2">
            <li>
                <button type="button"
                    class="@if (Route::is('kmeans_aki.index') || Route::is('kmeans_akb.index')) bg-white text-red-500 @else text-white @endif flex items-center p-2 w-full text-base font-medium rounded-lg transition duration-75 group hover:text-red-500 hover:bg-white"
                    aria-controls="dropdown-kmeans" data-collapse-toggle="dropdown-kmeans" id="kmeans-menu-button">
                    <svg aria-hidden="true"
                        class="@if (Route::is('kmeans_aki.index') || Route::is('kmeans_akb.index')) text-red-500 @else text-white @endif flex-shrink-0 w-6 h-6 transition duration-75 group-hover:text-red-500"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm4 4a1 1 0 012 0v2a1 1 0 11-2 0V8zm0 4a1 1 0 012 0v2a1 1 0 11-2 0v-2z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">K-Means Clustering</span>
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-kmeans" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('kmeans_aki.index') }}"
                            class="@if (Route::is('kmeans_aki.index')) bg-white text-red-500 @else text-white @endif flex items-center p-2 pl-11 w-full text-base font-medium rounded-lg transition duration-75 group hover:bg-white hover:text-red-500">
                            K-Means AKI
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kmeans_akb.index') }}"
                            class="@if (Route::is('kmeans_akb.index')) bg-white text-red-500 @else text-white @endif flex items-center p-2 pl-11 w-full text-base font-medium rounded-lg transition duration-75 group hover:bg-white hover:text-red-500">
                            K-Means AKB
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</aside>
<script>
    document.getElementById('kmeans-menu-button').addEventListener('click', function() {
        const dropdown = document.getElementById('dropdown-kmeans');
        dropdown.classList.toggle('hidden');
    });
</script>

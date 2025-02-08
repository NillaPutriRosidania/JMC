<footer class="bg-white pt-20 pb-12" id="footer">
    <div class="container">
        <div class="flex flex-wrap justify-between w-full lg:flex-nowrap">
            <div class="flex flex-col items-center justify-center w-full mb-10 lg:-mt-16 lg:w-1/3">
                <img src="{{ asset('assets/img/JMCkotak.png') }}" alt="logo" width="200px"
                    class="flex items-center justify-center mb-6" />
                <button class="px-6 py-3 font-bold text-white bg-gradient-to-r from-red-600 via-red-500 to-orange-500 rounded-full shadow-xl cursor-not-allowed flex items-center gap-2 animate-pulse border border-red-700">
                    <svg class="w-6 h-6 text-white animate-bounce" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 10l4.553-2.276A2 2 0 0122 9.618V16a2 2 0 01-1.447 1.894L15 20m-6 0l-5.553-2.276A2 2 0 012 16V9.618a2 2 0 011.447-1.894L9 6m6 0V4a2 2 0 00-2-2h-2a2 2 0 00-2 2v2m6 0h-6">
                        </path>
                    </svg>
                    <span id="visitorCount">0</span> Pengunjung
                </button>
            </div>
            <div class="flex flex-col items-center justify-end w-full lg:flex-row">
                <div class="w-full mb-12 md:w-1/2 lg:h-32">
                    <h3 class="font-semibold text-xl text-dark mb-5 text-center">Location</h3>
                    <ul class="text-dark text-center">
                        <li>
                            <a href="/" class="inline-block text-base hover:text-primary mb-3 duration-500">Jalan
                                Srikoyo 1 No. 3 Patrang, Krajan, Bintoro, Kec. Patrang, Kabupaten Jember, Jawa Timur
                                68111
                        </li>
                    </ul>
                </div>
                <div class="w-full px-4 mb-12 md:w-1/3 lg:h-32">
                    <ul class="text-dark text-center">
                        <li>
                            <a href="/" class="inline-block text-base hover:text-primary mb-3 duration-500">
                        </li>
                    </ul>
                    <ul class="text-dark text-center">
                        <li>
                            <a href="#"
                                class="inline-block text-base bg-primary p-2 rounded-lg text-white hover:bg-transparent hover:border-2 hover:border-primary hover:text-primary mb-3 duration-500">Follow
                                It</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="w-full pt-10 border-t border-slate-700">
            <p class="font-medium text-sm text-black text-center">@copyright 2025 | <a href="#" target="_blank"
                    class="font-bold text-primary">Jember Maternal Cluster (JMC)</a></p>
        </div>
    </div>
</footer>
<script>
    let views = localStorage.getItem('page_views') || 0;
    views++;
    localStorage.setItem('page_views', views);
    document.getElementById('visitorCount').textContent = views;
</script>


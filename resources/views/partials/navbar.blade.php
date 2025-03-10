<header class="bg-white fixed top-0 left-0 w-full flex items-center shadow-lg z-50">
    <div class="container">
        <div class="flex justify-between">
            <div class="flex items-center px-4">
                <a href="" class="logo">
                    <img src="{{ asset('assets/img/logo_panjang_polije.png') }}" alt="Logo SITIK" width="300" />
                </a>
                <a href="" class="logo">
                    <img src="{{ asset('assets/img/JMCkotak.png') }}" alt="Logo SITIK" width="100" />
                </a>
            </div>
            <div class="flex items-center px-4">
                <button id="hamburger" name="hamburger" type="button" class="block absolute right-4 lg:hidden">
                    <span class="hamburger-line transition duration-100 ease-in-out origin-top-left"></span>
                    <span class="hamburger-line transition duration-100 ease-in-out"></span>
                    <span class="hamburger-line transition duration-100 ease-in-out origin-bottom-left"></span>
                </button>
                <nav id="nav-menu"
                    class="hidden absolute py-5 bg-white shadow-lg rounded-lg max-w-[250px] w-full right-4 top-full lg:block lg:static lg:bg-white lg:max-w-full lg:shadow-none lg:rounded-none">
                    <ul class="block lg:flex">
                        <li class="group">
                            <a href="#home" class="text-base text-primary py-2 mx-5 flex">Beranda</a>
                        </li>
                        <li class="group">
                            <a href="#tentang"
                                class="text-base text-dark py-2 mx-5 flex group-hover:text-primary group-hover:duration-700">Tentang
                                Kami</a>
                        </li>
                        <li class="group">
                            <a href="#layanan"
                                class="text-base text-dark py-2 mx-5 flex group-hover:text-primary group-hover:duration-700">Layanan</a>
                        </li>
                        <li class="group">
                            <a href="#carakerja"
                                class="text-base text-dark py-2 ml-5 mr-12 flex group-hover:text-primary group-hover:duration-700">Cara
                                Kerja</a>
                        </li>
                        <li class="group">
                            <a href="{{ route('login') }}"
                                class="text-base flex justify-center text-center text-primary border-2 border-primary rounded-xl py-2 px-9 hover:bg-primary hover:text-white duration-500">Masuk</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>

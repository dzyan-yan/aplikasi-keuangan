<nav class="topbar">

    {{-- Judul halaman --}}
    <div>
        <h5 class="mb-0 fw-semibold">
            @yield('page-title', 'Dashboard')
        </h5>
    </div>


    {{-- User Dropdown --}}
    <div class="dropdown">

        <button
            class="btn btn-light d-flex align-items-center gap-2 border-0"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false">

            <i class="bi bi-person-circle fs-4 text-primary"></i>

            <span class="d-none d-md-inline">
                {{ session('admin_nama') }}
            </span>

            <i class="bi bi-chevron-down small"></i>

        </button>


        <ul class="dropdown-menu dropdown-menu-end shadow-sm">

            {{-- Nama User --}}
            <li>
                <div class="dropdown-header">

                    <div class="fw-semibold">
                        {{ session('admin_nama') }}
                    </div>

                    <small class="text-muted">
                        Administrator
                    </small>

                </div>
            </li>


            <li>
                <hr class="dropdown-divider">
            </li>


            {{-- Profil --}}
            <li>

                <a
                    class="dropdown-item"
                    href="#">

                    <i class="bi bi-person me-2"></i>
                    Profil

                </a>

            </li>


            {{-- Pengaturan --}}
            <li>

                <a
                    class="dropdown-item"
                    href="#">

                    <i class="bi bi-gear me-2"></i>
                    Pengaturan

                </a>

            </li>


            <li>
                <hr class="dropdown-divider">
            </li>


            {{-- Logout --}}
            <li>

                <form
                    action="{{ route('logout') }}"
                    method="POST">

                    @csrf

                    <button
                        type="submit"
                        class="dropdown-item text-danger">

                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout

                    </button>

                </form>

            </li>

        </ul>

    </div>

</nav>
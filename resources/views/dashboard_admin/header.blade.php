    <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Chào mừng, {{ Auth::guard('admins')->user()->name }}</span>
                </li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger"><i class="fa fa-sign-out"></i> Log out</button>
                    </form>
                </li>
            </ul>

        </nav>
    </div>
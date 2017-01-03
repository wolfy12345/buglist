<ul class="nav navbar-nav side-nav" id="sidebar">

    <li class="collapsed-content">
        <ul>
            <li class="search"><!-- Collapsed search pasting here at 768px --></li>
        </ul>
    </li>

    <li class="navigation" id="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="#navigation">Navigation <i class="fa fa-angle-up"></i></a>

        <ul class="menu">
            @role("ADMIN")
            <li>
                <a href="/user">
                    <i class="fa fa-tachometer"></i> 用户管理
                    <span class="badge badge-red">1</span>
                </a>
            </li>
            @endrole
            <li class="dropdown">
                <a href="/bug">
                    <i class="fa fa-tachometer"></i> Bug管理
                </a>
            </li>
        </ul>
    </li>

</ul>
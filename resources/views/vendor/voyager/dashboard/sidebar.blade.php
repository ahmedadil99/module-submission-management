<div class="side-menu sidebar-inverse">
    <nav class="navbar navbar-default" role="navigation">
        <div class="side-menu-container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('voyager.dashboard') }}">
                    <div class="logo-icon-container">
                        <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                        @if($admin_logo_img == '')
                            <img src="{{ voyager_asset('images/logo-icon-light.png') }}" alt="Logo Icon">
                        @else
                            <img src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
                        @endif
                    </div>
                    <div class="title">{{Voyager::setting('admin.title', 'VOYAGER')}}</div>
                </a>
            </div><!-- .navbar-header -->

            <div class="panel widget center bgimage"
                 style="background-image:url({{ Voyager::image( Voyager::setting('admin.bg_image'), voyager_asset('images/bg.jpg') ) }}); background-size: cover; background-position: 0px;">
                <div class="dimmer"></div>
                <div class="panel-content">
                    <img src="{{ $user_avatar }}" class="avatar" alt="{{ Auth::user()->name }} avatar">
                    <h4>{{ ucwords(Auth::user()->name) }}</h4>
                    <p>{{ Auth::user()->email }}</p>
                    
                    <a href="{{ route('voyager.profile') }}" class="btn btn-primary">{{ __('voyager::generic.profile') }}</a>
                    <div style="clear:both"></div>
                </div>
            </div>

        </div>
        <div id="adminmenu">
            @if(Auth::user()->role()->get()->first()->name == 'Agent')
                <div id="adminmenu">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a target="_self" href="/admin/agent/my-articles"><span class="icon voyager-study"></span> <span class="title">My Articles</span></a> <!---->
                        </li>
                        <li class="">
                            <a target="_self" href="/admin/agent/writers-list"><span class="icon voyager-people"></span> <span class="title">Writers List</span></a> <!---->
                        </li>
                    </ul>
                </div>
            @elseif(Auth::user()->role()->get()->first()->name == 'Writer')
                <div id="adminmenu">
                        <ul class="nav navbar-nav">
                            <li class="">
                                <a target="_self" href="/admin/articles"><span class="icon voyager-study"></span> <span class="title">My Articles</span></a> <!---->
                            </li>
                            <li class="">
                                <a target="_self" href="/admin/agents"><span class="icon voyager-people"></span> <span class="title">Agents List</span></a> <!---->
                            </li>
                            
                        </ul>
                </div>
            @elseif(Auth::user()->role()->get()->first()->name == 'Publisher')
                <div id="adminmenu">
                        <ul class="nav navbar-nav">
                            <li class="">
                                <a target="_self" href="/admin/publisher-articles"><span class="icon voyager-study"></span> <span class="title">My Articles</span></a> <!---->
                            </li>
                            <li class="">
                                <a target="_self" href="/admin/publisher-agents-list"><span class="icon voyager-people"></span> <span class="title">Agents List</span></a> <!---->
                            </li>
                        </ul>
                </div>
            @else
                <admin-menu :items="{{ menu('admin', '_json') }}"></admin-menu>
            @endif
            
        </div>
    </nav>
</div>

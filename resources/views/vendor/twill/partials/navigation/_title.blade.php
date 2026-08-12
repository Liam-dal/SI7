<h1 class="header__title">
    <a href={{ config('twill.enabled.dashboard') ? route(config('twill.admin_route_name_prefix') . 'dashboard') : '#' }}>
        SI7 admin
        @unless(app()->environment('production'))
            <span class="envlabel">{{ app()->environment() }}</span>
        @endunless
    </a>
</h1>

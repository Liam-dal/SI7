<?php

use A17\Twill\Facades\TwillRoutes;

// Register Twill routes here eg.
// TwillRoutes::module('posts');

TwillRoutes::module('projects');
TwillRoutes::module('categories');
TwillRoutes::module('sectors');
TwillRoutes::module('people');
TwillRoutes::module('teamRoles');
TwillRoutes::module('offices');
TwillRoutes::module('homepageFeatureSections');
TwillRoutes::singleton('homepage');
TwillRoutes::singleton('about');
TwillRoutes::singleton('contact');
TwillRoutes::module('downloads');
TwillRoutes::singleton('siteSetting');

TwillRoutes::module('guides');
TwillRoutes::module('guideCategories');
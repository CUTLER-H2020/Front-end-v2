<?php

return \App\Models\LanguageSetting::get()->pluck('en', 'key');

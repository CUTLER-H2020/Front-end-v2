<?php

return \App\Models\LanguageSetting::get()->pluck('gr', 'key');
